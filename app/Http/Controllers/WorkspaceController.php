<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function loginForm()
    {
        return view('workspace.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'contact_email' => 'required|email',
            'group_password' => 'required',
        ]);

        $candidatura = \App\Models\Candidatura::where('contact_email', $request->contact_email)
            ->where('status', 'Aprovado')
            ->first();

        if (!$candidatura) {
             return back()->with('error', 'Nenhum projeto aprovado com este email.');
        }

        if (\Hash::check($request->group_password, $candidatura->group_password)) {
            session(['workspace_logged_in_' . $candidatura->id => true]);
            return redirect()->route('workspace.index', $candidatura->id);
        }

        return back()->with('error', 'Senha incorreta. Tente novamente.');
    }

    public function recoverPinForm($id)
    {
        $candidatura = \App\Models\Candidatura::findOrFail($id);
        return view('workspace.recover-pin', compact('candidatura'));
    }

    public function recoverPinSubmit(Request $request, $id)
    {
        $request->validate([
            'contact_email' => 'required|email',
        ]);

        $candidatura = \App\Models\Candidatura::findOrFail($id);

        if (strtolower($candidatura->contact_email) !== strtolower($request->contact_email)) {
            return back()->with('error', 'O email fornecido não corresponde ao email de contacto do grupo.');
        }

        // Generate a new PIN
        $newPin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $candidatura->update([
            'group_password' => bcrypt($newPin)
        ]);

        // Send Email
        \Illuminate\Support\Facades\Mail::raw("Olá {$candidatura->member1_name},\n\nO novo PIN de acesso para o vosso projeto '{$candidatura->project_name}' é: {$newPin}\n\nPor favor, aceda à plataforma para continuar.\n\nCumprimentos,\nUniLicungo TechHub", function ($message) use ($candidatura) {
            $message->to($candidatura->contact_email)
                    ->subject('Recuperação de PIN - UniLicungo TechHub');
        });

        return redirect()->route('workspace.login', ['project_number' => $candidatura->project_number])
            ->with('success', 'Um novo PIN foi enviado para o vosso email de contacto.');
    }

    public function index($id)
    {
        $candidatura = \App\Models\Candidatura::with(['workspaceMessages', 'progressos', 'ficheiros'])->findOrFail($id);

        // Check if student is logged into this workspace or if admin/docente is logged in
        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();

        if (!$isStudent && !$isAdmin) {
            return redirect()->route('workspace.login', ['project_number' => $candidatura->project_number])
                ->with('error', 'Faça login para aceder ao workspace.');
        }

        if ($isAdmin) {
            \App\Models\WorkspaceMessage::where('candidatura_id', $id)
                ->where('sender_type', 'student')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } elseif ($isStudent) {
            \App\Models\WorkspaceMessage::where('candidatura_id', $id)
                ->where('sender_type', 'mentor')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        $messages = $candidatura->workspaceMessages()->orderBy('created_at', 'asc')->get();
        $isViewer = $isAdmin && auth()->user()->id !== $candidatura->docente_id;

        return view('workspace.index', compact('candidatura', 'messages', 'isStudent', 'isAdmin', 'isViewer'));
    }

    public function storeMessage(Request $request, $id)
    {
        $candidatura = \App\Models\Candidatura::findOrFail($id);

        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();

        if (!$isStudent && !$isAdmin) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $message = \App\Models\WorkspaceMessage::create([
            'candidatura_id' => $id,
            'sender_type' => $isAdmin ? 'mentor' : 'student',
            'message' => $request->message,
        ]);

        try {
            if ($isAdmin && $candidatura->contact_email) {
                \Illuminate\Support\Facades\Mail::raw("Recebeu uma nova mensagem do Mentor na plataforma UniLicungo TechHub.\n\nMensagem: " . $request->message . "\n\nAceda ao Workspace para responder.", function($msg) use ($candidatura) {
                    $msg->to($candidatura->contact_email)
                        ->subject('Nova Mensagem do Mentor - ' . $candidatura->project_name);
                });
            } elseif (!$isAdmin && $candidatura->docente && $candidatura->docente->email) {
                \Illuminate\Support\Facades\Mail::raw("O grupo {$candidatura->project_name} enviou uma nova mensagem na plataforma UniLicungo TechHub.\n\nMensagem: " . $request->message . "\n\nAceda ao painel para responder.", function($msg) use ($candidatura) {
                    $msg->to($candidatura->docente->email)
                        ->subject('Nova Mensagem do Grupo - ' . $candidatura->project_name);
                });
            }
        } catch (\Exception $e) {
            // Log if email fails, but do not interrupt chat
            \Illuminate\Support\Facades\Log::error('Erro ao enviar email de notificação de chat: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function poll(Request $request, $id)
    {
        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();
        if (!$isStudent && !$isAdmin) return response()->json([], 401);

        $lastId = $request->query('last_id', 0);
        $messages = \App\Models\WorkspaceMessage::where('candidatura_id', $id)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();
        if ($isAdmin) {
            \App\Models\WorkspaceMessage::where('candidatura_id', $id)
                ->where('id', '>', $lastId)
                ->where('sender_type', 'student')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } elseif ($isStudent) {
            \App\Models\WorkspaceMessage::where('candidatura_id', $id)
                ->where('id', '>', $lastId)
                ->where('sender_type', 'mentor')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
            
        return response()->json($messages);
    }

    public function actualizarFase(Request $request, $id)
    {
        if (!auth()->check()) return back();
        $request->validate([
            'fase' => 'required|in:sensibilizacao,campo,mvp,exposicao,artigo',
            'estado' => 'required|in:pendente,em_progresso,concluida',
            'mensagem' => 'nullable|string'
        ]);
        
        \App\Models\CandidaturaProgresso::updateOrCreate(
            ['candidatura_id' => $id, 'fase' => $request->fase],
            ['estado' => $request->estado, 'updated_by' => 'Docente']
        );
        
        if ($request->filled('mensagem')) {
            $faseLabel = [
                'sensibilizacao' => 'Sensibilização',
                'campo' => 'Campo',
                'mvp' => 'MVP',
                'exposicao' => 'Exposição',
                'artigo' => 'Artigo'
            ][$request->fase];
            
            $estadoLabel = [
                'pendente' => 'Pendente',
                'em_progresso' => 'Em Progresso',
                'concluida' => 'Concluída'
            ][$request->estado];

            $fullMsg = "🔔 **Atualização de Fase: {$faseLabel} ({$estadoLabel})**\n" . $request->mensagem;

            \App\Models\WorkspaceMessage::create([
                'candidatura_id' => $id,
                'sender_type' => 'mentor',
                'message' => $fullMsg,
                'is_read' => false
            ]);
        }
        
        return back()->with('success', 'Fase atualizada com sucesso.');
    }

    public function uploadFicheiro(Request $request, $id)
    {
        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();

        if (!$isStudent && !$isAdmin) {
            return back()->with('error', 'Não autorizado.');
        }

        $request->validate(['ficheiro' => 'required|file|max:10240']); // max 10MB
        $path = $request->file('ficheiro')->store("grupos/{$id}", 'public');
        \App\Models\CandidaturaFicheiro::create([
            'candidatura_id' => $id,
            'nome_ficheiro' => $request->file('ficheiro')->getClientOriginalName(),
            'caminho' => $path,
            'tamanho_bytes' => $request->file('ficheiro')->getSize(),
            'uploaded_by' => $isAdmin ? 'Docente Mentor' : 'Grupo Estudante'
        ]);
        return back()->with('success', 'Ficheiro partilhado com sucesso.');
    }

    public function downloadFicheiro($id)
    {
        $ficheiro = \App\Models\CandidaturaFicheiro::findOrFail($id);
        return response()->download(storage_path('app/public/' . $ficheiro->caminho), $ficheiro->nome_ficheiro);
    }

    // --- KANBAN METHODS ---
    public function getKanbanTasks(Request $request, $id)
    {
        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();
        if (!$isStudent && !$isAdmin) return response()->json([], 401);

        $tasks = \App\Models\KanbanTask::where('candidatura_id', $id)->get();
        return response()->json($tasks);
    }

    public function storeKanbanTask(Request $request, $id)
    {
        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();
        if (!$isStudent && !$isAdmin) return response()->json(['error' => 'Não autorizado'], 401);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,review,done'
        ]);

        $task = \App\Models\KanbanTask::create([
            'candidatura_id' => $id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => $isAdmin ? 'mentor' : 'student'
        ]);

        return response()->json($task);
    }

    public function updateKanbanTaskStatus(Request $request, $id, $taskId)
    {
        $isStudent = session('workspace_logged_in_' . $id);
        $isAdmin = auth()->check();
        if (!$isStudent && !$isAdmin) return response()->json(['error' => 'Não autorizado'], 401);

        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done'
        ]);

        $task = \App\Models\KanbanTask::where('candidatura_id', $id)->findOrFail($taskId);
        $task->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}
