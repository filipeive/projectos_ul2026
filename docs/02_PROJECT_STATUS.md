# 02 — Project Status
> **AcademicHub** | Última Atualização: 2026-06-27 | Branch: `evol1.0`

---

## 🏷️ Estado Geral

| Campo              | Valor                                 |
|--------------------|----------------------------------------|
| **Versão Atual**   | `v0.9.2 — Design UniLicungo`          |
| **Branch Ativa**   | `evol1.0`                              |
| **Ambiente**       | Desenvolvimento / Pré-Produção         |
| **Servidor Local** | `php artisan serve` (porta 8000)       |
| **Última Deploy**  | 2026-06-30 — `master`                  |

---

## 📦 Módulos e Percentagem de Conclusão

| Módulo                          | Estado       | Progresso |
|----------------------------------|--------------|-----------|
| Portal Público (Landing)         | ✅ Concluído | 98%       |
| Candidatura Individual + Grupo   | ✅ Concluído | 100%      |
| Ideias Próprias (Submissão)      | ✅ Concluído | 95%       |
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

- Candidatura Individual e em Grupo com validação condicional.
- Submissão de ideias próprias com atribuição automática de número sequencial (>= 1000).
- Botão "Eliminar" condicional no dashboard admin (apenas para rejeitados).
- Botão de acesso dinâmico no portal (Dashboard para docentes, Workspace para estudantes).
- Logout explícito do Workspace com limpeza de sessão.
- SMS simplificado para httpSMS exclusivo (D7, Twilio, Vonage, Africa's Talking removidos).
- Emojis removidos dos selects do formulário de candidatura.
- Migração `member2_name nullable` aplicada em produção.
- Fix "Array to string" no AfricaTalkingService.
- Corrigida inconsistência nos docs: AdminController, UsersController, Visit.php documentados.
- Criado `16_SESSIONS.md` para histórico de sessões de trabalho.

---

## ⏳ Pendências

- [ ] Testes unitários e de integração (PHPUnit).
- [ ] Módulo de notificações por email.
- [ ] Painel de analytics agregado para a Coordenação.

---

## ⚠️ Problemas Conhecidos

- Nginx em produção pode retornar 404 para rotas POST com prefixo `/projectos_ul` se `try_files` não incluir `$query_string`.
- Configurar `try_files $uri $uri/ /projectos_ul/index.php?$query_string;` no bloco `location /projectos_ul/` do Nginx.

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
