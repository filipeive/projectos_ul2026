<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Comprovativo - {{ $candidatura->project_name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #008ad2;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #008ad2;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            font-size: 16px;
            color: #666;
            margin-top: 5px;
        }
        .box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .box h3 {
            margin-top: 0;
            color: #008ad2;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            font-size: 16px;
        }
        .credentials {
            background-color: #e0f2fe;
            border: 1px solid #bae6fd;
        }
        .credentials h3 {
            color: #0369a1;
            border-bottom-color: #bae6fd;
        }
        .pin {
            font-size: 28px;
            font-weight: bold;
            color: #0284c7;
            text-align: center;
            letter-spacing: 5px;
            margin: 15px 0;
        }
        .warning {
            color: #b91c1c;
            font-size: 12px;
            text-align: center;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            width: 30%;
            color: #555;
            font-weight: normal;
        }
        td {
            font-weight: bold;
            color: #222;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>UniLicungo TechHub</h1>
        <h2>Ficha de Registo e Acompanhamento de Projecto</h2>
        <p>Jornadas Científicas 2026 - Curso de Informática</p>
    </div>

    <div class="box credentials">
        <h3>Credenciais de Acesso ao Workspace (IMPORTANTE)</h3>
        <p>Use este PIN juntamente com o número do projeto para aceder à sala de mentoria no portal.</p>
        <div class="pin">{{ $pin }}</div>
        <p class="warning">Guarde este PDF. O PIN não voltará a ser mostrado no sistema por questões de segurança.</p>
    </div>

    <div class="box">
        <h3>Detalhes do Projecto Escolhido</h3>
        <table>
            <tr>
                <th>ID da Candidatura:</th>
                <td>#{{ sprintf("%04d", $candidatura->id) }}</td>
            </tr>
            <tr>
                <th>Número do Projecto:</th>
                <td>#{{ sprintf("%02d", $candidatura->project_number) }}</td>
            </tr>
            <tr>
                <th>Nome do Projecto:</th>
                <td>{{ $candidatura->project_name }}</td>
            </tr>
            <tr>
                <th>Tecnologia:</th>
                <td>{{ $candidatura->technology }}</td>
            </tr>
            <tr>
                <th>Mentor:</th>
                <td>{{ $candidatura->mentor ?: 'A ser alocado' }}</td>
            </tr>
            <tr>
                <th>Data de Registo:</th>
                <td>{{ $candidatura->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    @if($projectDetails)
    <div class="box" style="border-color: #0ea5e9; background-color: #f0f9ff;">
        <h3 style="color: #0284c7; border-bottom-color: #bae6fd;">Orientações e Caderno de Encargos</h3>
        <p><strong>Descrição do Problema:</strong></p>
        <p style="font-size: 14px; text-align: justify; margin-bottom: 15px;">{{ $projectDetails['problema'] ?? 'N/A' }}</p>
        
        <p><strong>Requisitos e Funcionalidades a Desenvolver:</strong></p>
        <ul style="font-size: 14px;">
            @php
                $features = explode(',', $projectDetails['funcionalidades'] ?? '');
            @endphp
            @foreach($features as $feature)
                @if(trim($feature) !== '')
                    <li style="margin-bottom: 5px;">{{ trim($feature) }}</li>
                @endif
            @endforeach
        </ul>
        <p style="font-size: 12px; color: #64748b; margin-top: 15px; border-top: 1px dashed #bae6fd; padding-top: 10px;">
            Dica: O grupo deve estudar a fundo estas funcionalidades. Na área de "Workspace", o mentor poderá enviar mais materiais de apoio, e vocês poderão enviar as vossas versões (códigos/imagens) para revisão contínua.
        </p>
    </div>
    @endif

    <div class="box">
        <h3>Membros do Grupo</h3>
        <table>
            <tr>
                <th>1. Líder:</th>
                <td>{{ $candidatura->member1_name }} ({{ $candidatura->member1_code }})</td>
            </tr>
            <tr>
                <th>2. Membro:</th>
                <td>{{ $candidatura->member2_name }} ({{ $candidatura->member2_code }})</td>
            </tr>
            @if($candidatura->member3_name)
            <tr>
                <th>3. Membro:</th>
                <td>{{ $candidatura->member3_name }} ({{ $candidatura->member3_code }})</td>
            </tr>
            @endif
            @if($candidatura->member4_name)
            <tr>
                <th>4. Membro:</th>
                <td>{{ $candidatura->member4_name }} ({{ $candidatura->member4_code }})</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="box">
        <h3>Justificativa</h3>
        <p style="font-size: 14px; font-weight: normal; text-align: justify;">{{ $candidatura->rationale }}</p>
    </div>

    <div class="footer">
        <p>Documento gerado automaticamente pelo sistema UniLicungo TechHub.<br>
        Universidade Licungo, Quelimane, Moçambique - {{ date('Y') }}</p>
    </div>

</body>
</html>
