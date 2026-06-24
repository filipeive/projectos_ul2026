// app.js - Logic for UniLicungo TechHub Project Catalog

// Helper function to map sector icons
function getSectorIcon(sector) {
    switch (sector) {
        case 'Saúde': return 'heart';
        case 'Educação': return 'book-open';
        case 'Agricultura e Ambiente': return 'sprout';
        case 'Empreendedorismo e PMEs': return 'briefcase';
        case 'Inclusão Social': return 'accessibility';
        case 'Governação': return 'landmark';
        case 'Inteligência Artificial': return 'cpu';
        default: return 'help-circle';
    }
}

// Get CSS class for sector tags
function getSectorTagClass(sector) {
    switch (sector) {
        case 'Saúde': return 'tag-saude';
        case 'Educação': return 'tag-educacao';
        case 'Agricultura e Ambiente': return 'tag-agro';
        case 'Empreendedorismo e PMEs': return 'tag-pme';
        case 'Inclusão Social': return 'tag-inclusao';
        case 'Governação': return 'tag-governacao';
        case 'Inteligência Artificial': return 'tag-ia';
        default: return 'bg-slate-800 border-slate-700 text-slate-300';
    }
}

// Get CSS class for difficulty badges
function getDifficultyClass(difficulty) {
    const diff = difficulty.toLowerCase();
    if (diff.includes('fácil') && diff.includes('médio')) return 'badge-medio';
    if (diff.includes('fácil')) return 'badge-facil';
    if (diff.includes('médio')) return 'badge-medio';
    if (diff.includes('avançado')) return 'badge-avancado';
    return 'badge-medio';
}

// Map project sectors to custom database schemas
function getDatabaseSchema(project) {
    const sector = project.sector;
    const num = project.number;

    // Customized schemas for Top projects
    if (num === 1) { // MaterniCare
        return `-- Banco de Dados para MaterniCare (Laravel Migration/SQL)

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'medico', 'enfermeiro', 'gestante') DEFAULT 'gestante',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE gestantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    codigo_gestante VARCHAR(50) UNIQUE NOT NULL, -- Ex: G-2026-XXXX
    data_nascimento DATE NOT NULL,
    tipo_sanguineo VARCHAR(5),
    contacto_emergencia VARCHAR(50),
    data_ultima_menstruacao DATE,
    data_prevista_parto DATE,
    peso_inicial DECIMAL(5,2),
    status ENUM('activo', 'risco_moderado', 'risco_alto', 'concluido') DEFAULT 'activo',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gestante_id INT NOT NULL,
    profissional_id INT NOT NULL,
    data_consulta DATE NOT NULL,
    semana_gestacao INT NOT NULL,
    peso DECIMAL(5,2) NOT NULL,
    tensao_arterial VARCHAR(10) NOT NULL, -- Ex: 120/80
    batimento_cardiaco_fetal INT,
    notas_clinicas TEXT,
    nivel_risco_detectado ENUM('baixo', 'medio', 'alto') DEFAULT 'baixo',
    proxima_consulta DATE,
    FOREIGN KEY (gestante_id) REFERENCES gestantes(id) ON DELETE CASCADE,
    FOREIGN KEY (profissional_id) REFERENCES users(id)
);

CREATE TABLE alertas_sms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gestante_id INT NOT NULL,
    tipo ENUM('consulta', 'vacinacao', 'dica_saude', 'urgente') NOT NULL,
    mensagem TEXT NOT NULL,
    numero_destino VARCHAR(20) NOT NULL,
    data_agendada DATETIME NOT NULL,
    estado ENUM('pendente', 'enviado', 'falhado') DEFAULT 'pendente',
    enviado_em DATETIME NULL,
    FOREIGN KEY (gestante_id) REFERENCES gestantes(id) ON DELETE CASCADE
);`;
    }

    if (num === 2) { // CriançaSaúde
        return `-- Banco de Dados para CriançaSaúde (Acompanhamento Infantil)

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('profissional', 'familiar') DEFAULT 'familiar',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE criancas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    familiar_id INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    genero ENUM('M', 'F') NOT NULL,
    data_nascimento DATE NOT NULL,
    local_nascimento VARCHAR(255),
    peso_nascimento DECIMAL(4,2),
    altura_nascimento DECIMAL(4,2),
    FOREIGN KEY (familiar_id) REFERENCES users(id)
);

CREATE TABLE registos_crescimento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crianca_id INT NOT NULL,
    data_registo DATE NOT NULL,
    idade_meses INT NOT NULL,
    peso DECIMAL(5,2) NOT NULL,
    altura DECIMAL(5,2) NOT NULL,
    perimetro_cefalico DECIMAL(4,2),
    z_score_peso_idade DECIMAL(3,2), -- Cálculo automatizado OMS
    z_score_altura_idade DECIMAL(3,2),
    estado_nutricional ENUM('normal', 'desnutricao_leve', 'desnutricao_grave', 'sobrepeso') DEFAULT 'normal',
    registado_por INT NOT NULL,
    FOREIGN KEY (crianca_id) REFERENCES criancas(id) ON DELETE CASCADE,
    FOREIGN KEY (registado_por) REFERENCES users(id)
);

CREATE TABLE calendario_vacinas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crianca_id INT NOT NULL,
    nome_vacina VARCHAR(100) NOT NULL, -- Ex: BCG, Poliomielite, Pentavalente
    dose VARCHAR(20) NOT NULL, -- Ex: Dose 1, Reforço
    data_prevista DATE NOT NULL,
    data_aplicacao DATE NULL,
    estado ENUM('pendente', 'aplicada', 'atrasada') DEFAULT 'pendente',
    lote_vacina VARCHAR(50),
    FOREIGN KEY (crianca_id) REFERENCES criancas(id) ON DELETE CASCADE
);`;
    }

    if (num === 11) { // EscolaCerta
        return `-- Banco de Dados para EscolaCerta (Gestão Escolar Secundária)

CREATE TABLE escolas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255),
    telefone VARCHAR(20)
);

CREATE TABLE anos_lectivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    escola_id INT NOT NULL,
    ano INT NOT NULL, -- Ex: 2026
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (escola_id) REFERENCES escolas(id)
);

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ano_lectivo_id INT NOT NULL,
    classe VARCHAR(20) NOT NULL, -- Ex: 10a Classe
    nome_turma VARCHAR(10) NOT NULL, -- Ex: Turma A
    periodo ENUM('manha', 'tarde', 'noite') DEFAULT 'manha',
    director_turma_id INT,
    FOREIGN KEY (ano_lectivo_id) REFERENCES anos_lectivos(id)
);

CREATE TABLE estudantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_matricula VARCHAR(50) UNIQUE NOT NULL,
    nome VARCHAR(255) NOT NULL,
    genero ENUM('M', 'F') NOT NULL,
    data_nascimento DATE NOT NULL,
    contacto_encarregado VARCHAR(20) NOT NULL,
    turma_actual_id INT,
    FOREIGN KEY (turma_actual_id) REFERENCES turmas(id)
);

CREATE TABLE avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudante_id INT NOT NULL,
    disciplina VARCHAR(100) NOT NULL, -- Ex: Matemática, Físico
    trimestre ENUM('1', '2', '3') NOT NULL,
    tipo_avaliacao ENUM('ACS1', 'ACS2', 'ACP', 'AT') NOT NULL,
    nota DECIMAL(4,2) NOT NULL CHECK(nota >= 0 AND nota <= 20),
    data_avaliacao DATE,
    FOREIGN KEY (estudante_id) REFERENCES estudantes(id) ON DELETE CASCADE
);`;
    }

    if (num === 21 || num === 22) { // AgroZambézia / MercadoCerto
        return `-- Banco de Dados para AgroZambézia & MercadoCerto

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('agricultor', 'comprador', 'admin') DEFAULT 'agricultor',
    localidade VARCHAR(100) NOT NULL, -- Ex: Nicoadala, Namacurra, Quelimane
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agricultor_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL, -- Ex: Mandioca, Arroz, Coco
    categoria ENUM('cereais', 'tuberculos', 'frutas', 'legumes', 'outros') NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    unidade_medida VARCHAR(20) NOT NULL, -- Ex: Saco 50kg, kg, Unidade
    quantidade_disponivel INT NOT NULL,
    descricao TEXT,
    imagem_url VARCHAR(255),
    estado ENUM('disponivel', 'esgotado') DEFAULT 'disponivel',
    FOREIGN KEY (agricultor_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE encomendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comprador_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    metodo_pagamento ENUM('dinheiro', 'm-pesa', 'e-mola') DEFAULT 'dinheiro',
    referencia_pagamento VARCHAR(100),
    estado ENUM('pendente', 'aceite', 'em_transito', 'entregue', 'cancelado') DEFAULT 'pendente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (comprador_id) REFERENCES users(id)
);

CREATE TABLE itens_encomenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    encomenda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_aplicado DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (encomenda_id) REFERENCES encomendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);`;
    }

    // Generic schemas for sectors
    switch (sector) {
        case 'Saúde':
            return `-- Estrutura Genérica de Base de Dados para Saúde

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    genero CHAR(1),
    data_nascimento DATE,
    telefone VARCHAR(20),
    endereco TEXT
);

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    data_consulta DATETIME NOT NULL,
    diagnostico TEXT,
    tratamento TEXT,
    profissional VARCHAR(255),
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
);`;
            
        case 'Educação':
            return `-- Estrutura Genérica de Base de Dados para Educação

CREATE TABLE estudantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    numero_estudante VARCHAR(50) UNIQUE,
    data_nascimento DATE
);

CREATE TABLE disciplinas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    codigo VARCHAR(20) UNIQUE
);

CREATE TABLE matriculas (
    estudante_id INT,
    disciplina_id INT,
    ano INT,
    semestre INT,
    nota_final DECIMAL(4,2),
    PRIMARY KEY (estudante_id, disciplina_id, ano, semestre),
    FOREIGN KEY (estudante_id) REFERENCES estudantes(id),
    FOREIGN KEY (disciplina_id) REFERENCES disciplinas(id)
);`;

        case 'Agricultura e Ambiente':
            return `-- Estrutura Genérica de Base de Dados para Agricultura e Ambiente

CREATE TABLE produtores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    localizacao VARCHAR(100),
    contacto VARCHAR(20)
);

CREATE TABLE colheitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produtor_id INT,
    tipo_cultura VARCHAR(100) NOT NULL,
    data_plantacao DATE,
    data_colheita DATE,
    quantidade_kg DECIMAL(10,2),
    FOREIGN KEY (produtor_id) REFERENCES produtores(id)
);`;

        case 'Empreendedorismo e PMEs':
            return `-- Estrutura Genérica de Base de Dados para Gestão Comercial / PMEs

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    nuit VARCHAR(20)
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_barras VARCHAR(50) UNIQUE,
    nome VARCHAR(255) NOT NULL,
    preco_venda DECIMAL(10,2) NOT NULL,
    quantidade_stock INT DEFAULT 0
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    total DECIMAL(10,2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT,
    produto_id INT,
    quantidade INT,
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (venda_id) REFERENCES vendas(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);`;

        case 'Inclusão Social':
            return `-- Estrutura Genérica de Base de Dados para Plataforma de Inclusão

CREATE TABLE utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    contacto VARCHAR(20),
    necessidade_especifica VARCHAR(255)
);

CREATE TABLE servicos_acessiveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    categoria VARCHAR(100),
    endereco TEXT,
    tipo_acessibilidade VARCHAR(255),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8)
);`;

        case 'Governação':
            return `-- Estrutura Genérica de Base de Dados para Serviços Públicos / Governação

CREATE TABLE cidadaos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    bi_numero VARCHAR(20) UNIQUE,
    telefone VARCHAR(20)
);

CREATE TABLE ocorrencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cidadao_id INT,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT NOT NULL,
    tipo_problema VARCHAR(100),
    localizacao TEXT,
    status ENUM('aberto', 'em_analise', 'resolvido') DEFAULT 'aberto',
    data_registo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cidadao_id) REFERENCES cidadaos(id)
);`;

        case 'Inteligência Artificial':
            return `-- Estrutura Genérica de Base de Dados para Sistemas com IA

CREATE TABLE inputs_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    metadados_origem TEXT,
    caminho_ficheiro VARCHAR(255), -- Ex: imagem enviada, audio
    texto_processado TEXT,
    data_recepcao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE analises_ia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    input_id INT,
    modelo_utilizado VARCHAR(100),
    resultado_json TEXT, -- Predição, classes, texto OCR
    confianca_score DECIMAL(4,3), -- Ex: 0.952
    processado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (input_id) REFERENCES inputs_sistema(id)
);`;

        default:
            return `-- Estrutura Básica

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);`;
    }
}

// Map project to suggested MVP and future improvements
function getMVPDetails(project) {
    const title = project.name;
    return {
        mvp: `**Para o Dia da Informática (15 de Agosto):**
1. **Cadastro Básico (CRUD)**: Desenvolvimento de uma interface administrativa para gerir as entidades chave (ex: cadastro de utilizadores, registo simples da informação de base).
2. **Dashboard Visual**: Painel administrativo inicial em Laravel/PHP com estatísticas globais em formato numérico (sem necessidade de gráficos complexos inicialmente).
3. **Persistência de Dados**: Criação e ligação a uma base de dados relacional MySQL local.
4. **Notificação Simples**: Sistema integrado de simulação de alertas (impressos no ecrã ou enviados localmente via log de emails).`,
        jornadas: `**Para as Jornadas Científicas (Setembro):**
1. **Notificações Reais (SMS/Web)**: Integração com gateways de SMS (ex: Africa's Talking API) para comunicação móvel directa em Moçambique.
2. **Visualização de Dados Dinâmica**: Integração de gráficos interactivos (ex: Chart.js) para análise agregada.
3. **Módulo Offline-First (se Mobile)**: Implementação de base de dados SQLite no Flutter/Android com sincronização automática com backend Laravel quando houver rede.
4. **Redação do Artigo Científico**: Documentar o processo, metodologia (ex: Scrum adaptado) e resultados de testes práticos num artigo de 5-8 páginas.`
    };
}

// Generate the Application Template in Markdown/HTML
function generateApplicationText(project) {
    return `### PROPOSTA DE PROJECTO ACADÉMICO: ${project.name}
**Iniciativa:** Dia da Informática & Jornadas Científicas 2026 (Universidade Licungo)

#### 1. Identificação do Grupo
* **Nome do Projecto:** ${project.name} (${project.subtitle})
* **Sector:** ${project.sector}
* **Tecnologias Propostas:** ${project.tecnologias}
* **Nível de Dificuldade:** ${project.dificuldade}

* **Integrantes do Grupo (Estudantes do 1º Ano):**
  1. Nome: ______________________________ N.º de Estudante: ___________
  2. Nome: ______________________________ N.º de Estudante: ___________
  3. Nome: ______________________________ N.º de Estudante: ___________
  4. Nome: ______________________________ N.º de Estudante: ___________

* **Mentor Sugerido (Estudante Finalista):** ___________________________

#### 2. Fundamentação e Contexto Local (Quelimane/Zambézia)
* **Qual é o problema concreto de Quelimane ou Moçambique que este projecto resolve?**
  ${project.problema}

* **Público-Alvo Directo:**
  ${project.publico_alvo}

* **Impacto Social Esperado:**
  ${project.impacto}

#### 3. Planeamento Mínimo (MVP)
* **Funcionalidade Central para 15 de Agosto (Dia da Informática):**
  ______________________________________________________________________
  ______________________________________________________________________

* **Extensão de Investigação para Setembro (Jornadas Científicas):**
  ______________________________________________________________________
  ______________________________________________________________________

#### 4. Assinaturas e Aprovação
* Data: ____/____/2026
* Assinatura do Líder do Grupo: _________________________________________
* Parecer do Orientador (Filipe): [  ] Aprovado  [  ] Necessita Revisão`;
}

// Boilerplates mapping for Students
const codeBoilerplates = {
    laravel: {
        title: "Estrutura Básica de Conexão e CRUD no Laravel",
        desc: "Exemplo prático de um Controller em Laravel para gerir o cadastro de uma entidade e retornar JSON para a API ou renderizar uma View Blade.",
        code: `// 1. Definição da Rota (routes/api.php ou routes/web.php)
use App\\Http\\Controllers\\PacienteController;

Route::apiResource('pacientes', PacienteController::class);


// 2. Modelo de Dados (app/Models/Paciente.php)
namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;

class Paciente extends Model
{
    use HasFactory;

    // Campos autorizados para gravação massiva (Mass Assignment)
    protected $fillable = [
        'nome',
        'genero',
        'data_nascimento',
        'telefone',
        'endereco'
    ];
}


// 3. Controller (app/Http/Controllers/PacienteController.php)
namespace App\\Http\\Controllers;

use App\\Models\\Paciente;
use Illuminate\\Http\\Request;

class PacienteController extends Controller
{
    // Listar todos os registos
    public function index()
    {
        return response()->json(Paciente::all(), 200);
    }

    // Criar um novo registo
    public function store(Request $request)
    {
        // Validar os dados vindos do formulário/API
        $validatedData = $request.validate([
            'nome' => 'required|string|max:255',
            'genero' => 'nullable|string|max:1',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:20',
            'endereco' => 'nullable|string'
        ]);

        $paciente = Paciente::create($validatedData);

        return response()->json([
            'message' => 'Registo criado com sucesso!',
            'data' => $paciente
        ], 21);
    }

    // Mostrar um registo específico
    public function show($id)
    {
        $paciente = Paciente::find($id);
        if (!$paciente) {
            return response()->json(['message' => 'Registo não encontrado.'], 44);
        }
        return response()->json($paciente, 200);
    }
}`
    },
    phpRaw: {
        title: "Conexão PDO e Registo em PHP Puro (Sem Framework)",
        desc: "Para estudantes que ainda estão a aprender PHP básico, este script conecta-se a uma base de dados local MySQL e processa uma submissão de formulário de forma segura.",
        code: `<?php
// config.php - Definições de conexão
$host = '127.0.0.1';
$db   = 'unilicungo_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\\PDOException $e) {
     throw new \\PDOException($e->getMessage(), (int)$e->getCode());
}

// processa_registo.php - Processar dados de formulário POST de forma segura
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';

    // Validação básica
    if (!empty($nome) && !empty($telefone)) {
        // SQL com Prepared Statements para prevenir SQL Injection!
        $sql = "INSERT INTO produtores (nome, localizacao, contacto) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$nome, $localizacao, $telefone]);
            echo "Sucesso: Produtor registado com sucesso em Quelimane!";
        } catch (Exception $e) {
            echo "Erro ao guardar dados: " . $e->getMessage();
        }
    } else {
        echo "Erro: Por favor preencha todos os campos obrigatórios.";
    }
}
?>`
    },
    pythonFlask: {
        title: "API Simples em Python com Flask",
        desc: "Ideal para os projetos que envolvem análise de dados (ex: DataMoz) ou pequenos scripts de inteligência artificial/OCR em Python.",
        code: `# app.py - API REST em Flask
from flask import Flask, jsonify, request
import mysql.connector

app = Flask(__name__)

# Configuração da Base de Dados MySQL instalada no XAMPP ou local
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="unilicungo_db"
    )

@app.route('/api/alertas', methods=['GET'])
def get_alertas():
    try:
        conn = get_db_connection()
        cursor = conn.cursor(dictionary=True)
        cursor.execute("SELECT * FROM ocorrencias ORDER BY data_registo DESC")
        ocorrencias = cursor.fetchall()
        cursor.close()
        conn.close()
        return jsonify(ocorrencias), 200
    except Exception as e:
        return jsonify({"erro": str(e)}), 500

@app.route('/api/alertas', methods=['POST'])
def criar_alerta():
    dados = request.json
    titulo = dados.get('titulo')
    descricao = dados.get('descricao')
    localizacao = dados.get('localizacao')
    
    if not titulo or not descricao:
        return jsonify({"erro": "Campos obrigatórios em falta"}), 400
        
    try:
        conn = get_db_connection()
        cursor = conn.cursor()
        sql = "INSERT INTO ocorrencias (titulo, descricao, localizacao, status) VALUES (%s, %s, %s, 'aberto')"
        cursor.execute(sql, (titulo, descricao, localizacao))
        conn.commit()
        cursor.close()
        conn.close()
        return jsonify({"mensagem": "Alerta criado e registado na base de dados!"}), 201
    except Exception as e:
        return jsonify({"erro": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, port=5000)`
    }
};

// Global state for filtering and searching
let filteredProjects = [];
let activeFilters = {
    search: '',
    sector: 'Todos',
    difficulty: 'Todos',
    technology: 'Todos'
};

// Initialize the catalog
window.addEventListener('DOMContentLoaded', () => {
    // Check if projectsData is loaded
    if (typeof projectsData === 'undefined') {
        console.error('Projects data is not loaded!');
        return;
    }
    
    filteredProjects = [...projectsData];
    
    // Render Statistics
    renderStatistics();
    
    // Render Project Grid
    renderProjects();
    
    // Initialize filter elements
    setupFilterEvents();
    
    // Initialize navigation tabs
    setupNavigationTabs();
    
    // Initialize code boilerplates
    renderBoilerplates();
    
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

// Calculate and render stats in the top of catalog page
function renderStatistics() {
    const totalCount = projectsData.length;
    const sectors = new Set(projectsData.map(p => p.sector)).size;
    const facilCount = projectsData.filter(p => p.dificuldade.toLowerCase().includes('fácil')).length;
    const medioCount = projectsData.filter(p => p.dificuldade.toLowerCase().includes('médio')).length;
    const avancadoCount = projectsData.filter(p => p.dificuldade.toLowerCase().includes('avançado')).length;
    
    document.getElementById('stat-total-projects').innerText = totalCount;
    document.getElementById('stat-sectors').innerText = sectors;
    document.getElementById('stat-facil').innerText = facilCount;
    document.getElementById('stat-medio').innerText = medioCount;
    document.getElementById('stat-avancado').innerText = avancadoCount;
}

// Render project cards to grid
function renderProjects() {
    const grid = document.getElementById('projects-grid');
    const emptyState = document.getElementById('empty-state');
    
    if (filteredProjects.length === 0) {
        grid.classList.add('hidden');
        emptyState.classList.remove('hidden');
        return;
    }
    
    grid.classList.remove('hidden');
    emptyState.classList.add('hidden');
    
    grid.innerHTML = '';
    
    filteredProjects.forEach(project => {
        const card = document.createElement('div');
        card.className = 'glass-card rounded-xl p-6 flex flex-col justify-between animate-fade-in relative overflow-hidden cursor-pointer';
        card.dataset.id = project.number;
        
        const sectorIcon = getSectorIcon(project.sector);
        const sectorTagClass = getSectorTagClass(project.sector);
        const diffClass = getDifficultyClass(project.dificuldade);
        
        card.innerHTML = `
            <div>
                <!-- Top Section with Number and Icon -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-mono text-slate-500 font-bold">#${String(project.number).padStart(2, '0')}</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center ${sectorTagClass} bg-opacity-20 border border-opacity-30">
                        <i data-lucide="${sectorIcon}" class="w-5 h-5"></i>
                    </div>
                </div>
                
                <!-- Title -->
                <h3 class="text-lg font-bold text-slate-100 mb-1 font-display group-hover:text-indigo-400 transition-colors">${project.name}</h3>
                <p class="text-xs text-indigo-400 font-semibold mb-3 font-mono italic">${project.subtitle}</p>
                
                <!-- Description snippet -->
                <p class="text-sm text-slate-400 line-clamp-3 mb-4 leading-relaxed">${project.problema}</p>
            </div>
            
            <!-- Badges and Button -->
            <div class="mt-4 pt-4 border-t border-slate-800/60 flex flex-wrap gap-2 items-center justify-between">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${diffClass}">${project.dificuldade}</span>
                <span class="text-xs text-slate-500 font-medium">${project.sector}</span>
            </div>
        `;
        
        // Add click listener to card to open modal
        card.addEventListener('click', () => openProjectModal(project));
        
        grid.appendChild(card);
    });
    
    // Refresh icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// Handle filters and search query
function applyFilters() {
    filteredProjects = projectsData.filter(project => {
        // 1. Search Query Match
        const query = activeFilters.search.toLowerCase().trim();
        const matchesSearch = query === '' || 
            project.name.toLowerCase().includes(query) ||
            project.subtitle.toLowerCase().includes(query) ||
            project.problema.toLowerCase().includes(query) ||
            project.tecnologias.toLowerCase().includes(query) ||
            project.sector.toLowerCase().includes(query);
            
        // 2. Sector Match
        const matchesSector = activeFilters.sector === 'Todos' || project.sector === activeFilters.sector;
        
        // 3. Difficulty Match
        const matchesDiff = activeFilters.difficulty === 'Todos' || 
            (activeFilters.difficulty === 'Fácil' && project.dificuldade.toLowerCase().includes('fácil')) ||
            (activeFilters.difficulty === 'Médio' && project.dificuldade.toLowerCase().includes('médio')) ||
            (activeFilters.difficulty === 'Avançado' && project.dificuldade.toLowerCase().includes('avançado'));
            
        // 4. Technology Match
        const matchesTech = activeFilters.technology === 'Todos' || 
            project.tecnologias.toLowerCase().includes(activeFilters.technology.toLowerCase());
            
        return matchesSearch && matchesSector && matchesDiff && matchesTech;
    });
    
    // Re-render
    renderProjects();
}

// Setup input listeners for filtering
function setupFilterEvents() {
    // Search input
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            activeFilters.search = e.target.value;
            applyFilters();
        });
    }
    
    // Sector filter buttons (horizontal list)
    const sectorFilters = document.querySelectorAll('.sector-filter-btn');
    sectorFilters.forEach(btn => {
        btn.addEventListener('click', () => {
            sectorFilters.forEach(b => b.classList.remove('tab-active', 'bg-slate-800'));
            btn.classList.add('tab-active');
            activeFilters.sector = btn.dataset.sector;
            applyFilters();
        });
    });
    
    // Difficulty dropdown filter
    const diffSelect = document.getElementById('filter-difficulty');
    if (diffSelect) {
        diffSelect.addEventListener('change', (e) => {
            activeFilters.difficulty = e.target.value;
            applyFilters();
        });
    }
    
    // Technology select filter
    const techSelect = document.getElementById('filter-tech');
    if (techSelect) {
        techSelect.addEventListener('change', (e) => {
            activeFilters.technology = e.target.value;
            applyFilters();
        });
    }
    
    // Reset filters button
    const resetBtn = document.getElementById('reset-filters-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (diffSelect) diffSelect.value = 'Todos';
            if (techSelect) techSelect.value = 'Todos';
            
            sectorFilters.forEach(b => b.classList.remove('tab-active'));
            document.querySelector('.sector-filter-btn[data-sector="Todos"]').classList.add('tab-active');
            
            activeFilters = {
                search: '',
                sector: 'Todos',
                difficulty: 'Todos',
                technology: 'Todos'
            };
            
            applyFilters();
        });
    }
}

// Setup navigation between tabs
function setupNavigationTabs() {
    const tabBtns = document.querySelectorAll('.nav-tab-btn');
    const sections = document.querySelectorAll('.content-section');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetTab = btn.dataset.tab;
            
            tabBtns.forEach(b => {
                b.classList.remove('border-indigo-500', 'text-indigo-400');
                b.classList.add('border-transparent', 'text-slate-400');
            });
            btn.classList.add('border-indigo-500', 'text-indigo-400');
            btn.classList.remove('border-transparent', 'text-slate-400');
            
            sections.forEach(sec => {
                if (sec.id === `section-${targetTab}`) {
                    sec.classList.remove('hidden');
                } else {
                    sec.classList.add('hidden');
                }
            });
            
            // If timeline tab is open, let's refresh icons
            if (targetTab === 'mobilizacao' && typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
}

// Open Detail Modal for project
function openProjectModal(project) {
    const modal = document.getElementById('project-modal');
    if (!modal) return;
    
    // Populate simple fields
    document.getElementById('modal-project-number').innerText = `#${String(project.number).padStart(2, '0')}`;
    document.getElementById('modal-project-name').innerText = project.name;
    document.getElementById('modal-project-subtitle').innerText = project.subtitle;
    document.getElementById('modal-project-sector').innerText = project.sector;
    document.getElementById('modal-project-difficulty').innerText = project.dificuldade;
    document.getElementById('modal-project-difficulty').className = `px-2.5 py-0.5 rounded-full text-xs font-semibold ${getDifficultyClass(project.dificuldade)}`;
    
    document.getElementById('modal-val-problema').innerText = project.problema;
    document.getElementById('modal-val-publico').innerText = project.publico_alvo;
    document.getElementById('modal-val-impacto').innerText = project.impacto;
    document.getElementById('modal-val-tecnologias').innerText = project.tecnologias;
    document.getElementById('modal-val-startup').innerText = project.startup;
    document.getElementById('modal-val-parcerias').innerText = project.parcerias;
    document.getElementById('modal-val-funcionalidades').innerText = project.funcionalidades;
    document.getElementById('modal-val-melhorias').innerText = project.melhorias_futuras;
    
    // Add suggested database schema
    const schemaCode = getDatabaseSchema(project);
    document.getElementById('modal-val-db-schema').innerText = schemaCode;
    
    // Add MVP roadmaps
    const mvpDetails = getMVPDetails(project);
    document.getElementById('modal-val-mvp-step1').innerHTML = parseMarkdownToHTML(mvpDetails.mvp);
    document.getElementById('modal-val-mvp-step2').innerHTML = parseMarkdownToHTML(mvpDetails.jornadas);
    
    // Pre-populate application generator modal pre-fields
    const generateBtn = document.getElementById('modal-apply-btn');
    if (generateBtn) {
        generateBtn.onclick = () => {
            closeModal();
            openApplicationGenerator(project);
        };
    }

    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    // Setup copy SQL schema event
    const copySqlBtn = document.getElementById('copy-sql-btn');
    if (copySqlBtn) {
        copySqlBtn.onclick = () => {
            navigator.clipboard.writeText(schemaCode).then(() => {
                copySqlBtn.innerHTML = '<i data-lucide="check" class="w-4 h-4 mr-1"></i> Copiado!';
                if (typeof lucide !== 'undefined') lucide.createIcons();
                setTimeout(() => {
                    copySqlBtn.innerHTML = '<i data-lucide="copy" class="w-4 h-4 mr-1"></i> Copiar Código';
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }, 2000);
            });
        };
    }
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// Close Modal
function closeModal() {
    const modal = document.getElementById('project-modal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
}

// Utility to parse basic markdown bullet points to HTML
function parseMarkdownToHTML(text) {
    if (!text) return '';
    let html = text;
    // Bold matches
    html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    // Bullet points
    html = html.replace(/^\s*[-*+]\s+(.*)$/gm, '<li class="ml-4 list-disc text-slate-300 leading-relaxed mb-1">$1</li>');
    // Numbered lists
    html = html.replace(/^\s*(\d+)\.\s+(.*)$/gm, '<li class="ml-4 list-decimal text-slate-300 leading-relaxed mb-1">$2</li>');
    return html;
}

// Open Application Generator Form Modal
function openApplicationGenerator(project) {
    const genSection = document.getElementById('section-estudante');
    
    // Switch to Studante Tab
    const studentTabBtn = document.querySelector('.nav-tab-btn[data-tab="estudante"]');
    if (studentTabBtn) {
        studentTabBtn.click();
    }
    
    // Set Target Project selection
    const projectSelect = document.getElementById('app-project-select');
    if (projectSelect) {
        // Repopulate select option if needed
        projectSelect.innerHTML = `<option value="${project.number}">${project.name}</option>`;
        projectsData.forEach(p => {
            if (p.number !== project.number) {
                projectSelect.innerHTML += `<option value="${p.number}">${p.name}</option>`;
            }
        });
        projectSelect.value = project.number;
    }
    
    // Pre-fill textarea
    const rationaleInput = document.getElementById('app-rationale');
    if (rationaleInput) {
        rationaleInput.value = `Nós escolhemos este projeto porque em Quelimane e Moçambique enfrentamos o problema de: ${project.problema}

Pretendemos ajudar com uma solução baseada em ${project.tecnologias} que irá beneficiar os seguintes utilizadores: ${project.publico_alvo}.`;
    }
    
    // Clear output area
    document.getElementById('generated-output-container').classList.add('hidden');
}

// Generate the proposal document for copy
function generateProjectProposal() {
    const projectSelect = document.getElementById('app-project-select');
    const pNumber = parseInt(projectSelect.value);
    const project = projectsData.find(p => p.number === pNumber);
    
    const m1 = document.getElementById('member1-name').value || 'Nome do Estudante 1';
    const n1 = document.getElementById('member1-code').value || 'N.º Estudante';
    const m2 = document.getElementById('member2-name').value || 'Nome do Estudante 2';
    const n2 = document.getElementById('member2-code').value || '';
    const m3 = document.getElementById('member3-name').value || '';
    const n3 = document.getElementById('member3-code').value || '';
    const m4 = document.getElementById('member4-name').value || '';
    const n4 = document.getElementById('member4-code').value || '';
    
    const mentor = document.getElementById('app-mentor').value || 'Estudante Finalista Sugerido';
    const tech = document.getElementById('app-tech-select').value;
    const rationale = document.getElementById('app-rationale').value;
    
    // Formulate Markdown Proposal
    let markdownText = `### PROPOSTA DE PROJECTO ACADÉMICO: ${project.name}
**Iniciativa:** Dia da Informática & Jornadas Científicas 2026 (Universidade Licungo)

#### 1. Identificação do Grupo
* **Nome do Projecto:** ${project.name} (${project.subtitle})
* **Sector:** ${project.sector}
* **Tecnologias Seleccionadas:** ${tech}
* **Nível de Dificuldade Original:** ${project.dificuldade}

* **Integrantes do Grupo (Estudantes do 1º Ano):**
  1. Nome: ${m1} | N.º de Estudante: ${n1}
  ${m2 ? `2. Nome: ${m2} | N.º de Estudante: ${n2}` : ''}
  ${m3 ? `3. Nome: ${m3} | N.º de Estudante: ${n3}` : ''}
  ${m4 ? `4. Nome: ${m4} | N.º de Estudante: ${n4}` : ''}

* **Mentor Sugerido (Estudante Finalista):** ${mentor}

#### 2. Fundamentação e Contexto Local (Quelimane/Zambézia)
* **Justificação e Raciocínio de Implementação:**
  ${rationale}

* **Público-Alvo Directo:**
  ${project.publico_alvo}

* **Impacto Social Esperado:**
  ${project.impacto}

#### 3. Planeamento Mínimo (MVP)
* **Módulo Mínimo Viável para 15 de Agosto (Dia da Informática):**
  - Implementar base de dados relacional e cadastro completo (CRUD) de utilizadores e registos chave.
  - Tela inicial de dashboard responsiva adaptada ao ecrã móvel.
* **Extensão de Investigação para Setembro (Jornadas Científicas):**
  - Integração de relatórios e relatórios estatísticos e alertas simulados.
  - Artigo de documentação sobre a importância e o processo de desenvolvimento da solução.

---
* Proposta gerada automaticamente via UniLicungo TechHub.`;

    // Render in Textarea
    const outputArea = document.getElementById('generated-proposal-text');
    outputArea.value = markdownText;
    
    // Show Output Container
    document.getElementById('generated-output-container').classList.remove('hidden');
    
    // Setup copy button
    const copyProposalBtn = document.getElementById('copy-proposal-btn');
    if (copyProposalBtn) {
        copyProposalBtn.onclick = () => {
            navigator.clipboard.writeText(markdownText).then(() => {
                copyProposalBtn.innerHTML = '<i data-lucide="check" class="w-4 h-4 mr-1"></i> Copiado!';
                if (typeof lucide !== 'undefined') lucide.createIcons();
                setTimeout(() => {
                    copyProposalBtn.innerHTML = '<i data-lucide="copy" class="w-4 h-4 mr-1"></i> Copiar Texto Ficha';
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }, 2000);
            });
        };
    }
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// Render starter code boilerplates
function renderBoilerplates() {
    const container = document.getElementById('boilerplates-container');
    if (!container) return;
    
    container.innerHTML = '';
    
    Object.keys(codeBoilerplates).forEach(key => {
        const bp = codeBoilerplates[key];
        const card = document.createElement('div');
        card.className = 'glass-card p-6 rounded-xl border border-slate-800/80 mb-6';
        
        card.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-md font-bold text-indigo-400 font-display">${bp.title}</h3>
                <button class="copy-bp-btn px-3 py-1 bg-slate-800 hover:bg-slate-700 text-xs font-semibold rounded text-slate-300 transition-colors flex items-center" data-key="${key}">
                    <i data-lucide="copy" class="w-3.5 h-3.5 mr-1"></i> Copiar Código
                </button>
            </div>
            <p class="text-sm text-slate-400 mb-4 leading-relaxed">${bp.desc}</p>
            <pre class="bg-slate-950 p-4 rounded-lg text-xs font-mono text-slate-300 overflow-x-auto border border-slate-900 leading-normal max-h-[350px]"><code class="language-php">${escapeHTML(bp.code)}</code></pre>
        `;
        
        container.appendChild(card);
    });
    
    // Copy listeners
    const copyBtns = container.querySelectorAll('.copy-bp-btn');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.key;
            const code = codeBoilerplates[key].code;
            navigator.clipboard.writeText(code).then(() => {
                btn.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5 mr-1"></i> Copiado!';
                if (typeof lucide !== 'undefined') lucide.createIcons();
                setTimeout(() => {
                    btn.innerHTML = '<i data-lucide="copy" class="w-3.5 h-3.5 mr-1"></i> Copiar Código';
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }, 2000);
            });
        });
    });
}

// Utility to escape HTML entities
function escapeHTML(str) {
    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
