# 04 — Architecture
> **AcademicHub** | Arquitetura do Sistema

---

## Visão Geral

O AcademicHub segue uma arquitetura **Monolítica Modular** assente no padrão **MVC do Laravel**, com camadas de serviço bem definidas para isolar a lógica de negócio, integrações externas e regras de apresentação.

```
┌─────────────────────────────────────────────────────────┐
│                    CAMADA DE APRESENTAÇÃO               │
│  Blade Templates (Glassmorphism / Tailwind / Vanilla JS)│
└────────────────────────┬────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────┐
│                    CAMADA DE CONTROLO (HTTP)             │
│  Controllers:                                           │
│  - PortalController    - WorkspaceController            │
│  - AiController        - AdminController                │
│  - AuthController      - UsersController                │
└────────────────────────┬────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────┐
│                    CAMADA DE SERVIÇOS                   │
│  - AfricaTalkingService (SMS)                           │
│  - AiService (OpenRouter)                              │
│  (futuros: NotificationService, WorkspaceService...)   │
└────────────────────────┬────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────┐
│                    CAMADA DE DADOS (Eloquent ORM)       │
│  Models: User, Candidatura, Workspace, Task, Message... │
└────────────────────────┬────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────┐
│                    BASE DE DADOS                        │
│  MySQL / MariaDB                                        │
└─────────────────────────────────────────────────────────┘
```

---

## Stack Tecnológico

| Camada            | Tecnologia              |
|-------------------|-------------------------|
| Backend           | Laravel 11 (PHP 8.3)    |
| Frontend          | Blade + Tailwind CSS v3 |
| JavaScript        | Vanilla JS (Fetch API)  |
| Base de Dados     | MySQL / MariaDB         |
| IA                | OpenRouter (GPT-4o)     |
| SMS               | Africa's Talking / HTTP SMS |
| Autenticação      | Laravel Sessions + PIN  |
| Deploy            | bash `deploy.sh` + VPS  |

---

## Princípios Arquiteturais

1. **Mobile First**: Toda interface concebida primeiro para smartphone.
2. **Escalabilidade Progressiva**: Monolito modular pronto para extração de serviços.
3. **Camadas Isoladas**: Lógica de negócio fora dos Controllers (usar Services).
4. **Segurança by Design**: Validação, autorização e sanitização em cada camada.
5. **IA como Serviço Transversal**: Não acoplada a nenhum módulo específico.

---

## Fluxo de Pedido HTTP

```
Browser → Route → Middleware → Controller → Service → Model → DB
                                    ↓
                                Blade View ← Response
```

---

## Módulos Principais

| Módulo          | Responsabilidade                          |
|-----------------|-------------------------------------------|
| Portal          | Landing page, catálogo, candidaturas       |
| Auth            | Login, PIN recovery, sessões              |
| Workspace       | Chat, Kanban, ficheiros, IA               |
| Admin           | Dashboard, aprovações, métricas           |
| AI              | OpenRouter API, prompts, segurança        |
| SMS             | Gateways de envio de mensagens            |

Ver detalhes em `07_MODULES.md`.
