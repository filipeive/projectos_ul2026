# 07 — Modules
> **AcademicHub** | Mapeamento de Módulos do Sistema

---

## Visão Geral

O sistema está organizado em módulos funcionais independentes. Cada módulo tem o seu Controller, Views e rotas definidas.

---

## 01 — Portal (Módulo Público)

**Responsabilidade:** Ponto de entrada público da plataforma.
**Controller:** `PortalController`
**Views:** `resources/views/portal.blade.php`

**Funcionalidades:**
- Listagem de projetos disponíveis (via `resources/data/projects.json`)
- Filtros por categoria e busca em tempo real
- Formulário de candidatura de grupo (modal)
- AI Advisor (Gerador de Ideias via OpenRouter)
- Export PDF das sugestões de IA
- Guia do Investigador / Módulo de Pesquisa Académica

---

## 02 — Autenticação

**Responsabilidade:** Controlo de acesso de todos os tipos de utilizador.
**Controller:** `AuthController`
**Views:** `resources/views/auth/login.blade.php`

**Funcionalidades:**
- Login unificado (Docente via email/password; Estudante via email+PIN)
- Recuperação de PIN via SMS (`workspace/recover-pin.blade.php`)
- Logout seguro

---

## 03 — Workspace (Sala de Projeto)

**Responsabilidade:** Ambiente colaborativo do grupo de projeto.
**Controller:** `WorkspaceController`
**Views:** `resources/views/workspace/index.blade.php`

**Funcionalidades:**
- Chat de mensagens em tempo real (polling)
- Kanban de tarefas (drag & drop)
- Repositório de ficheiros (upload + preview)
- Assistente IA integrado (piloto automático / sugestões)
- Análise de clima e sentimento do chat
- Resumo de progresso semanal
- Sugestão automática de tarefas Kanban

---

## 04 — Administração

**Responsabilidade:** Controlo e gestão de toda a plataforma.
**Controller:** `AdminController`
**Views:** `resources/views/admin-dashboard.blade.php`

**Funcionalidades:**
- Dashboard com Bento Grid de métricas
- Listagem e aprovação/rejeição de candidaturas
- Filtros e busca em tempo real
- Gestão de utilizadores

---

## 05 — Inteligência Artificial

**Responsabilidade:** Centralizar todos os pedidos à API de IA.
**Controller:** `AiController`
**Service:** (futuro: `AiService`)

**Funcionalidades:**
- `generateIdea`: Geração de ideias de projeto para o Portal
- `suggestTasks`: Sugestão de tarefas Kanban baseadas no projeto
- `analyzeChatClimate`: Análise do sentimento do chat
- `summarizeProgress`: Resumo de progresso semanal
- `assistantReply`: Copiloto interativo no chat
- `autoReply`: Resposta automática (piloto automático do docente)

---

## 06 — SMS Gateway

**Responsabilidade:** Envio de notificações por SMS.
**Service:** `AfricaTalkingService` (nome legado; implementação atual via httpSMS)

**Fornecedor ativo:**
- httpSMS, configurado por `HTTPSMS_KEY` e `HTTPSMS_FROM`

**Notas operacionais:**
- `SMS_DRIVER` deixou de controlar o fornecedor.
- Integrações antigas com D7, Twilio, Vonage e Africa's Talking foram removidas para evitar fallbacks incorretos em produção.

---

## Estrutura de Ficheiros

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── AiController.php
│   │   ├── AuthController.php
│   │   ├── PortalController.php
│   │   ├── WorkspaceController.php
│   │   └── UsersController.php
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Candidatura.php
│   └── (Workspace, Task, Message...)
└── Services/
    └── AfricaTalkingService.php

resources/views/
├── auth/
│   └── login.blade.php
├── workspace/
│   ├── index.blade.php
│   ├── recover-pin.blade.php
│   └── recover-pin-geral.blade.php
├── admin-dashboard.blade.php
└── portal.blade.php
```
