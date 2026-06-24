<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PortalController extends Controller
{
    /**
     * Display the student portal homepage.
     */
    public function index()
    {
        $projectsPath = resource_path('data/projects.json');
        $projects = [];
        
        if (file_exists($projectsPath)) {
            $projects = json_decode(file_get_contents($projectsPath), true);
        }

        // Get approved/taken projects to show availability in real-time
        $approvedProjects = Candidatura::where('status', 'Aprovado')
            ->pluck('project_number')
            ->toArray();

        return view('portal', compact('projects', 'approvedProjects'));
    }

    /**
     * Handle a new project application submission from a student group.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'project_number' => 'required|integer',
            'project_name' => 'required|string',
            'technology' => 'required|string',
            'mentor' => 'nullable|string|max:100',
            'member1_name' => 'required|string|max:150',
            'member1_code' => 'required|string|max:50',
            'member2_name' => 'required|string|max:150',
            'member2_code' => 'required|string|max:50',
            'member3_name' => 'nullable|string|max:150',
            'member3_code' => 'nullable|string|max:50',
            'member4_name' => 'nullable|string|max:150',
            'member4_code' => 'nullable|string|max:50',
            'rationale' => 'required|string|min:20',
        ], [
            'member1_name.required' => 'O nome do Líder do Grupo (Estudante 1) é obrigatório.',
            'member1_code.required' => 'O código de estudante do Líder é obrigatório.',
            'member2_name.required' => 'O nome do Estudante 2 é obrigatório.',
            'member2_code.required' => 'O código de estudante do Estudante 2 é obrigatório.',
            'rationale.required' => 'A justificativa do projeto é obrigatória para submissão.',
            'rationale.min' => 'Explique a justificativa do projeto com mais detalhes (mínimo 20 caracteres).',
        ]);

        // Create the application
        $candidatura = Candidatura::create([
            'project_number' => $request->project_number,
            'project_name' => $request->project_name,
            'technology' => $request->technology,
            'mentor' => $request->mentor,
            'member1_name' => $request->member1_name,
            'member1_code' => $request->member1_code,
            'member2_name' => $request->member2_name,
            'member2_code' => $request->member2_code,
            'member3_name' => $request->member3_name,
            'member3_code' => $request->member3_code,
            'member4_name' => $request->member4_name,
            'member4_code' => $request->member4_code,
            'rationale' => $request->rationale,
            'status' => 'Pendente',
        ]);

        // Build Markdown Proposal text to show to the students
        $proposalMarkdown = "### FICHA DE INSCRIÇÃO DE PROJECTO - DIA DA INFORMÁTICA / JORNADAS CIENTÍFICAS\n";
        $proposalMarkdown .= "------------------------------------------------------------\n";
        $proposalMarkdown .= "**ID da Candidatura:** #{$candidatura->id}\n";
        $proposalMarkdown .= "**Projecto Escolhido:** #{$candidatura->project_number} - {$candidatura->project_name}\n";
        $proposalMarkdown .= "**Tecnologia Seleccionada:** {$candidatura->technology}\n";
        $proposalMarkdown .= "**Mentor Sugerido (Finalista):** " . ($candidatura->mentor ?: "Sem mentor definido") . "\n\n";
        
        $proposalMarkdown .= "#### INTEGRANTES DO GRUPO (1.º ANO):\n";
        $proposalMarkdown .= "1. {$candidatura->member1_name} (Líder) - N.º: {$candidatura->member1_code}\n";
        $proposalMarkdown .= "2. {$candidatura->member2_name} - N.º: {$candidatura->member2_code}\n";
        if ($candidatura->member3_name) {
            $proposalMarkdown .= "3. {$candidatura->member3_name} - N.º: {$candidatura->member3_code}\n";
        }
        if ($candidatura->member4_name) {
            $proposalMarkdown .= "4. {$candidatura->member4_name} - N.º: {$candidatura->member4_code}\n";
        }
        $proposalMarkdown .= "\n";
        
        $proposalMarkdown .= "#### JUSTIFICATIVA LOCAL (QUELIMANE):\n";
        $proposalMarkdown .= "{$candidatura->rationale}\n\n";
        
        $proposalMarkdown .= "#### ESTADO DA CANDIDATURA:\n";
        $proposalMarkdown .= "[ ] Pendente   [ ] Aprovado   [ ] Rejeitado\n";
        $proposalMarkdown .= "------------------------------------------------------------\n";
        $proposalMarkdown .= "Submetido em: " . $candidatura->created_at->format('d/m/Y H:i:s') . "\n";
        $proposalMarkdown .= "Entregar ao docente Filipe para homologação final.";

        return redirect()->back()->with([
            'success' => 'Candidatura submetida com sucesso no sistema!',
            'proposal' => $proposalMarkdown,
            'project_name' => $candidatura->project_name
        ]);
    }

    /**
     * Display the Admin Login Form.
     */
    public function loginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin-login');
    }

    /**
     * Process Admin Login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $envPassword = env('ADMIN_PASSWORD', 'fdsms@2025');

        if ($request->password === $envPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['password' => 'Senha de administração incorreta.']);
    }

    /**
     * Process Admin Logout.
     */
    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('portal.index');
    }

    /**
     * Display the Admin Dashboard with all candidaturas.
     */
    public function adminDashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $candidaturas = Candidatura::orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total' => $candidaturas->count(),
            'pendente' => $candidaturas->where('status', 'Pendente')->count(),
            'aprovado' => $candidaturas->where('status', 'Aprovado')->count(),
            'rejeitado' => $candidaturas->where('status', 'Rejeitado')->count(),
        ];

        return view('admin-dashboard', compact('candidaturas', 'stats'));
    }

    /**
     * Update the status of a project candidature.
     */
    public function updateStatus(Request $request, Candidatura $candidatura)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        $request->validate([
            'status' => 'required|in:Pendente,Aprovado,Rejeitado',
        ]);

        $candidatura->update([
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $candidatura->status,
                'message' => "Estado da candidatura #{$candidatura->id} atualizado para '{$candidatura->status}'."
            ]);
        }

        return redirect()->back()->with('success', "Estado da candidatura atualizado para {$candidatura->status}.");
    }
}
