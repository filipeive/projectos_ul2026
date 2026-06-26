# Relatório de Auditoria e Refatoração UI/UX — UniLicungo TechHub

Este documento serve como a **Documentação Contínua** do processo de refatoração de toda a interface da plataforma **UniLicungo TechHub**, seguindo as orientações e diretrizes de um produto de classe SaaS premium.

---

## 🗺️ Mapeamento de Ficheiros e Componentes do Projeto

A plataforma é composta por 7 vistas Blade ativas que compõem o ecossistema. Atualmente, cada ficheiro Blade funciona como um monólito HTML5 completo, importando individualmente scripts e folhas de estilo.

| # | Caminho do Blade | Função / Tipo de Página | Esta| 1 | `resources/views/portal.blade.php` | Catálogo de Projetos & Candidatura (Página Principal) | Pendente |
| 2 | `resources/views/auth/login.blade.php` | Central de Acesso (Login Unificado Estudante/Docente) | **Concluído** |
| 3 | `resources/views/admin-dashboard.blade.php` | Painel de Coordenação / Mentoria (Admin/Docente) | Pendente |
| 4 | `resources/views/workspace/index.blade.php` | Sala de Mentoria & Workspace Kanban (Estudante/Docente) | Pendente |
| 5 | `resources/views/workspace/recover-pin.blade.php` | Recuperação de PIN específica para grupo | **Concluído** |
| 6 | `resources/views/workspace/recover-pin-geral.blade.php` | Recuperação de PIN geral | **Concluído** |
| 7 | `resources/views/pdf/comprovativo.blade.php` | Exportação de Ficha de Registo em PDF (DomPDF) | Conservado |

---

## 🎨 Design System Global

Para garantir consistência e harmonia em toda a plataforma, estabelecemos um **Design System Global** unificado, baseado na marca institucional da **Universidade Licungo**:

### 1. Paleta de Cores (Design Tokens)
*   **Primary (Licungo Blue):** `#008ad2` | Tailwind `sky-500` (Acentos de progresso, botões primários, branding).
*   **Secondary (Licungo Gold):** `#c27a1e` | Tailwind `amber-500` (Acentos de destaque, avisos, estados pendentes).
*   **Background (Escuro Premium):** `#070a13` (Fundo geral de alta imersão, contrastando com luz azul difusa).
*   **Surface (Cartões e Painéis):** `rgba(11, 15, 25, 0.7)` com `backdrop-filter: blur(12px)` e borda semi-transparente `border-slate-800/80` (Estilo Glassmorphism).
*   **Text Principal:** `#f8fafc` | Tailwind `slate-50`.
*   **Text Secundário (Muted):** `#94a3b8` | Tailwind `slate-400`.
*   **Success (Aprovado):** Tailwind `emerald-500` / `emerald-400`.
*   **Danger (Rejeitado/Erro):** Tailwind `rose-500` / `rose-400`.

### 2. Tipografia
*   **Títulos / Display:** Fonte `Outfit`, sans-serif (Visual limpo, moderno, levemente geométrico).
*   **Corpo / Inputs / Tabelas:** Fonte `Inter`, sans-serif (Elevada legibilidade em ecrãs pequenos).
*   **Metadados / Status / Códigos:** Fonte Mono (Ex: `JetBrains Mono` ou monospace do sistema).

### 3. Layout e Espaçamento
*   **Bordas:** Usar cantos suaves e arredondados (`rounded-xl` para inputs/botões, `rounded-2xl` a `rounded-3xl` para cartões e modais).
*   **Áreas de Toque (Mobile First):** Botões e links com área de toque mínima de **44px x 44px** para cumprir os requisitos de acessibilidade móvel (WCAG 2.2).
*   **Espaçamento Base:** Escala de múltiplos de 4px (`p-2`, `p-4`, `p-6`, `p-8`).

---

## 📊 Auditoria Inicial e Diagnóstico de Páginas

Abaixo, detalhamos o estado atual de cada página com avaliações de qualidade (0-10):

### 1. Central de Acesso (`resources/views/auth/login.blade.php`)
*   **UI:** 9.5/10 (Refatorado) — Visual escuro ultra-moderno com anéis de foco coloridos nos inputs e bordas suaves.
*   **UX:** 9.5/10 (Refatorado) — Micro-interações ao submeter o formulário (desativa o botão com um spinner de carregamento); transição de tabs com feedback instantâneo.
*   **Responsividade (Mobile/Tablet/Desktop):** 9.5/10 | 9.5/10 | 9.5/10.
*   **Acessibilidade (WCAG):** 9/10 (Refatorado) — Estrutura de abas com `role="tablist"`, `role="tab"` e `aria-selected` dinâmicos; inputs devidamente rotulados com IDs e `for` nos labels; autocomplete correto.
*   **Consistência:** 10/10.

### 2. Recuperação de PIN (`workspace/recover-pin.blade.php` e `workspace/recover-pin-geral.blade.php`)
*   **UI:** 9.2/10 (Refatorado) — Estilo glassmorphism unificado; ícone de chave animado (`animate-pulse`).
*   **UX:** 9.2/10 (Refatorado) — Botão de envio com spinner integrado no evento de submissão para evitar múltiplos cliques acidentais.
*   **Responsividade:** 9.5/10.
*   **Acessibilidade:** 9/10 (Refatorado) — Campos associados semanticamente via labels explícitos; foco e contorno acessíveis para navegação por teclado.

### 3. Catálogo de Projetos (`resources/views/portal.blade.php`)
*   **UI:** 8.2/10 — Bento grid de projetos e design moderno.
*   **UX:** 8/10 — Bom fluxo para visualizar detalhes, porém o formulário de candidatura é um modal longo que pode assustar em dispositivos móveis.
*   **Responsividade:** 8.2/10.
*   **Acessibilidade:** 6.5/10 — Os filtros superiores não indicam estado `aria-selected` de forma semântica. O modal longo é difícil de navegar via tabulador de teclado.
*   **Diagnóstico:**
    *   *Problemas:* Filtros sem feedbacks acessíveis. No formulário de candidatura móvel, os campos ficam muito apertados.
    *   *Melhorias:* Otimizar o formulário de candidatura tornando-o mais segmentado visualmente; adicionar feedback acessível nos botões de filtro; refinar animações de hover nos cards.

### 4. Painel de Administração (`resources/views/admin-dashboard.blade.php`)
*   **UI:** 7.8/10 — Painel rico em informações, mas com tabelas densas.
*   **UX:** 7.5/10 — Ecrã muito carregado no desktop, e no mobile as tabelas quebram ou exigem scroll horizontal excessivo.
*   **Responsividade:** 7/10 — Sofre no mobile devido à grande quantidade de colunas e dados.
*   **Acessibilidade:** 6/10 — Contraste fraco nos badges de status e tabelas difíceis de ler por leitores de ecrã.
*   **Diagnóstico:**
    *   *Problemas:* Falta de responsividade nativa em tabelas complexas; filtros do dashboard são confusos no telemóvel; modais de edição podem transbordar da tela.
    *   *Melhorias:* Implementar visualização responsiva de cartões (Card List) no mobile que se transforma em tabela estruturada no desktop. Adicionar estados vazios (Empty States) elegantes e melhorar a hierarquia visual das métricas.

### 5. Sala de Mentoria (`resources/views/workspace/index.blade.php`)
*   **UI:** 8.4/10 — Kanban estruturado e chat moderno.
*   **UX:** 8/10 — Interface interativa excelente, mas o painel lateral de ficheiros e membros pode apertar o chat em ecrãs médios.
*   **Responsividade:** 8/10 — Melhorada recentemente, mas o layout de três colunas (Ficheiros/Membros + Chat + Kanban) precisa de abas bem definidas no mobile.
*   **Acessibilidade:** 6.8/10.
*   **Diagnóstico:**
    *   *Problemas:* A navegação do chat e do kanban no mobile exige alternância fluida de abas. O preview de ficheiros em ecrãs pequenos precisa de máxima área útil.
    *   *Melhorias:* Refinar a alternância de painéis em ecrãs pequenos (estilo Bottom Navigation ou Tabs nativas de aplicação); unificar o comportamento do chat e da lista de tarefas para parecer um aplicativo nativo.

---

## 🚀 Plano de Refatoração Contínua (Etapas)

1.  **Fase 1: Central de Acesso & Recuperação de PIN** (Concluído ✅) -> Refatoração da estética, acessibilidade ARIA, focus outlines, ícones interativos e loading states em logins/pins.
2.  **Fase 2: Catálogo de Projetos (Portal)** (Concluído ✅) -> Refinamento de filtros, animações, acessibilidade de modais, multi-step form de candidatura e geração de PDF da Inteligência Artificial.
3.  **Fase 3: Sala de Mentoria (Workspace)** (Concluído ✅) -> Unificação do visual Glassmorphism, responsividade mobile de alto impacto no chat e ficheiros, e customização global dos SweetAlerts da IA.
4.  **Fase 4: Painel de Administração (Dashboard)** (Pendente ⏳) -> Otimização de tabelas para mobile, métricas Bento Grid polidas e filtros inteligentes.

---
*Nota: Este relatório será atualizado à medida que as fases forem concluídas.*
