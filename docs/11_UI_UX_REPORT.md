# 11 — UI/UX Report
> **AcademicHub** | Relatório Contínuo de Interface e Experiência do Utilizador

> ⚠️ Este documento é **único e contínuo**. Nunca criar um novo. Sempre atualizar.

---

## Design System

### Paleta de Cores (Dark Mode — Padrão)
| Token                | Valor             | Uso                          |
|----------------------|-------------------|------------------------------|
| Background Base      | `slate-900`       | Fundo principal              |
| Superfície           | `slate-800/80`    | Cards, modais, sidebars      |
| Borda                | `slate-800/80`    | Separadores, inputs          |
| Texto Primário       | `white`           | Títulos, corpo               |
| Texto Secundário     | `slate-400`       | Labels, captions             |
| Accent Primário      | `indigo-500`      | CTAs, links, destaques       |
| Sucesso              | `emerald-500`     | Estados positivos            |
| Atenção              | `amber-500`       | Avisos                       |
| Erro                 | `red-500`         | Erros                        |

### Paleta de Cores (Light Mode — Institucional UniLicungo)
| Token                | Valor       | Uso                          |
|----------------------|-------------|------------------------------|
| Azul Primário        | `#00306e`   | Header, CTAs, destaques      |
| Azul Secundário      | `#1565c0`   | Links, hover states          |
| Verde Institucional  | `#1b5e20`   | Sucesso, badges              |
| Verde Claro          | `#2e7d32`   | Botões secundários           |
| Branco               | `#ffffff`   | Fundos, cards                |
| Cinza claro          | `#f4f7fb`   | Background de página         |
| Cinza médio          | `#e8edf4`   | Bordas, separadores          |
| Texto Primário       | `#0a1628`   | Títulos, corpo principal     |
| Texto Secundário     | `#475569`   | Labels, captions             |

### Tipografia
| Variante             | Fonte             |
|----------------------|-------------------|
| Corpo / Interface    | Inter, sans-serif |
| Monospace / Código   | JetBrains Mono    |

### Componentes Base
- **Bordas:** `rounded-xl` (inputs), `rounded-2xl` / `rounded-3xl` (cards, modais)
- **Área de Toque Mínima:** 44px × 44px (WCAG 2.2)
- **Espaçamento:** Múltiplos de 4px

---

## Avaliação por Página (Estado Atual)

| Página                       | UI    | UX    | Mobile | Acessibilidade |
|------------------------------|-------|-------|--------|----------------|
| Login Unificado              | 9.5   | 9.5   | 9.5    | 9.0            |
| Recuperação de PIN           | 9.2   | 9.2   | 9.5    | 9.0            |
| Portal (Catálogo)            | 8.2   | 8.0   | 8.2    | 7.5            |
| Workspace (Chat + Kanban)    | 8.5   | 8.3   | 8.0    | 7.5            |
| Painel Administrativo        | 8.0   | 8.0   | 7.8    | 7.5            |

> 🎯 **Objectivo desta sessão:** Aplicar paleta UniLicungo para elevar o Portal e Admin Dashboard para 9.0+ em UI e alinhar identidade visual com a instituição.

---

## Referências de Inspiração

- **Linear** (clareza e velocidade de UI)
- **Stripe** (premium, confiança)
- **Notion** (organização de informação)
- **GitHub** (familiar para devs)
- **Vercel / Shadcn** (dark mode moderno)

---

## Checklist de Qualidade por Componente

Para cada novo componente criado, validar:
- [ ] Responsivo em Mobile (< 640px)
- [ ] Responsivo em Tablet (640px–1024px)
- [ ] Responsivo em Desktop (> 1024px)
- [ ] Dark Mode correto
- [ ] Light Mode correto
- [ ] ARIA labels presentes
- [ ] Área de toque mínima 44px
- [ ] Sem overflow horizontal em mobile
- [ ] Console sem erros JS

---

## Histórico de Melhorias UI/UX

| Data       | Melhoria                                              |
|------------|-------------------------------------------------------|
| 2026-06-30 | Paleta UniLicungo aplicada ao portal e admin          |
| 2026-06-30 | Emojis removidos dos selects de candidatura           |
| 2026-06-27 | Candidatura Individual sem member2 obrigatório        |
| 2026-06    | Bento Grid no Painel Administrativo                   |
| 2026-06    | Filtros inteligentes em tempo real (Admin)            |
| 2026-06    | AI Advisor modal responsivo no Portal                 |
| 2026-06    | Export PDF de sugestões de IA                         |
| 2026-06    | Tema Claro / Escuro com persistência localStorage     |
| 2026-06    | Chat balloons responsivos e glassmorphism             |
| 2026-06    | Preview de ficheiros em modal flutuante               |
| 2026-05    | Login unificado com tabs ARIA                         |
