# 09 — Knowledge Hub
> **AcademicHub** | Banco de Conhecimento e Ideias Institucional

---

## Conceito

O **Knowledge Hub** é o repositório de conhecimento vivo da Universidade Licungo.

> Uma ideia não nasce num projeto. Nasce primeiro como um insight.
> Esse insight deve ser preservado, classificado e potencialmente transformado em projeto.

---

## Princípio

As ideias são **património institucional**, não propriedade de um grupo.

Uma ideia pode originar:
- 1 projeto académico
- Vários projetos em diferentes anos
- Um hackathon
- Um artigo de investigação

---

## Funcionalidades Planeadas (v1.0)

### Banco de Ideias Público
- Qualquer estudante pode submeter uma ideia (com ou sem candidatura formal).
- Ideias classificadas por: `categoria`, `curso`, `ano`, `status`.
- Status possíveis: `ideia`, `proposta`, `projeto_ativo`, `concluído`, `arquivado`.

### Curadoria Institucional
- Docentes e Coordenadores podem validar, sugerir melhorias ou rejeitar ideias.
- Ideias validadas ficam disponíveis no catálogo público como sugestões.

### AI Advisor Contextual
- O AI Advisor do Portal usa o Knowledge Hub para sugerir ideias já validadas como inspiração.
- Evita duplicação de projetos semelhantes.

### Histórico Completo
- Nunca apagar ideias — marcar como `arquivadas`.
- Registo de quem submeteu, quem validou e qual projeto originou.

---

## Modelo de Dados (Planeado)

```
ideas
├── id
├── title
├── description
├── category
├── tecnologies (JSON)
├── submitted_by (user_id)
├── validated_by (user_id)
├── status (ideia | proposta | projeto_ativo | concluido | arquivado)
├── workspace_id (nullable — se originou um projeto)
└── timestamps
```

---

## Estado Atual

> 🔲 **Ainda não implementado.** Planeado para v1.0 (`evol1.0`).
>
> Atualmente, as ideias existem apenas como projetos estáticos em `resources/data/projects.json`.
