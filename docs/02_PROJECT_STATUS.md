# 02 — Project Status
> **AcademicHub** | Última Atualização: 2026-06-27 | Branch: `evol1.0`

---

## 🏷️ Estado Geral

| Campo              | Valor                           |
|--------------------|----------------------------------|
| **Versão Atual**   | `v0.9 — Estabilização`           |
| **Branch Ativa**   | `evol1.0`                        |
| **Ambiente**       | Desenvolvimento / Pré-Produção   |
| **Servidor Local** | `php artisan serve` (porta 8000) |
| **Última Deploy**  | 2026-06-27 — `master`            |

---

## 📦 Módulos e Percentagem de Conclusão

| Módulo                          | Estado       | Progresso |
|----------------------------------|--------------|-----------|
| Portal Público (Landing)         | ✅ Concluído | 95%       |
| Candidatura de Grupos            | ✅ Concluído | 95%       |
| Autenticação (Login / PIN)       | ✅ Concluído | 100%      |
| Workspace (Chat + Kanban)        | ✅ Concluído | 90%       |
| Assistente IA (OpenRouter)       | ✅ Concluído | 85%       |
| Painel Administrativo            | ✅ Concluído | 85%       |
| Sistema de SMS                   | ✅ Concluído | 90%       |
| Tema Claro / Escuro              | ✅ Concluído | 100%      |
| Mobile Responsiveness            | ✅ Concluído | 90%       |
| Testes Automatizados             | ⏳ Pendente  | 10%       |
| Multi-faculdade / Multi-curso    | 🔲 Futuro    | 0%        |
| Relatórios e Analytics           | 🔲 Futuro    | 0%        |

---

## ✅ Melhorias Implementadas Recentemente

- Bento Grid no Painel Administrativo com filtros inteligentes em tempo real.
- PDF Export e partilha de ideias do AI Advisor no Portal.
- Análise de sentimento e clima do chat (para docentes).
- Sugestão de tarefas Kanban com IA contextualizada.
- Tema claro institucional com persistência em `localStorage`.

---

## ⏳ Pendências

- [ ] Testes unitários e de integração (PHPUnit).
- [ ] Módulo de notificações por email.
- [ ] Painel de analytics agregado para a Coordenação.

---

## ⚠️ Problemas Conhecidos

- Nenhum crítico em produção identificado neste momento.

---

## 🔮 Próximas Funcionalidades (Planejadas)

Ver `03_ROADMAP.md`.

---

## 🔴 Riscos

| Risco                        | Probabilidade | Impacto |
|------------------------------|---------------|---------|
| Custos da API de IA (OpenRouter) | Médio        | Médio   |
| Ausência de cobertura de testes  | Alto         | Alto    |
| Escalabilidade sem multi-tenancy | Médio        | Alto    |
