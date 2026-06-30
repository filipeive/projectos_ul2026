<?php

namespace Tests\Feature;

use App\Models\Candidatura;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_resend_pin_requires_matching_submission_session(): void
    {
        $candidatura = Candidatura::create([
            'project_number' => 1,
            'project_name' => 'FarmaDigital',
            'technology' => 'Laravel + MySQL',
            'member1_name' => 'Estudante Teste',
            'member1_code' => 'UL001',
            'contact_email' => 'grupo@example.com',
            'contact_phone' => '841234567',
            'rationale' => 'Projeto para testar o fluxo de reenvio de PIN.',
            'status' => 'Pendente',
            'group_password' => Hash::make('123456'),
        ]);

        $this->post(route('candidatura.resend-pin', $candidatura))
            ->assertRedirect(route('workspace.recover-pin', $candidatura->id));
    }

    public function test_admin_can_change_approved_candidatura_to_rejected(): void
    {
        $admin = User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $candidatura = Candidatura::create([
            'project_number' => 2,
            'project_name' => 'Teste Admin',
            'technology' => 'Laravel + MySQL',
            'member1_name' => 'Estudante Teste',
            'member1_code' => 'UL002',
            'contact_email' => 'grupo2@example.com',
            'contact_phone' => '841234568',
            'rationale' => 'Projeto para testar mudança de estado no dashboard.',
            'status' => 'Aprovado',
            'group_password' => Hash::make('123456'),
        ]);

        $this->actingAs($admin)
            ->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->postJson(route('admin.update-status', $candidatura), ['status' => 'Rejeitado'])
            ->assertOk()
            ->assertJsonPath('status', 'Rejeitado');

        $this->assertDatabaseHas('candidaturas', [
            'id' => $candidatura->id,
            'status' => 'Rejeitado',
        ]);
    }

    public function test_admin_can_render_workspace_page(): void
    {
        $admin = User::create([
            'name' => 'Admin Workspace',
            'email' => 'workspace-admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $candidatura = Candidatura::create([
            'project_number' => 3,
            'project_name' => 'Workspace Responsivo',
            'technology' => 'Laravel + MySQL',
            'member1_name' => 'Estudante Um',
            'member1_code' => 'UL003',
            'contact_email' => 'workspace@example.com',
            'contact_phone' => '841234569',
            'rationale' => 'Projeto para testar a renderização responsiva do workspace.',
            'status' => 'Aprovado',
            'group_password' => Hash::make('123456'),
        ]);

        $this->actingAs($admin)
            ->get(route('workspace.index', $candidatura))
            ->assertOk()
            ->assertSee('Workspace Responsivo');
    }

    public function test_student_ai_assistant_stores_ai_message_in_chat(): void
    {
        Http::fake([
            'https://openrouter.ai/api/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Resposta orientadora da IA.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $candidatura = Candidatura::create([
            'project_number' => 4,
            'project_name' => 'Chat IA',
            'technology' => 'Laravel + OpenRouter',
            'member1_name' => 'Estudante Chat',
            'member1_code' => 'UL004',
            'contact_email' => 'chat@example.com',
            'contact_phone' => '841234570',
            'rationale' => 'Projeto para testar o assistente IA do workspace.',
            'status' => 'Aprovado',
            'group_password' => Hash::make('123456'),
        ]);

        $this->withSession(['workspace_logged_in_' . $candidatura->id => true])
            ->postJson(route('workspace.ai.ask', $candidatura), [
                'message' => 'Como organizamos os próximos passos?',
            ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('workspace_messages', [
            'candidatura_id' => $candidatura->id,
            'sender_type' => 'ai',
            'message' => 'Resposta orientadora da IA.',
        ]);
    }

    public function test_admin_login_shows_password_recovery_link(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee(route('password.request'));
    }

    public function test_admin_password_reset_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::create([
            'name' => 'Docente Teste',
            'email' => 'docente@example.com',
            'password' => Hash::make('password'),
            'role' => 'docente',
        ]);

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('success');

        Notification::assertSentTo($user, ResetPassword::class);
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_admin_password_can_be_reset_with_valid_token(): void
    {
        $user = User::create([
            'name' => 'Admin Reset',
            'email' => 'reset@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $token = app('auth.password.broker')->createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'nova-senha',
            'password_confirmation' => 'nova-senha',
        ])->assertRedirect(route('admin.login'));

        $this->assertTrue(Hash::check('nova-senha', $user->fresh()->password));
    }

    public function test_pdf_receipt_contains_workspace_link_and_contact_details(): void
    {
        $candidatura = Candidatura::create([
            'project_number' => 5,
            'project_name' => 'Comprovativo Rico',
            'technology' => 'Laravel + PDF',
            'member1_name' => 'Estudante PDF',
            'member1_code' => 'UL005',
            'contact_email' => 'pdf@example.com',
            'contact_phone' => '841234571',
            'rationale' => 'Projeto para testar os detalhes do comprovativo.',
            'status' => 'Pendente',
            'group_password' => Hash::make('123456'),
        ]);

        $html = view('pdf.comprovativo', [
            'candidatura' => $candidatura,
            'pin' => '123456',
            'workspaceUrl' => 'http://146.235.224.99/projectos_ul/workspace/login?project_number=5',
            'projectDetails' => [
                'sector' => 'Educação',
                'dificuldade' => 'Médio',
                'descricao' => 'Resumo detalhado do projeto.',
                'problema' => 'Problema académico a resolver.',
                'funcionalidades' => 'Login, Kanban, Relatórios',
            ],
        ])->render();

        $this->assertStringContainsString('pdf@example.com', $html);
        $this->assertStringContainsString('841234571', $html);
        $this->assertStringContainsString('http://146.235.224.99/projectos_ul/workspace/login?project_number=5', $html);
        $this->assertStringContainsString('Resumo detalhado do projeto.', $html);
    }

    public function test_admin_approving_candidatura_triggers_notifications(): void
    {
        \Illuminate\Support\Facades\Event::fake([\Illuminate\Mail\Events\MessageSending::class]);

        $admin = User::create([
            'name' => 'Admin Aprovador',
            'email' => 'aprovador@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $candidatura = Candidatura::create([
            'project_number' => 6,
            'project_name' => 'Projeto Notificado',
            'technology' => 'Laravel + Mail',
            'member1_name' => 'Estudante Notificado',
            'member1_code' => 'UL006',
            'contact_email' => 'notificado@example.com',
            'contact_phone' => '841234572',
            'rationale' => 'Projeto para testar as notificações de aprovação.',
            'status' => 'Pendente',
            'group_password' => Hash::make('123456'),
        ]);

        $this->actingAs($admin)
            ->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->postJson(route('admin.update-status', $candidatura), ['status' => 'Aprovado'])
            ->assertOk()
            ->assertJsonPath('status', 'Aprovado');

        \Illuminate\Support\Facades\Event::assertDispatched(\Illuminate\Mail\Events\MessageSending::class, function ($event) use ($candidatura) {
            return $event->message->getTo()[0]->getAddress() === $candidatura->contact_email;
        });
    }
}
