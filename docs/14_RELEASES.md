# 14 — Releases
> **AcademicHub** | Registo Oficial de Versões

---

## Como Criar uma Release

1. Finalizar e testar todas as features da versão.
2. Atualizar `13_CHANGELOG.md`.
3. Atualizar `02_PROJECT_STATUS.md`.
4. Fazer merge para `master` via Pull Request.
5. Criar tag Git: `git tag -a v1.0.0 -m "Release v1.0.0 — AcademicHub Base"`
6. Fazer push da tag: `git push origin --tags`
7. Registar aqui.

---

## v0.9.0 — 2026-06-27 — Estabilização
> Branch: `master` | Tag: *(não tagueada ainda)*

**Resumo:** Versão de estabilização com UI/UX premium completa, IA integrada e painel administrativo reformulado.

**Funcionalidades Principais:**
- Painel Admin com Bento Grid e filtros inteligentes
- AI Advisor com export PDF
- Workspace com análise de sentimento e sugestão de tarefas IA
- Tema Claro/Escuro com persistência
- SMS Gateway via httpSMS

**Deploy:** VPS + `deploy.sh`
**Ambiente:** Produção

---

## v1.0.0 — [Data Prevista: Q3 2026] — AcademicHub Base
> Branch: `evol1.0` → `master` | Tag: `v1.0.0`

**Funcionalidades Planeadas:**
- Workspace com papéis flexíveis (multi-papel)
- Knowledge Hub (Banco de Ideias)
- Testes automatizados (PHPUnit/Pest)
- Notificações por email
- Analytics de progresso para Coordenação

---

## Convenção de Versões

Seguimos [Semantic Versioning (SemVer)](https://semver.org/):

```
MAJOR.MINOR.PATCH

MAJOR — Mudanças incompatíveis ou arquiteturais grandes
MINOR — Novas funcionalidades retrocompatíveis
PATCH — Correções de bugs
```
