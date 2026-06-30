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
**Controller:** `PortalController` (métodos com prefixo `admin*`)
**Views:** `resources/views/admin-dashboard.blade.php`

> ⚠️ Nota arquitetural: Não existe `AdminController.php` separado. Toda a lógica administrativa está centralizada no `PortalController`. A refatoração para um `AdminController` dedicado está planeada para v1.1.

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
**Service:** `SmsService` (implementado via httpSMS)

**Fornecedor ativo:**
- httpSMS, configurado por `HTTPSMS_KEY` e `HTTPSMS_FROM`

**Notas operacionais:**
- Integrações antigas com D7, Twilio, Vonage e Africa's Talking foram removidas.
- A classe foi simplificada e padronizada para httpSMS exclusivo.

---

## 07 — Visitas (Modelo Visit)

**Responsabilidade:** Registo de visitas ao portal público.
**Model:** `Visit.php`

> Estado: Modelo existe mas sem controller ou views associadas. Funcionalidade de analytics de visitas planeada para v1.1.

---

## Estrutura de Ficheiros

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AiController.php         # Toda a lógica de IA
│   │   ├── AuthController.php       # Login, logout, PIN
│   │   ├── PortalController.php     # Portal público + Admin
│   │   └── WorkspaceController.php  # Workspace, chat, kanban
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Candidatura.php
│   ├── CandidaturaFicheiro.php
│   ├── CandidaturaProgresso.php
│   ├── KanbanTask.php
│   ├── WorkspaceMessage.php
│   └── Visit.php                    # Registo de visitas (analytics futuro)
└── Services/
    └── SmsService.php               # SMS via httpSMS

resources/views/
├── auth/
│   ├── login.blade.php
│   ├── forgot-password.blade.php
│   └── reset-password.blade.php
├── workspace/
│   ├── index.blade.php
│   ├── recover-pin.blade.php
│   └── recover-pin-geral.blade.php
├── pdf/
│   └── comprovativo.blade.php
├── admin-dashboard.blade.php
└── portal.blade.php
```
