# UniLicungo TechHub

O **UniLicungo TechHub** é o ecossistema digital académico da Universidade Licungo projetado para potenciar a colaboração, gestão ágil e mentoria tecnológica dos estudantes e grupos de investigação.

## 🚀 Visão Geral
Construído sobre a arquitetura robusta do **Laravel**, e dotado de uma interface reativa moderna *(Glassmorphism & Bento Grid)* orientada a componentes Tailwind CSS, o TechHub serve como o epicentro digital para acompanhamento de projetos universitários.

Esta plataforma transita da habitual entrega e correção estática de documentos para um **"Workspace Dinâmico"**, onde equipas e docentes iteram, dialogam e programam lado a lado.

## ✨ Funcionalidades Principais
1. **Gestão Ágil Integrada (Kanban):** Painel interativo com sincronização imediata, permitindo criar, editar e mover tarefas entre estados (A Fazer, Em Progresso, Em Revisão, Concluído).
2. **Chat de Mentoria Síncrona:** Sala de chat dedicada a cada projeto, com partilha bidirecional para *feedback* instantâneo.
3. **Assistente IA Contextual (RAG):**
   - **Piloto Automático Académico:** Ativação opcional por parte do docente. O LLM (OpenRouter/GPT-4o) assume o papel de Assistente Universitário 24/7 quando o mentor está ausente, fornecendo orientação e referências técnicas baseadas na tecnologia específica do grupo.
   - **Geração de Tarefas:** Análise instantânea da documentação/conceito do projeto para sugerir e injetar automaticamente tarefas estruturadas de engenharia de software no Kanban do aluno.
   - **Resumo e Clima:** Sumarização instantânea do progresso semântico e do sentimento da equipa.
4. **Portefólio e Exposições:** Montra pública (Portal) para exibir a criatividade e resultados tecnológicos da academia.

## ⚙️ Arquitetura e Stack
- **Framework Base:** Laravel (PHP)
- **Design System:** Tailwind CSS (Utilitários avançados, micro-interações, Glassmorphism).
- **Client-Side:** JavaScript Vanilla focado na `Fetch API` para reatividade *Single-Page* (SPA-feel) em módulos como o Kanban e o Chat.
- **Integração de IA:** OpenRouter REST API acoplada a um Controller específico de IA no back-end para *Prompting* contextualizado em RAG (Retrieval-Augmented Generation).
- **Deploy:** Integração de pipeline local em bash (`deploy.sh`) suportado por instâncias em Cloud.

---

### Desenvolvimento
Para compreender toda a trajetória e as metodologias de evolução até ao paradigma de Inteligência Artificial implementado nesta versão, consulte o documento científico anexo: `HISTORICO_DEV.md`.

*Universidade Licungo — Inovação, Tecnologia e Desenvolvimento.*
