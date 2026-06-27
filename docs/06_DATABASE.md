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
|------------------|--------------|------------------------------------|
| id               | bigint PK    | Identificador único                |
| project_id       | bigint FK    | Referência ao projeto candidatado  |
| lider_nome       | varchar      | Nome do líder do grupo             |
| lider_email      | varchar      | Email do líder                     |
| lider_phone      | varchar      | Telemóvel do líder                 |
| membro2_nome     | varchar      | Nome do 2º membro (opcional)       |
| membro3_nome     | varchar      | Nome do 3º membro (opcional)       |
| membro4_nome     | varchar      | Nome do 4º membro (opcional)       |
| status           | enum         | `pendente`, `aprovado`, `rejeitado`|
| created_at       | timestamp    |                                    |

---

### `workspaces` (Atual: `grupos`)
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|------------------------------------|
| id               | bigint PK    |                                    |
| candidatura_id   | bigint FK    | Candidatura associada              |
| docente_id       | bigint FK    | Docente responsável                |
| nome             | varchar      | Nome do grupo/projeto              |
| descricao        | text         | Descrição do projeto               |
| ai_enabled       | boolean      | IA ativa ou não                    |
| created_at       | timestamp    |                                    |

---

### `messages`
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|------------------------------------|
| id               | bigint PK    |                                    |
| workspace_id     | bigint FK    |                                    |
| user_id          | bigint FK    | Quem enviou                        |
| content          | text         | Conteúdo da mensagem               |
| is_ai            | boolean      | Mensagem gerada pela IA            |
| created_at       | timestamp    |                                    |

---

### `tasks` (Kanban)
| Coluna           | Tipo         | Descrição                          |
|------------------|--------------|------------------------------------|
| id               | bigint PK    |                                    |
| workspace_id     | bigint FK    |                                    |
| title            | varchar      | Título da tarefa                   |
| description      | text         | Descrição                          |
| status           | enum         | `todo`, `in_progress`, `done`      |
| assigned_to      | bigint FK    | Membro responsável                 |
| created_by_ai    | boolean      | Gerada pela IA                     |
| created_at       | timestamp    |                                    |

---

## Evolução Planeada (v1.0)

- Renomear `grupos` → `workspaces`
- Criar tabela `workspace_members` (pivot com papel: `estudante`, `supervisor`, `coorientador`, `juri`)
- Criar tabela `ideas` para o Knowledge Hub
- Criar tabela `project_phases` para o funil de progresso académico

---

## Convenções

- Todas as tabelas no plural e em `snake_case`.
- Usar `softDeletes` onde seja necessário preservar histórico.
- Nunca apagar dados académicos — marcar como arquivados.
