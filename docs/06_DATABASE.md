# 06 — Database
> **AcademicHub** | Esquema e Arquitetura da Base de Dados

---

## Visão Geral

Base de dados relacional **MySQL/MariaDB** gerida via **Eloquent ORM** do Laravel com migrações versionadas.

---

## Tabelas Principais (Estado Atual — v0.9)

### `users`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|------------------------------------|
| id               | bigint PK    | Identificador único                |
| name             | varchar      | Nome completo                      |
| email            | varchar      | Email (único)                      |
| phone            | varchar      | Número de telefone                 |
| pin              | varchar      | PIN hasheado (bcrypt)              |
| role             | enum         | `admin`, `docente`, `estudante`    |
| email_verified_at| timestamp    | Verificação do email               |
| created_at       | timestamp    | Data de criação                    |

---

### `candidaturas`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|--------------------------------------|
| id               | bigint PK    | Identificador único                  |
| project_number   | integer      | Número do projeto (>= 1000 = ideia própria) |
| project_name     | varchar      | Nome do projeto                      |
| technology       | varchar      | Tecnologia principal selecionada     |
| mentor           | varchar?     | Mentor sugerido (opcional)           |
| docente_id       | bigint FK?   | Docente responsável (atribuído pelo admin) |
| member1_name     | varchar      | Nome do líder / estudante 1          |
| member1_code     | varchar      | Código de estudante do líder         |
| contact_email    | varchar      | Email de contacto (para PIN)         |
| contact_phone    | varchar?     | Telemóvel de contacto                |
| member2_name     | varchar?     | Nome do 2.º membro (obrig. em grupo)|
| member2_code     | varchar?     | Código do 2.º membro                |
| member3_name     | varchar?     | Nome do 3.º membro (opcional)        |
| member3_code     | varchar?     | Código do 3.º membro                |
| member4_name     | varchar?     | Nome do 4.º membro (opcional)        |
| member4_code     | varchar?     | Código do 4.º membro                |
| rationale        | text?        | Justificativa / motivação            |
| status           | varchar      | `Pendente`, `Aprovado`, `Rejeitado`  |
| group_password   | varchar      | PIN hasheado (bcrypt)                |
| ai_assistant_active | boolean   | IA ativa no workspace                |
| created_at       | timestamp    |                                      |

---

### Tabelas Associadas (via `candidatura_id` FK com `onDelete cascade`)

> **Nota:** Não existe tabela separada `workspaces` ou `grupos` no esquema atual.
> A tabela `candidaturas` funciona como entidade central que agrega chat, kanban e ficheiros.

#### `workspace_messages`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|--------------------------------------|
| id               | bigint PK    |                                      |
| candidatura_id   | bigint FK    | Referência à candidatura             |
| sender_type      | enum         | `student`, `mentor`                  |
| message          | text         | Conteúdo da mensagem                 |
| created_at       | timestamp    |                                      |

#### `kanban_tasks`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|--------------------------------------|
| id               | bigint PK    |                                      |
| candidatura_id   | bigint FK    | Referência à candidatura             |
| title            | varchar      | Título da tarefa                     |
| description      | text?        | Descrição                            |
| status           | enum         | `todo`, `in_progress`, `review`, `done` |
| created_by       | enum         | `student`, `mentor`                  |
| created_at       | timestamp    |                                      |

#### `candidatura_ficheiros`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|--------------------------------------|
| id               | bigint PK    |                                      |
| candidatura_id   | bigint FK    | Referência à candidatura             |
| nome_ficheiro    | varchar      | Nome do ficheiro                     |
| caminho          | varchar      | Caminho no storage                   |
| tamanho_bytes    | integer?     | Tamanho do ficheiro                  |
| uploaded_by      | varchar?     | Quem fez upload                      |
| created_at       | timestamp    |                                      |

#### `candidatura_progressos`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|--------------------------------------|
| id               | bigint PK    |                                      |
| candidatura_id   | bigint FK    | Referência à candidatura             |
| fase             | enum         | `sensibilizacao`, `campo`, `mvp`, `exposicao`, `artigo` |
| estado           | enum         | `pendente`, `em_progresso`, `concluida` |
| observacao       | text?        | Notas do docente                     |
| updated_by       | varchar?     | Quem atualizou                       |
| created_at       | timestamp    |                                      |

---

## Evolução Planeada (v1.0)

- Criar tabela `workspaces` para substituir a relação direta com `candidaturas`
- Criar tabela `workspace_members` (pivot com papel: `estudante`, `supervisor`, `coorientador`, `juri`)
- Criar tabela `ideas` para o Knowledge Hub
- Criar tabela `project_phases` para o funil de progresso académico

---

## Convenções

- Todas as tabelas no plural e em `snake_case`.
- Usar `softDeletes` onde seja necessário preservar histórico.
- Nunca apagar dados académicos — marcar como arquivados.
