# 05 — Architecture Decision Records (ADR)
> **AcademicHub** | Registo de Decisões Arquiteturais

Cada decisão importante de design ou arquitetura deve ser registada aqui.

---

## ADR-001 — Uso de Monolito Modular em vez de Microserviços

- **Data:** 2026-01-01
- **Estado:** ✅ Aceite
- **Motivação:** A equipa é pequena e o prazo inicial era curto. Microserviços adicionariam complexidade operacional desnecessária nesta fase.
- **Alternativas Consideradas:** Microserviços com Laravel + Docker Swarm.
- **Impacto:** Maior velocidade de entrega inicial. Migração futura possível por módulo.
- **Decisão:** Monolito Laravel modular com Services isolados.

---

## ADR-002 — OpenRouter como Gateway de IA em vez de API Direta OpenAI

- **Data:** 2026-03-15
- **Estado:** ✅ Aceite
- **Motivação:** Flexibilidade para trocar o modelo de IA (GPT-4o, Llama, Claude) sem alterar o código.
- **Alternativas Consideradas:** OpenAI API direta, Google Gemini API.
- **Impacto:** Custo adicional de gateway, mas maior flexibilidade e controlo de modelos.
- **Decisão:** OpenRouter com modelo padrão `gpt-4o`.

---

## ADR-003 — Workspace substitui o conceito de Grupo

- **Data:** 2026-06-27
- **Estado:** 🚧 Proposta (evol1.0)
- **Motivação:** O conceito de "Grupo" é muito restrito. Um Workspace pode ter 1 ou mais estudantes, um supervisor, coorientador, júri e administrador.
- **Alternativas Consideradas:** Manter Grupo e adicionar papéis.
- **Impacto:** Refatoração do Model `Grupo` → `Workspace`. Necessita migração de dados.
- **Decisão:** Renomear e expandir para `Workspace` com papéis flexíveis.

---

## ADR-004 — Tailwind CSS como Design System

- **Data:** 2026-01-01
- **Estado:** ✅ Aceite
- **Motivação:** Produtividade na construção de UI responsiva sem CSS personalizado extenso.
- **Alternativas Consideradas:** Bootstrap, Material UI, CSS puro.
- **Decisão:** Tailwind CSS com tokens de glassmorphism e dark mode personalizados.

---

## ADR-005 — PIN de Estudante em vez de Password

- **Data:** 2026-02-01
- **Estado:** ✅ Aceite
- **Motivação:** Estudantes em zonas com fraca literacia digital têm dificuldade com passwords complexas. PINs numéricos são mais acessíveis.
- **Alternativas Consideradas:** Password + Email, Social Login.
- **Impacto:** Menor fricção no onboarding. Segurança compensada por SMS de verificação.
- **Decisão:** PIN de 4-6 dígitos com recuperação via SMS.

---

> **Como adicionar um novo ADR:**
> Copia o template abaixo, preenche e incrementa o número.

```markdown
## ADR-XXX — Título

- **Data:** YYYY-MM-DD
- **Estado:** 🚧 Proposta / ✅ Aceite / ❌ Rejeitada / 🗄️ Depreciada
- **Motivação:**
- **Alternativas Consideradas:**
- **Impacto:**
- **Decisão:**
```
