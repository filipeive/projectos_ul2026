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

## [2026-06-30] Notificações Automáticas de Aprovação de Projetos (E-mail & SMS)
**Branch:** `master`
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
Implementação de notificações automáticas via e-mail e SMS para informar o grupo de estudantes quando o seu projeto for aprovado por um docente/administrador. A notificação inclui um link de acesso direto que preenche automaticamente o e-mail do grupo no formulário de login para otimizar a experiência de utilizador.

### Decisões Tomadas
- Adicionar lógica de envio de notificações na função `updateStatus` do `PortalController` quando o estado da candidatura é atualizado de um estado diferente para "Aprovado".
- Utilizar o `SmsService` recém-refatorado para enviar mensagens SMS via httpSMS.
- Utilizar `Mail::raw` do Laravel de forma assíncrona/segura (envolta em blocos try-catch) para evitar que falhas no servidor de correio ou SMS interrompam o fluxo da aplicação.
- Modificar a vista de login (`auth/login.blade.php`) para detetar parâmetros de URL (`email` ou `contact_email`) e pré-preencher o campo de e-mail do grupo de estudantes.

### Trabalho Realizado
- [x] Implementado o envio de e-mails de aprovação no `PortalController@updateStatus`.
- [x] Implementado o envio de SMS de aprovação no `PortalController@updateStatus` usando `SmsService`.
- [x] Adicionado suporte a preenchimento automático de e-mail na vista `auth/login.blade.php`.
- [x] Criado o teste unitário/integração `test_admin_approving_candidatura_triggers_notifications` em `tests/Feature/ExampleTest.php` utilizando `Event::fake` para validar o envio correto do e-mail ao destinatário sem disparar envios reais.
- [x] Todos os 11 testes e 27 asserções passados com sucesso.

### Pendências / Próximos Passos
- [ ] Efetuar novo deploy em produção para disponibilizar a funcionalidade de notificações em tempo real.

---

## [2026-06-30] Correção do Dark Mode & Ajuste de Especificidade de CSS
**Branch:** `master`
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
Resolução de um bug visual em que o fundo da página (body) e os cabeçalhos (header) do portal não alteravam corretamente para o modo escuro (Dark Mode). Isso acontecia devido à especificidade das classes estáticas claras (como `.bg-ul-cream` e `.bg-white`) aplicadas nos elementos HTML do portal, que se sobrepunham às definições globais do tema escuro do Tailwind.

### Decisões Tomadas
- Adicionar regras globais de sobreposição para o tema escuro (`html[data-theme="dark"]` e `html.dark`) em `public/style.css` usando `!important` para garantir a precedência dos estilos escuros sobre os estilos claros estáticos do Tailwind.
- Otimizar a lógica visual do componente de Abas de Navegação (Navigation Tab Bar) desacoplando a manipulação direta de classes Tailwind no JavaScript, passando a usar o estado de acessibilidade `aria-selected` como seletor primário no CSS para estilização de estados ativo e inativo (em ambos os temas).
- Incrementar a versão da query string de carregamento do CSS e JS (`?v=theme-20260630`) em todos os templates Blade para forçar a quebra de cache (cache-busting) nos navegadores.

### Trabalho Realizado
- [x] Adicionadas regras específicas em `public/style.css` para forçar o fundo do body para `#070a13` e o header para `#0b0f19` sob o tema escuro.
- [x] Mapeamento de cores institucionais UniLicungo em modo escuro (azul escuro `.text-ul-blue` mapeado para sky-400, verde escuro `.text-ul-green` para emerald-400).
- [x] Otimização visual do seletor `.dark-only` para exibir corretamente as esferas de brilho neon (glow blobs) apenas no modo escuro.
- [x] Refatoração do script de troca de abas em `resources/views/portal.blade.php` para simplificar e gerir puramente o atributo `aria-selected`.
- [x] Criação de regras CSS baseadas em `[aria-selected]` para estilização limpa e reativa das abas em ambos os temas.
- [x] Atualização de todos os links de ativos (`style.css` e `theme.js`) com cache buster `?v=theme-20260630` em `portal.blade.php`, `admin-dashboard.blade.php`, `workspace/index.blade.php`, etc.

### Pendências / Próximos Passos
- [ ] Validar a experiência de utilizador em múltiplos tamanhos de ecrã sob os dois modos de cor.

---

## [2026-06-30] Consolidação UI/UX com Ícones Lucide & Padronização SMS (httpSMS)
**Branch:** `evol1.0`
**Participantes:** Chief Architect + Filipe dos Santos

### Contexto
Substituição definitiva de quaisquer resíduos de emojis por ícones Lucide estruturados em todos os menus dropdown (select) do portal, workspace e painel de administração, garantindo que o design system da UniLicungo apresente um visual premium. Adicionalmente, refatorou-se o serviço legado de SMS para uma classe padronizada e limpa (`SmsService`).

### Decisões Tomadas
- Renomear a classe `AfricaTalkingService` para `SmsService` e remover o ficheiro antigo para eliminar a dívida técnica do nome legado.
- Envolver todos os elementos `<select>` em containers relativos com ícones absolutos à esquerda, padronizando o preenchimento interno com `pl-10` ou `pl-9` para manter consistência visual com os inputs de texto.

### Trabalho Realizado
- [x] Renomeado `AfricaTalkingService` para `SmsService` em `app/Services/SmsService.php`.
- [x] Atualizadas todas as referências ao serviço de SMS em `PortalController`, `WorkspaceController` e documentação de arquitetura/módulos.
- [x] Removido o arquivo legado `app/Services/AfricaTalkingService.php`.
- [x] Adicionados ícones Lucide e wrappers relativos aos select de Dificuldade (`award`) e Tecnologia (`cpu`) nos filtros do Catálogo.
- [x] Adicionados ícones Lucide aos select do formulário de candidatura: Projeto (`lightbulb`) e Tecnologia Principal (`code-2`).
- [x] Adicionados ícones Lucide aos select de alteração de Fase (`git-commit`) e Estado (`activity`) no Workspace do Estudante.
- [x] Adicionado ícone Lucide ao select de Coluna Inicial (`columns`) no modal do Kanban.
- [x] Adicionados ícones Lucide aos selects de Alocação de Mentor (`user-check`) e de Cargo (`shield`) no Painel de Administração.
- [x] Validação com sucesso da suite de testes PHPUnit (6 testes, 12 asserções passadas).

### Pendências / Próximos Passos
- [ ] Monitorar a entrega de mensagens SMS em ambiente real após a configuração de chaves HTTPSMS de produção.

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
