# 15 — Meetings & Decisões
> **AcademicHub** | Registo de Reuniões e Decisões Tomadas

---

## Como Registar uma Reunião

Copia o template abaixo, preenche e adiciona em ordem cronológica (mais recente primeiro).

```markdown
## [YYYY-MM-DD] — Título da Reunião

**Participantes:** ...
**Duração:** ...

### Pontos Discutidos
-

### Decisões Tomadas
-

### Ações (Action Items)
| Ação | Responsável | Prazo |
|------|-------------|-------|
|      |             |       |
```

---

## [2026-06-27] — Sessão de Reorganização e Visão do Produto

**Participantes:** Filipe (Product Owner), Antigravity (Chief Architect)
**Duração:** ~3 horas

### Pontos Discutidos
- Revisão do estado atual da plataforma (v0.9 estável).
- Necessidade de expandir a visão além das Jornadas Científicas.
- Criação da branch `evol1.0` para o AcademicHub.
- Reorganização de branches e documentação.

### Decisões Tomadas
- O produto passa a chamar-se **AcademicHub** (branding provisório).
- Criada estrutura de documentação profissional em `docs/` com numeração `00_`, `01_`, etc.
- Branch `evol1.0` dedicada ao desenvolvimento da versão 1.0.
- Arquitetura do `Workspace` substituirá o conceito de `Grupo`.
- O `Knowledge Hub` será o próximo módulo major a implementar.
- Documentação passa a ser obrigatória antes de qualquer implementação.

### Ações (Action Items)
| Ação                                        | Responsável        | Prazo     |
|---------------------------------------------|--------------------|-----------|
| Completar toda a documentação base (`docs/`)| Antigravity        | 2026-06-27 |
| Definir schema do Workspace com papéis      | Filipe + Antigravity | Q3 2026  |
| Criar testes unitários prioritários         | Antigravity        | Q3 2026   |
| Planear Knowledge Hub (ADR + DB schema)     | Filipe + Antigravity | Q3 2026  |
