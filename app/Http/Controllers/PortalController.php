<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        // Merge academic contents from config
        $academicContent = [];
        if (file_exists(config_path('conteudo_academico.php'))) {
            $academicContent = include config_path('conteudo_academico.php');
        }

        foreach ($projects as &$project) {
            $num = $project['number'];
            if (isset($academicContent[$num])) {
                $project['perguntas_artigo'] = $academicContent[$num]['perguntas'];
                $project['referencias_artigo'] = $academicContent[$num]['referencias'];
                $project['imrad_artigo'] = $academicContent[$num]['imrad'];
            } else {
                $project['perguntas_artigo'] = $this->getFallbackQuestions($project['sector'], $project['name']);
                $project['referencias_artigo'] = $this->getFallbackReferences($project['sector']);
                $project['imrad_artigo'] = $this->getFallbackImrad($project['sector'], $project['name']);
            }
        }
        unset($project); // Break reference

        // Calculate statistics dynamically from the JSON projects
        $sectors = [];
        $facilCount = 0;
        $medioCount = 0;
        $avancadoCount = 0;

        foreach ($projects as $project) {
            if (isset($project['sector'])) {
                $sectors[$project['sector']] = true;
            }
            $dificuldade = $project['dificuldade'] ?? '';
            if ($dificuldade === 'Fácil') {
                $facilCount++;
            } elseif ($dificuldade === 'Médio') {
                $medioCount++;
            } elseif ($dificuldade === 'Avançado') {
                $avancadoCount++;
            }
        }

        $stats = [
            'total'    => count($projects),
            'sectores' => count($sectors),
            'facil'    => $facilCount,
            'medio'    => $medioCount,
            'avancado' => $avancadoCount,
        ];

        // Get approved/taken projects to show availability in real-time
        $approvedProjects = Candidatura::where('status', 'Aprovado')
            ->pluck('project_number')
            ->toArray();

        // Inject approved own-idea projects into the catalog
        $ownIdeaProjects = Candidatura::where('project_number', '>=', 1000)
            ->where('status', 'Aprovado')
            ->get();

        foreach ($ownIdeaProjects as $ownIdea) {
            $projects[] = [
                'number' => $ownIdea->project_number,
                'name' => $ownIdea->project_name,
                'sector' => 'Ideia Própria',
                'dificuldade' => 'Médio',
                'descricao' => $ownIdea->rationale ?? 'Projeto proposto por estudante.',
                'tecnologias' => [$ownIdea->technology],
                'perguntas_artigo' => $this->getFallbackQuestions('Tecnologia', $ownIdea->project_name),
                'referencias_artigo' => $this->getFallbackReferences('Tecnologia'),
                'imrad_artigo' => $this->getFallbackImrad('Tecnologia', $ownIdea->project_name),
            ];
        }

        return view('portal', compact('projects', 'approvedProjects', 'stats'));
    }

    /**
     * Handle a new project application submission from a student group.
     */
    public function submit(Request $request)
    {
        $registrationType = $request->input('registration_type', 'group');
        $isOwnIdea = (int)$request->input('project_number') === 0;

        // Build validation rules dynamically
        $rules = [
            'project_number' => 'required|integer',
            'technology' => 'required|string',
            'mentor' => 'nullable|string|max:100',
            'member1_name' => 'required|string|max:150',
            'member1_code' => 'required|string|max:50',
            'contact_email' => 'required|email|max:150',
            'contact_phone' => 'nullable|string|max:50',
            'member3_name' => 'nullable|string|max:150',
            'member3_code' => 'nullable|string|max:50',
            'member4_name' => 'nullable|string|max:150',
            'member4_code' => 'nullable|string|max:50',
            'rationale' => 'required|string|min:20',
        ];

        // Conditional: group registration requires member2
        if ($registrationType === 'group') {
            $rules['member2_name'] = 'required|string|max:150';
            $rules['member2_code'] = 'required|string|max:50';
        } else {
            $rules['member2_name'] = 'nullable|string|max:150';
            $rules['member2_code'] = 'nullable|string|max:50';
        }

        // Conditional: own idea requires own_project_name
        if ($isOwnIdea) {
            $rules['own_project_name'] = 'required|string|max:200';
        } else {
            $rules['project_name'] = 'required|string';
        }

        $messages = [
            'member1_name.required' => 'O nome do Líder do Grupo (Estudante 1) é obrigatório.',
            'member1_code.required' => 'O código de estudante do Líder é obrigatório.',
            'contact_email.required' => 'O email de contacto é obrigatório para recuperação do PIN.',
            'contact_email.email' => 'Insira um email de contacto válido.',
            'member2_name.required' => 'O nome do Estudante 2 é obrigatório para inscrição em grupo.',
            'member2_code.required' => 'O código de estudante do Estudante 2 é obrigatório para inscrição em grupo.',
            'rationale.required' => 'A justificativa do projeto é obrigatória para submissão.',
            'rationale.min' => 'Explique a justificativa do projeto com mais detalhes (mínimo 20 caracteres).',
            'own_project_name.required' => 'Quando propõe a sua própria ideia, o nome do projeto é obrigatório.',
        ];

        $request->validate($rules, $messages);

        // Determine project name and number
        if ($isOwnIdea) {
            // Assign a sequential number starting from 1000 for own ideas
            $lastOwn = Candidatura::where('project_number', '>=', 1000)->max('project_number');
            $projectNumber = $lastOwn ? $lastOwn + 1 : 1000;
            $projectName = $request->own_project_name;
        } else {
            $projectNumber = $request->project_number;
            $projectName = $request->project_name;
        }

        // Generate a 6-digit random PIN
        $generatedPin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create the application
        $candidatura = Candidatura::create([
            'project_number' => $projectNumber,
            'project_name' => $projectName,
            'technology' => $request->technology,
            'mentor' => $request->mentor,
            'member1_name' => $request->member1_name,
            'member1_code' => $request->member1_code,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'member2_name' => $request->member2_name,
            'member2_code' => $request->member2_code,
            'member3_name' => $request->member3_name,
            'member3_code' => $request->member3_code,
            'member4_name' => $request->member4_name,
            'member4_code' => $request->member4_code,
            'rationale' => $request->rationale,
            'status' => 'Pendente',
            'group_password' => bcrypt($generatedPin),
        ]);

        // Store the PIN temporarily in session so it can be generated in the PDF
        session()->put('generated_pin_' . $candidatura->id, $generatedPin);
        session()->put('last_candidatura_id', $candidatura->id);

        $smsStatus = $this->sendPinSms($candidatura, $generatedPin, 'Registo concluído, mas');

        return redirect()->back()->with([
            'success' => 'Candidatura submetida com sucesso no sistema!',
            'candidatura_id' => $candidatura->id,
            'generated_pin' => $generatedPin,
            'project_name' => $candidatura->project_name,
            'sms_status' => $smsStatus,
        ]);
    }

    public function resendPin(Request $request, Candidatura $candidatura)
    {
        $sessionOwnsCandidatura = (int) session('last_candidatura_id') === (int) $candidatura->id;

        if (!$sessionOwnsCandidatura) {
            return redirect()
                ->route('workspace.recover-pin', $candidatura->id)
                ->with('error', 'Por segurança, confirme o contacto do grupo para reenviar o PIN.');
        }

        $pinSessionKey = 'generated_pin_' . $candidatura->id;
        $pin = session($pinSessionKey);

        if (!$pin) {
            $pin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $candidatura->update(['group_password' => bcrypt($pin)]);
            session()->put($pinSessionKey, $pin);
        }

        $smsStatus = $this->sendPinSms($candidatura, $pin, 'PIN não reenviado:');

        return redirect()->route('portal.index')->with([
            'success' => 'Pedido de reenvio processado.',
            'candidatura_id' => $candidatura->id,
            'generated_pin' => $pin,
            'project_name' => $candidatura->project_name,
            'sms_status' => $smsStatus,
        ]);
    }

    private function sendPinSms(Candidatura $candidatura, string $pin, string $failurePrefix): ?string
    {
        if (empty($candidatura->contact_phone)) {
            return 'Nenhum telemóvel foi registado para envio do PIN por SMS.';
        }

        try {
            [$sent, $message] = SmsService::sendSms(
                $candidatura->contact_phone,
                "UniLicungo TechHub: o PIN do projeto '{$candidatura->project_name}' e {$pin}. Guarde este codigo para aceder ao Workspace."
            );

            return $sent
                ? 'PIN enviado por SMS para o telemóvel registado.'
                : "{$failurePrefix} o SMS não foi enviado: {$message}";
        } catch (\Throwable $e) {
            Log::error('Failed to send PIN SMS: ' . $e->getMessage());
            return "{$failurePrefix} não foi possível enviar o SMS do PIN.";
        }
    }

    /**
     * Download the PDF credentials.
     */
    public function downloadPdf($id)
    {
        $candidatura = Candidatura::findOrFail($id);
        $pin = session('generated_pin_' . $candidatura->id, '****** (Já guardado)');
        
        // Find project details from JSON
        $projectsJson = \File::get(resource_path('data/projects.json'));
        $allProjects = json_decode($projectsJson, true);
        $projectDetails = null;
        foreach ($allProjects as $proj) {
            if ($proj['number'] == $candidatura->project_number) {
                $projectDetails = $proj;
                break;
            }
        }
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.comprovativo', compact('candidatura', 'pin', 'projectDetails'));
        return $pdf->download("Comprovativo_Workspace_Grupo{$candidatura->id}.pdf");
    }

    /**
     * Display the Admin Login Form.
     */
    public function loginForm()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin-login');
    }

    /**
     * Process Admin Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Credenciais incorretas.'])->withInput();
    }

    /**
     * Process Admin Logout.
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal.index');
    }

    /**
     * Display the Admin Dashboard with all candidaturas.
     */
    public function adminDashboard()
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();
        $docentes = collect();
        if ($user->role === 'admin' || $user->role === 'director_curso') {
            $candidaturas = Candidatura::with(['progressos', 'workspaceMessages', 'docente'])->orderBy('created_at', 'desc')->get();
            $docentes = \App\Models\User::where('role', 'docente')->get();
        } else {
            $candidaturas = Candidatura::with(['progressos', 'workspaceMessages', 'docente'])
                ->where('docente_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        $stats = [
            'total' => $candidaturas->count(),
            'pendente' => $candidaturas->where('status', 'Pendente')->count(),
            'aprovado' => $candidaturas->where('status', 'Aprovado')->count(),
            'rejeitado' => $candidaturas->where('status', 'Rejeitado')->count(),
        ];

        return view('admin-dashboard', compact('candidaturas', 'stats', 'docentes', 'user'));
    }

    /**
     * Update the status of a project candidature.
     */
    public function updateStatus(Request $request, Candidatura $candidatura)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
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

    public function updateDocente(Request $request, Candidatura $candidatura)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        $request->validate(['docente_id' => 'nullable|exists:users,id']);
        
        $candidatura->update(['docente_id' => $request->docente_id]);

        return response()->json(['success' => true]);
    }

    public function resetPin(Request $request, Candidatura $candidatura)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        $newPin = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $candidatura->update(['group_password' => \Hash::make($newPin)]);

        return response()->json([
            'success' => true,
            'new_pin' => $newPin,
            'message' => 'O novo PIN de acesso é: ' . $newPin
        ]);
    }

    public function updateCandidatura(Request $request, Candidatura $candidatura)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->back()->withErrors(['Apenas administradores podem editar.']);
        }

        $validated = $request->validate([
            'project_name' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'member1_name' => 'required|string',
            'member1_code' => 'required|string',
            'member2_name' => 'nullable|string',
            'member2_code' => 'nullable|string',
            'member3_name' => 'nullable|string',
            'member3_code' => 'nullable|string',
            'member4_name' => 'nullable|string',
            'member4_code' => 'nullable|string',
        ]);

        $candidatura->update($validated);
        return redirect()->back()->with('success', 'Dados do grupo atualizados.');
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->check()) return redirect()->back();

        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $data = ['name' => $validated['name'], 'email' => $validated['email']];
        if (!empty($validated['password'])) {
            $data['password'] = \Hash::make($validated['password']);
        }

        $user->update($data);
        return redirect()->back()->with('success', 'Perfil atualizado com sucesso.');
    }

    public function createUser(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') return redirect()->back();

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,director_curso,docente'
        ]);

        \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        return redirect()->back()->with('success', 'Utilizador criado.');
    }

    public function updateUser(Request $request, \App\Models\User $user)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') return redirect()->back();

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,director_curso,docente',
            'password' => 'nullable|min:6',
        ]);

        $data = ['name' => $validated['name'], 'email' => $validated['email'], 'role' => $validated['role']];
        if (!empty($validated['password'])) {
            $data['password'] = \Hash::make($validated['password']);
        }

        $user->update($data);
        return redirect()->back()->with('success', 'Utilizador atualizado.');
    }

    public function deleteUser(\App\Models\User $user)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') return redirect()->back();
        if ($user->id === auth()->user()->id) return redirect()->back()->withErrors(['Não pode eliminar o seu próprio utilizador.']);

        $user->delete();
        return redirect()->back()->with('success', 'Utilizador removido.');
    }

    public function deleteCandidatura(\App\Models\Candidatura $candidatura)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Não autorizado.'], 403);
        }

        if ($candidatura->status !== 'Rejeitado') {
            return response()->json(['success' => false, 'message' => 'Apenas candidaturas rejeitadas podem ser eliminadas.'], 400);
        }

        try {
            // Delete files from storage
            foreach ($candidatura->ficheiros as $file) {
                if (\Storage::disk('public')->exists($file->caminho)) {
                    \Storage::disk('public')->delete($file->caminho);
                }
            }

            // Delete the candidatura itself
            $candidatura->delete();

            return response()->json(['success' => true, 'message' => 'Candidatura eliminada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocorreu um erro ao eliminar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fallback research questions for academic guidelines.
     */
    private function getFallbackQuestions($sector, $projectName)
    {
        return [
            "De que forma o desenvolvimento e a implementação do sistema {$projectName} respondem a necessidades específicas detectadas na província da Zambézia?",
            "Quais são os principais requisitos não-funcionais (como desempenho, usabilidade e segurança) essenciais para a aceitação de {$projectName} pelos utilizadores locais?",
            "Como a digitalização de processos trazida por {$projectName} melhora a eficiência operacional em comparação com os métodos manuais tradicionais em Quelimane?"
        ];
    }

    /**
     * Fallback suggested bibliography in APA 7 format.
     */
    private function getFallbackReferences($sector)
    {
        switch ($sector) {
            case 'Saúde':
                return [
                    "Ministério da Saúde de Moçambique. (2022). *Plano estratégico nacional de saúde e transição digital*. MISAU.",
                    "Cossa, H., & Mandlate, F. (2021). Digital health interventions in Mozambique: Opportunities and barriers. *African Journal of Health Informatics*, 5(2), 14–23.",
                    "World Health Organization. (2023). *Global strategy on digital health 2020-2025*. WHO Press."
                ];
            case 'Educação':
                return [
                    "Ministério da Educação e Desenvolvimento Humano de Moçambique. (2021). *Plano estratégico de educação e tecnologias de informação*. MINEDH.",
                    "Sambo, J. R., & Moiane, P. (2021). Desafios da gestão digital e governação eletrónica nas escolas públicas moçambicanas. *Revista Educação em Foco*, 9(3), 89–98.",
                    "UNESCO. (2021). *Reimagining our futures together: A new social contract for education*. UNESCO Publishing."
                ];
            case 'Agricultura e Ambiente':
                return [
                    "Instituto de Investigação Agrária de Moçambique (IIAM). (2021). *Desenvolvimento agrário e tecnologia sustentável na Zambézia*. IIAM.",
                    "Macassa, E., & Muthemba, R. (2021). Uso de tecnologias de informação para mitigação de riscos agrícolas na Zambézia. *Revista Moçambicana de Agro-Tecnologia*, 4(1), 12–21.",
                    "FAO. (2021). *Digital agriculture in Sub-Saharan Africa: Challenges and opportunities*. FAO Publishing."
                ];
            case 'Empreendedorismo e PMEs':
                return [
                    "Ministério da Indústria e Comércio de Moçambique. (2022). *Estratégia nacional de desenvolvimento de PMEs e comércio eletrónico*. MIC.",
                    "Bila, S. J., & Mandlate, T. (2021). O papel das plataformas de comércio eletrónico no crescimento de PMEs em Quelimane. *Revista de Economia e Tecnologia de Moçambique*, 3(2), 40–49.",
                    "Porter, M. E. (2018). *Competitive advantage: Creating and sustaining superior performance*. Free Press."
                ];
            case 'Inclusão Social':
                return [
                    "Ministério do Género, Criança e Acção Social de Moçambique. (2022). *Plano nacional de acção para a inclusão da pessoa com deficiência e grupos vulneráveis*. MGCAS.",
                    "Chambal, R. L. (2022). Inclusão social e o papel das redes de apoio digital em Moçambique. *Revista de Ciências Sociais Aplicadas*, 4(2), 15–23.",
                    "Sen, A. (2019). *Development as freedom*. Oxford University Press."
                ];
            case 'Governação':
                return [
                    "Ministério da Administração Estatal e Função Pública de Moçambique. (2021). *Estratégia de governação electrónica e modernização administrativa*. MAEFP.",
                    "Nhantumbo, F., & Tembe, A. (2020). Soluções de governação digital nas instituições locais em Quelimane. *Revista Moçambicana de Gestão Pública*, 8(2), 45–53.",
                    "Heeks, R. (2018). *Information systems and developing countries: Failure, success, and local improvisations*. Routledge."
                ];
            case 'Inteligência Artificial':
                return [
                    "Associação Moçambicana de Tecnologias de Informação e Comunicação. (2023). *Adoção de inteligência artificial e analítica de dados em Moçambique*. AMTIC.",
                    "Mário, A. J., & Sambo, V. (2023). Inteligência artificial no ensino superior em Moçambique: Ameaça ou aliada? *Revista Moçambicana de Tecnologia Educativa*, 6(1), 22–31.",
                    "Russell, S., & Norvig, P. (2020). *Artificial intelligence: A modern approach* (4th ed.). Pearson."
                ];
            default:
                return [
                    "Associação Moçambicana de Tecnologias de Informação e Comunicação. (2022). *O estado das tecnologias de informação e comunicação em Moçambique*. AMTIC.",
                    "Langa, E. V., & Nhantumbo, C. (2020). Desafios tecnológicos do desenvolvimento local em Moçambique. *Revista Moçambicana de Ciência e Tecnologia*, 7(1), 34–41.",
                    "Rogers, E. M. (2018). *Diffusion of innovations* (5th ed.). Free Press."
                ];
        }
    }

    /**
     * Fallback IMRaD custom guide sentences.
     */
    private function getFallbackImrad($sector, $projectName)
    {
        return [
            'introducao' => "Apresentar a relevância socioeconómica do sector de {$sector} em Moçambique. Explicar como a falta de digitalização afeta a produtividade local. Definir o objectivo: desenvolver o {$projectName}.",
            'metodologia' => "Descrever a metodologia de desenvolvimento aplicada (método ágil/incremental). Especificar a stack tecnológica escolhida. Detalhar as ferramentas utilizadas para desenhar a base de dados MySQL.",
            'resultados' => "Demonstrar as principais funcionalidades do sistema com capturas de ecrã do protótipo web ou móvel. Apresentar a modelagem de dados da base de dados e os resultados dos testes de usabilidade.",
            'conclusao' => "Resumir os objectivos que foram cumpridos com a plataforma {$projectName}. Reconhecer limitações técnicas de rede ou de hardware em Quelimane. Propor as linhas de trabalho futuro."
        ];
    }
}
