# 16 — Sessions Log
> **AcademicHub** | Histórico de Sessões de Trabalho

> ⚠️ Este documento é **único e contínuo**. Nunca criar um novo. Sempre adicionar entradas no topo.

---

## Formato de Entrada

```
## [AAAA-MM-DD] Título da Sessão
**Branch:** `nome-da-branch`
**Duração estimada:** Xh
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
O que motivou esta sessão.

### Decisões Tomadas
- Decisão 1
- Decisão 2

### Trabalho Realizado
- Tarefa concluída 1
- Tarefa concluída 2

### Pendências / Próximos Passos
- [ ] Tarefa pendente
```

---

## [2026-06-30] Ritual de Início + Design UniLicungo + Limpeza de Dívida Técnica
**Branch:** `evol1.0`
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
Sessão iniciada com o ritual de `0_A_Inicio_ritual.md`. Leitura completa da documentação, auditoria de inconsistências entre docs e código, e arranque da evolução visual alinhada com a identidade da Universidade Licungo.

### Diagnóstico Inicial (Inconsistências Detectadas)
- `AdminController` referenciado nos docs mas não existe — lógica está no `PortalController`.
- `UsersController` referenciado nos docs mas não existe.
- `Visit.php` Model existe no código mas não está documentado.
- `02_PROJECT_STATUS.md` tinha data de deploy desatualizada (2026-06-27 em vez de 2026-06-30).
- `11_UI_UX_REPORT.md` não mencionava alinhamento com as cores da UniLicungo.

### Decisões Tomadas
- Ordem de execução: B (Limpeza Docs) → A (Design UniLicungo) → C (Funcional v1.0).
- Manter branch `evol1.0` para desenvolvimento; merge para `master` antes de cada deploy.
- Design system institucional baseado na identidade UniLicungo: azul `#00306e` + verde `#1b5e20` + branco.
- Documentar todas as sessões neste ficheiro.

### Trabalho Realizado
- [x] Criado `docs/16_SESSIONS.md` (este ficheiro).
- [x] Corrigida documentação: `04_ARCHITECTURE.md`, `07_MODULES.md` alinhados com estrutura real de Controllers.
- [x] Adicionado `Visit.php` ao `06_DATABASE.md`.
- [x] Atualizado `02_PROJECT_STATUS.md` com data de deploy correcta e SMS corrigido.
- [x] Iniciada aplicação do design system UniLicungo ao portal.

### Pendências / Próximos Passos
- [ ] Aplicar paleta UniLicungo ao `portal.blade.php` (header, hero, cards)
- [ ] Aplicar paleta UniLicungo ao `admin-dashboard.blade.php`
- [ ] Atualizar `11_UI_UX_REPORT.md` com novo Design System institucional
- [ ] Sistema de Fases do Projeto com timeline visual (v1.0 Roadmap)

---

## [2026-06-27] Candidaturas Flexíveis + Deploy Pipeline
**Branch:** `evol1.0`
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
Continuação da estabilização da plataforma em produção. Foco em candidaturas individuais, ideias próprias e controlo administrativo de deleção.

### Trabalho Realizado
- [x] Candidatura Individual vs Grupo com validação condicional no `PortalController@submit`.
- [x] Submissão de ideias próprias (project_number >= 1000).
- [x] Botão "Eliminar" no dashboard admin (apenas para rejeitados), com SweetAlert2.
- [x] Botão de acesso dinâmico no portal (Dashboard/Workspace conforme papel).
- [x] Logout explícito do Workspace.
- [x] Migração `make_member2_columns_nullable` em produção.
- [x] Fix "Array to string" no `AfricaTalkingService`.
- [x] SMS simplificado para httpSMS exclusivo.
- [x] Emojis removidos dos selects do formulário de candidatura.
- [x] Deploy automático com `composer install` + `php artisan migrate --force`.

### Pendências resolvidas nesta sessão
- Erro 500 DomPDF em produção → resolvido com `composer install`.
- Erro `member2_name cannot be null` → resolvido com migração nullable.
- SMS "Array to string" → resolvido com `is_array()` + `json_encode()`.

---

## [2026-06-23] UI/UX Premium + IA + Workspace Mobile
**Branch:** `evol1.0`
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
Grande sessão de modernização da plataforma com foco em UX, IA e responsividade mobile.

### Trabalho Realizado
- [x] Bento Grid no Painel Administrativo.
- [x] Filtros inteligentes em tempo real.
- [x] AI Advisor no Portal com export PDF.
- [x] Análise de sentimento do chat.
- [x] Sugestão de tarefas Kanban com IA.
- [x] Piloto automático IA (auto-reply).
- [x] Tema Claro / Escuro / Sistema com persistência localStorage.
- [x] SMS Gateway httpSMS integrado.
- [x] Preview de ficheiros em modal glassmorphism.
- [x] Ajustes mobile do Workspace (header compacto, chat sem overflow, Kanban).
- [x] Criada suite completa de documentação (`docs/00` a `docs/15`).
