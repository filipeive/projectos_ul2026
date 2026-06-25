# Histórico de Desenvolvimento: UniLicungo TechHub (2026)

## 📌 Contexto Científico e Objetivo
O **UniLicungo TechHub** nasceu da necessidade de modernizar e centralizar a gestão de projetos académicos da Universidade Licungo. O projeto visa criar um ecossistema digital ("Workspace") que substitua metodologias analógicas (papel, emails fragmentados) por um painel interativo que integra Gestão Ágil de Projetos (Kanban), comunicação em tempo real e Inteligência Artificial RAG (Retrieval-Augmented Generation) para apoio ao ensino.

---

## 🚀 Fases de Implementação

### Fase 1: Arquitetura Base e SPA (Single Page Application)
- **Estruturação do Backend:** Desenvolvimento do core em Laravel, definindo os modelos de `Candidatura` (projetos), `CandidaturaProgresso`, e `CandidaturaFicheiro`.
- **Portal Público & Bento Grid:** Implementação da *landing page* (`portal.blade.php`) utilizando a estética "Bento Grid", muito comum em portefólios modernos, garantindo alta conversão e atratividade.
- **Glassmorphism e UI Premium:** Utilização de TailwindCSS para criação de painéis semitransparentes com efeito de desfoque de fundo (`backdrop-blur`), elevando o nível visual do portal.

### Fase 2: O "Workspace" Colaborativo
- **Integração do Sistema de Gestão de Tarefas (Kanban):**
  - Criação de uma interface *drag-and-drop* ou interativa para gestão de fluxo de trabalho.
  - Implementação completa do CRUD (Create, Read, Update, Delete) via requisições AJAX (`fetch`), permitindo a atualização das tarefas sem recarregar a página.
- **Chat Síncrono:**
  - Desenvolvimento de um módulo de mensagens bidirecional entre Docente/Mentor e o Grupo de Estudantes.
  - Implementação de *Polling* (ou WebSockets futuramente) e indicadores de "a escrever..." (*typing indicators*) com integração *cache* no Laravel.
- **Ícones Dinâmicos:** Migração para a biblioteca `Lucide Icons`, resolvendo problemas de renderização dinâmica no DOM com a função `lucide.createIcons()`.

### Fase 3: Integração de Inteligência Artificial RAG (O Paradigma "Agentic")
- **Transição de Provider (Gemini ➔ OpenRouter / gpt-4o):** Devido a intermitências e erros `503` com a API original do Gemini, efetuámos uma migração arquitetural para o Gateway OpenRouter, utilizando o LLM `gpt-4o`. Esta mudança reduziu a latência e virtualmente eliminou falhas de conectividade.
- **Funcionalidades de IA Implementadas:**
  1. **Análise de Contexto:** Avaliação semântica do estado do projeto.
  2. **Sugestão Automática de Tarefas:** O LLM analisa o "Rationale" e a Tecnologia do projeto, injetando automaticamente tarefas estruturadas na coluna "A Fazer" do Kanban.
  3. **Resumo de Progresso:** Um sistema de relatórios instantâneos focado no mentor para acelerar a correção.
- **"Modo Piloto Automático IA" (Assistente 24/7):**
  - Implementação inovadora de um "Assistente Académico Virtual".
  - O sistema interceta dúvidas enviadas pelos estudantes no Chat quando o Mentor está offline, consultando o contexto do projeto na BD (Tecnologia, Título, Membros) e retornando orientações práticas baseadas em boas práticas da engenharia de software e pesquisa académica.
  - Interface adaptada com ícones premium (e.g. `✨`) e diferenciação clara na UI do Chat (balões de mensagem azuis para estudantes, bronze para docentes e índigo com `sparkles` para a IA).

### Fase 4: Otimização e Prevenção de Erros
- **Gestão de Timeout e Robustez de API:** Implementação de limite de tokens (`max_tokens`) na resposta do LLM para otimizar os custos da API e adição de verificações estritas (`$response->successful()`) no `AiController`.
- **Tratamento UI de Exceções:** Substituição de `alert()` genéricos por modais atraentes e controláveis (SweetAlert2) com injeção de HTML para prevenir quebra do layout com textos de resposta da IA demasiado longos (uso de `max-h-[60vh] overflow-y-auto`).

---

## 🛠️ Stack Tecnológico Utilizado
- **Backend:** Laravel (PHP 8.x)
- **Frontend:** Blade, TailwindCSS, Vanilla JavaScript (Fetch API)
- **Componentes UI:** SweetAlert2 (Modais), Lucide (Ícones SVG)
- **Inteligência Artificial:** API REST (OpenRouter c/ `openai/gpt-4o`), *Prompt Engineering* RAG Contextual.
- **Infraestrutura/Deploy:** Script em Shell `deploy.sh` integrado com git-pull remoto no servidor Oracle Cloud.

---

## 🎓 Conclusão Científica Preliminar
O UniLicungo TechHub prova que sistemas monolíticos tradicionais (como Laravel) podem comportar-se como aplicações SPA altamente imersivas com o uso cirúrgico de chamadas AJAX e manipulação de estado do DOM. 

A inclusão do **LLM** diretamente como "um ator" no sistema (Pilotagem Automática de Mentoria), restrito por contexto RAG (Retrieval-Augmented Generation), demonstra uma redução considerável na carga de trabalho passiva do corpo docente, ao mesmo tempo que mantém os alunos engajados e desbloqueados técnica e academicamente fora do horário de aulas.
