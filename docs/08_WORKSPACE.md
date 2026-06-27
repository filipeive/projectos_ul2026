# 08 — Workspace
> **AcademicHub** | Especificação do Módulo Workspace

---

## Conceito

O **Workspace** é a unidade central de trabalho académico no AcademicHub.

> Não é um "Grupo". É um ambiente colaborativo completo com papéis, comunicação, gestão de tarefas e suporte inteligente por IA.

---

## Princípio

Um Workspace pode ter:
- 1 ou mais estudantes
- 1 Supervisor (Docente principal)
- 1 Coorientador (opcional)
- 1 ou mais membros do Júri (na fase de avaliação)
- 1 Coordenador de Curso (acesso de leitura)
- 1 Administrador (acesso total)

---

## Papéis no Workspace (v1.0)

| Papel           | Abreviatura | Permissões                                         |
|-----------------|-------------|----------------------------------------------------|
| Estudante       | `student`   | Enviar mensagens, gerir tarefas, fazer upload       |
| Supervisor      | `supervisor`| Tudo + aprovar tarefas, usar IA privada, mudar fases|
| Coorientador    | `co_sup`    | Tudo exceto mudar fases                             |
| Júri            | `jury`      | Apenas leitura + avaliação final                   |
| Coordenador     | `coord`     | Apenas leitura do progresso                        |
| Admin           | `admin`     | Acesso total                                        |

---

## Funcionalidades do Workspace (v0.9 Atual)

### Chat
- Mensagens persistidas em base de dados.
- Polling automático a cada 3 segundos para atualizações.
- Balões diferenciados por papel (estudante / docente / IA).
- Visualização de ficheiros em linha (imagens, vídeos, PDFs, código).
- Upload de ficheiros com pré-visualização em modal flutuante.

### Kanban
- 4 colunas: `A Fazer`, `Em Progresso`, `Em Revisão`, `Concluído`.
- Criação manual de tarefas pelo grupo.
- Sugestão automática de tarefas pela IA (identificadas com ✨).
- Edição e eliminação de tarefas.
- Atribuição a membros.

### Assistente IA
- Resposta automática a dúvidas dos estudantes (modo Piloto Automático).
- Sugestão privada de resposta para o Docente.
- Análise do sentimento e clima do chat.
- Resumo de progresso.
- Sugestão de 3 tarefas Kanban baseadas no contexto do projeto.

### Fases Académicas
1. Sensibilização
2. Campo
3. MVP
4. Exposição
5. Artigo

---

## Evolução Planeada (v1.0)

- Tabela `workspace_members` com pivot de papéis flexíveis.
- Timeline visual de fases.
- Notificações quando uma fase é atualizada.
- Histórico imutável de mensagens (nunca apagar).
