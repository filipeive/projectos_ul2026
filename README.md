# 🎓 UniLicungo TechHub
> **Ecosistema Digital Académico da Universidade Licungo** — Uma plataforma inteligente para gestão de candidaturas de projetos, mentoria em tempo real, Kanban ágil e co-orientação assistida por Inteligência Artificial (SaaS).

---

![Licungo TechHub](https://img.shields.io/badge/Laravel-11%2B-red?style=for-the-badge&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-v3-blue?style=for-the-badge&logo=tailwind-css)
![AI Integrations](https://img.shields.io/badge/AI--Integrations-OpenRouter%20%2F%20GPT--4o-purple?style=for-the-badge)
![Acessibilidade](https://img.shields.io/badge/Acessibilidade-WCAG%202.2%20(AA)-emerald?style=for-the-badge)

---

## 📖 Visão Geral

O **UniLicungo TechHub** é uma solução SaaS projetada para modernizar e digitalizar a gestão de projetos de fim de curso e trabalhos de investigação científica na Universidade Licungo. A plataforma transita do modelo estático tradicional de entrega de relatórios para um **Workspace Dinâmico**, centralizando a comunicação, tarefas e o progresso em fases académicas.

---

## ✨ Funcionalidades em Destaque

*   **🌐 Portal Público de Projetos:** Catálogo de ideias estruturado com filtros rápidos e busca em tempo real, permitindo a candidatura de grupos (Líder + até 3 membros).
*   **🤖 AI Advisor & Co-orientador (OpenRouter/GPT-4o):**
    *   *Gerador de Ideias:* Sugere conceitos inovadores adaptados às necessidades reais da província da Zambézia (Quelimane).
    *   *Planeador Kanban:* Analisa o projeto e cria automaticamente tarefas técnicas no quadro.
    *   *Clima & Resumos:* Analisa o sentimento das conversas do chat e envia relatórios executivos para o docente.
    *   *Orientador Privado:* Sugere respostas a dúvidas no chat de forma privada para o docente validar ou editar antes de partilhar.
*   **📋 Kanban Ágil Integrado:** Painel interativo para acompanhamento de tarefas (A Fazer, Em Progresso, Concluído) em tempo real.
*   **💬 Chat de Mentoria Directo:** Canal de comunicação persistente e integrado entre o grupo de estudantes e o docente mentor.
*   **📂 Repositório Glassmorphism:** Carregamento de ficheiros com visualização direta e responsiva de PDFs, imagens e código-fonte, reduzindo o tráfego de downloads redundantes.
*   **📱 Mobile-First & PWA-Ready:** Totalmente acessível em smartphones com suporte a **Tema Claro, Tema Escuro e Tema do Sistema**.
*   **💬 SMS Gateway Integrado:** Envio automatizado de PINs e atualizações por SMS usando canais configuráveis (HTTP SMS, Africa's Talking, Twilio, D7 Networks, Vonage).

---

## 🛠️ Requisitos de Sistema

*   **PHP:** `^8.3`
*   **Database:** MySQL / MariaDB
*   **Gerenciador de Dependências:** Composer
*   **Client-Side compilation:** Node.js (npm/npx)

---

## 🚀 Instalação e Configuração

### 1. Clonar o Repositório e Instalar Dependências
```bash
git clone https://github.com/filipeive/projectos_ul2026.git
cd projectos_ul2026
composer install
npm install
```

### 2. Configurar o Ambiente (`.env`)
Copie o ficheiro de exemplo e gere a chave de segurança:
```bash
cp .env.example .env
php artisan key:generate
```

Configure a ligação à base de dados no `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techhub_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Configurar as Integrações de IA & SMS
No `.env`, introduza as credenciais da API do OpenRouter e do HTTP SMS Gateway:
```env
# Inteligência Artificial (OpenRouter API)
OPENROUTER_API_KEY=seu_token_aqui

# SMS Gateway (Exemplo usando HTTP SMS)
HTTPSMS_API_KEY=sua_chave_http_sms_aqui
HTTPSMS_PHONE_NUMBER=+258840000000
```

### 4. Executar Migrações e Seeders
Crie as tabelas e povoe a base de dados com as configurações iniciais de docentes e utilizadores administrativos:
```bash
php artisan migrate --seed
```

### 5. Compilar os Assets & Iniciar o Servidor
```bash
npm run dev
php artisan serve
```

---

## 📂 Documentação e Relatórios Técnicos

Para uma análise mais profunda sobre o planeamento técnico, decisões de design e evolução do sistema, consulte a pasta `/docs`:

*   **[`docs/FLUXO_PLATAFORMA.md`](file:///docs/FLUXO_PLATAFORMA.md):** Mapa de fluxo detalhado e proposta executiva para apresentação a Diretores e Reitoria.
*   **[`docs/UI_UX_REFACTOR_REPORT.md`](file:///docs/UI_UX_REFACTOR_REPORT.md):** Relatório detalhado das 4 fases da refatoração de UI/UX, acessibilidade (WCAG 2.2) e consistência visual.
*   **[`docs/RELATORIO_BRANCHES.md`](file:///docs/RELATORIO_BRANCHES.md):** Histórico de saneamento de branches Git.
*   **[`HISTORICO_DEV.md`](file:///HISTORICO_DEV.md):** Relatório de evolução de engenharia do sistema.

---

*Universidade Licungo — Ciência, Tecnologia e Desenvolvimento.*
