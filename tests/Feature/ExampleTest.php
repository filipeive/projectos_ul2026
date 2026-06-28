<?php

namespace Tests\Feature;

use App\Models\Candidatura;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
}
