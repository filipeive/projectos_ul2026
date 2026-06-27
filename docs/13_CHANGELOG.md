# 13 — Changelog
> **AcademicHub** | Registo de Todas as Alterações

Formato: `[Versão] — Data — Tipo — Descrição`

Tipos: `feat` (nova funcionalidade) | `fix` (correção) | `refactor` | `docs` | `style` | `chore`

---

## [v0.9] — 2026-06 — Estabilização e UI/UX Premium

### feat
- Bento Grid no Painel Administrativo com métricas em tempo real.
- Filtros inteligentes por estado e busca em tempo real (Admin).
- AI Advisor com export PDF e partilha via WhatsApp (Portal).
- Análise de clima e sentimento do chat para docentes.
- Sugestão automática de tarefas Kanban com identificação visual ✨.
- Piloto Automático (auto-reply) da IA no Workspace.
- Sugestão privada de resposta para o Docente antes de enviar.
- Tema Claro / Escuro / Sistema com persistência em localStorage.
- SMS Gateway multi-driver: HTTP SMS, Africa's Talking, Twilio, D7, Vonage.
- Preview de ficheiros em modal glassmorphism (PDF, imagem, vídeo, código).

### fix
- Corrigidas URLs de produção com subfolder `/projectos_ul`.
- Corrigido overflow horizontal em mobile no Workspace.
- Corrigido display das mensagens da IA no chat.

### refactor
- Login unificado numa única view com tabs ARIA.
- Chat balloons com design tokens consistentes.
- Migração de projetos estáticos para `resources/data/projects.json`.

### docs
- Criado `FLUXO_PLATAFORMA.md` com proposta executiva para Diretores.
- Criado `UI_UX_REFACTOR_REPORT.md` com auditoria completa.
- Atualizado `README.md` com guia de instalação completo.
- Reorganização de docs para pasta `docs/` com nomenclatura profissional.

---

## [v0.8] — 2026-05 — Workspace e IA Base

### feat
- Implementação do Workspace com Chat e Kanban.
- Integração OpenRouter (GPT-4o) para IA.
- Assistente RAG académico com contexto do projeto.
- Painel SaaS de gestão de utilizadores (Admin).
- Módulo de Pesquisa Académica (Guia do Investigador).

---

## [v0.7] — 2026-03 — Portal e Candidaturas

### feat
- Portal público com catálogo de projetos.
- Formulário de candidatura de grupo (modal).
- Aprovação/rejeição de candidaturas no painel Admin.

---

## [v0.1 — v0.6] — 2025/2026 — Fundações

### feat
- Setup inicial Laravel.
- Sistema de autenticação (email + PIN).
- Estrutura de routing.
- Jornadas Científicas 2026 — módulo inicial.
