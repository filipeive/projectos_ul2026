<?php

namespace Tests\Feature;

use App\Models\Candidatura;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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
}
