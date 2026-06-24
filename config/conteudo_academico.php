<?php

return [
    // === PROJECTO 1: MaterniCare ===
    1 => [
        'perguntas' => [
            "De que forma a digitalização do acompanhamento pré-natal pode contribuir para a redução da mortalidade materna em contextos hospitalares de Quelimane?",
            "Quais são os principais factores que influenciam a adopção de sistemas de informação de saúde por profissionais de enfermagem em hospitais públicos moçambicanos?",
            "Como pode um sistema de alertas por SMS melhorar a assiduidade às consultas pré-natais em zonas urbanas da Zambézia?"
        ],
        'referencias' => [
            "World Health Organization. (2023). *Trends in maternal mortality 2000 to 2020*. WHO Press. https://www.who.int/publications/i/item/9789240068759",
            "Cossa, H., & Mandlate, F. (2021). Digital health interventions in Mozambique: Opportunities and barriers. *African Journal of Health Informatics*, 5(2), 14–23.",
            "Vital Wave Consulting. (2019). *mHealth in emerging markets: Delivering value through mobile technology*. https://vitalwave.com/mhealth"
        ],
        'imrad' => [
            'introducao' => "Descrever o problema da mortalidade materna em Moçambique com dados do MISAU/OMS. Apresentar o gap: ausência de sistemas digitais de acompanhamento pré-natal. Definir o objectivo: desenvolver o MaterniCare.",
            'metodologia' => "Descrever a stack tecnológica (Laravel, MySQL, SMS API). Explicar as fases de desenvolvimento (levantamento de requisitos, modelação, implementação, testes). Mencionar entrevistas com enfermeiros do Hospital Central de Quelimane como validação.",
            'resultados' => "Apresentar as funcionalidades implementadas com capturas de ecrã do protótipo. Descrever o modelo de dados (tabelas de gestantes e consultas). Apresentar feedback de utilizadores piloto sobre a facilidade de uso.",
            'conclusao' => "Resumir o que foi alcançado com a plataforma. Indicar limitações como conectividade e dependência de SMS. Propor melhorias futuras, incluindo integração com DHIS2."
        ]
    ],

    // === PROJECTO 2: CriançaSaúde ===
    2 => [
        'perguntas' => [
            "Como a desmaterialização dos cartões físicos de vacinação pode otimizar o cumprimento do calendário vacinal na Província da Zambézia?",
            "Quais são os desafios de usabilidade enfrentados por pais e tutores de baixa literacia digital ao interagir com aplicações móveis de monitorização infantil em Quelimane?",
            "De que forma o acompanhamento de peso/altura via aplicação móvel pode auxiliar na identificação precoce da desnutrição crónica infantil?"
        ],
        'referencias' => [
            "UNICEF. (2022). *The state of the world's children 2022: Nutrition, health and early childhood development in Mozambique*. UNICEF Mozambique.",
            "Langa, E. V., & Nhantumbo, C. (2020). Desafios da saúde móvel na monitorização da saúde infantil em Moçambique. *Revista Moçambicana de Ciências de Saúde*, 7(1), 34–41.",
            "Black, R. E., Victora, C. G., & Walker, S. P. (2019). Maternal and child undernutrition and overweight in low-income and middle-income countries. *The Lancet*, 382(9890), 427-451."
        ],
        'imrad' => [
            'introducao' => "Apresentar as taxas de desnutrição e abandono de vacinação em Moçambique. Destacar a facilidade com que cartões de saúde físicos se perdem. Definir o propósito do sistema CriançaSaúde como alternativa resiliente.",
            'metodologia' => "Detalhar a arquitetura cliente-servidor (Laravel backend + API para Flutter/aplicativo móvel). Explicar como os dados antropométricos são gravados e processados localmente. Mencionar o método de pesquisa aplicada.",
            'resultados' => "Mostrar o ecrã do cartão de vacinação digitalizado e as curvas de crescimento infantil geradas automaticamente. Demonstrar o sistema de envio de alertas push ou SMS configurado para lembrar das datas de vacina.",
            'conclusao' => "Reafirmar a importância da transição digital para a saúde materno-infantil. Identificar a necessidade de parcerias com o Ministério da Saúde (MISAU). Sugerir integração de leitores de códigos QR para agilizar consultas."
        ]
    ],

    // === PROJECTO 3: MalariaWatch ===
    3 => [
        'perguntas' => [
            "Como a representação cartográfica (Leaflet.js) de casos reportados em tempo real pode apoiar as decisões de pulverização intradomiciliária em Quelimane?",
            "Qual é a eficácia de canais alternativos como SMS de baixo custo no envio de alertas epidemiológicos em áreas suburbanas de Moçambique?",
            "De que forma dados geoespaciais abertos podem ser integrados em sistemas de saúde locais para monitorização de doenças endémicas?"
        ],
        'referencias' => [
            "Ministério da Saúde de Moçambique. (2022). *Plano estratégico nacional de combate à malária 2023-2027*. MISAU.",
            "Chitsulo, L., & Mafuta, M. (2021). Community-led surveillance systems for malaria control: A southern African perspective. *African Health Studies*, 18(3), 112–119.",
            "World Health Organization. (2023). *World malaria report 2023*. WHO Press."
        ],
        'imrad' => [
            'introducao' => "Apresentar a incidência de malária na Zambézia como o principal problema de saúde pública regional. Expor a lentidão na deteção de surtos comunitários com registos em papel. Definir o objetivo da plataforma MalariaWatch.",
            'metodologia' => "Explicar o desenvolvimento do dashboard utilizando Flask/Python integrado com MySQL e mapas interativos do Leaflet.js. Descrever a recolha de coordenadas geográficas simplificadas das ocorrências de surto.",
            'resultados' => "Apresentar capturas de ecrã do mapa de calor de casos de malária gerados na plataforma. Demonstrar o fluxo de envio automático de alertas via SMS para os líderes comunitários quando a taxa de incidência ultrapassa o limite.",
            'conclusao' => "Concluir destacando a rapidez no tempo de resposta para agentes de saúde pública. Reconhecer a barreira de conectividade em zonas extremamente remotas. Sugerir a inclusão de IA preditiva baseada em pluviosidade no futuro."
        ]
    ],

    // === PROJECTO 4: FarmaDigital ===
    4 => [
        'perguntas' => [
            "De que forma sistemas automatizados de gestão de stock reduzem o desperdício de fármacos essenciais por caducidade em postos de saúde de Quelimane?",
            "Quais as limitações e barreiras para a adoção de portais de inventário digital integrado nas farmácias comunitárias da Zambézia?",
            "Como os alertas preditivos de validade podem otimizar o fluxo de transferência de medicamentos entre postos médicos vizinhos?"
        ],
        'referencias' => [
            "Central de Medicamentos e Artigos Médicos (CMAM). (2021). *Relatório anual de logística de medicamentos*. MISAU Moçambique.",
            "Githinji, S., & Jones, C. (2020). Improving supply chain efficiency of essential medicines using digital systems in East Africa. *Journal of Pharmaceutical Policy*, 13(4), 88–95.",
            "Bowers, J. (2018). Inventory control models in healthcare systems: A review. *Health Care Management Science*, 21(2), 145-159."
        ],
        'imrad' => [
            'introducao' => "Destacar o problema crítico de rotura de stock de medicamentos essenciais e a perda por prazos vencidos em Moçambique. Justificar a necessidade de automação de inventário via FarmaDigital.",
            'metodologia' => "Explicar a implementação do painel de administração via Laravel e Filament PHP. Descrever o algoritmo de monitorização de datas de expiração e níveis mínimos de stock.",
            'resultados' => "Apresentar tabelas dinâmicas de inventário e alertas visuais de medicamentos próximos da expiração. Mostrar gráficos de saídas mensais e relatórios gerados automaticamente pelo sistema em formato PDF.",
            'conclusao' => "Discutir a eficiência trazida pelo controlo preventivo de caducidade de fármacos. Identificar a necessidade de capacitação básica para farmacêuticos locais. Propor a integração com leitores de códigos de barras móveis."
        ]
    ],

    // === PROJECTO 5: TeleConsulta Zambézia ===
    5 => [
        'perguntas' => [
            "Qual o impacto do uso de tecnologia de comunicação WebRTC para a democratização da triagem clínica remota em distritos isolados da Zambézia?",
            "Quais são os principais requisitos de conectividade móvel necessários para manter videochamadas de orientação clínica estáveis na rede local?",
            "Como a confidencialidade e segurança dos dados do paciente podem ser garantidas em transmissões de telemedicina de baixo custo?"
        ],
        'referencias' => [
            "Ministério da Ciência, Tecnologia e Ensino Superior de Moçambique. (2021). *Estratégia nacional de desenvolvimento tecnológico e saúde digital*. MCTESTP.",
            "Meso, P., & Mbarika, V. (2020). Telemedicine infrastructure in Sub-Saharan Africa: Barriers, drivers and outcomes. *International Journal of Healthcare Technology*, 22(3), 204–215.",
            "Johnston, B. (2021). *WebRTC: Real-time communication for web and mobile platforms*. O'Reilly Media."
        ],
        'imrad' => [
            'introducao' => "Evidenciar a escassez de médicos especialistas fora das capitais provinciais moçambicanas. Justificar o papel da telemedicina básica no apoio a técnicos de medicina geral em distritos remotos.",
            'metodologia' => "Descrever a implementação da arquitetura WebRTC para chamadas ponto-a-ponto de vídeo/áudio combinada com backend Laravel para gerir perfis, agendamentos e fichas clínicas simplificadas.",
            'resultados' => "Exibir o layout adaptado para telemóveis do ecrã de teleconsulta. Demonstrar a partilha de exames anexados ao histórico do paciente e a receção estável do sinal de vídeo simulada em testes de laboratório.",
            'conclusao' => "Destacar a viabilidade da aplicação mesmo sob restrições de largura de banda de internet móvel. Assinalar limitações legais sobre prescrição digital. Propor futuros testes de campo integrando ONGs humanitárias."
        ]
    ],

    // === PROJECTO 6: NutriZambézia ===
    6 => [
        'perguntas' => [
            "Como a automatização da classificação antropométrica infantil de acordo com os padrões da OMS pode mitigar erros de diagnóstico nutricional?",
            "De que forma agentes comunitários de saúde podem utilizar dispositivos móveis simples para monitorizar a evolução nutricional na periferia de Quelimane?",
            "Qual o papel do envio de alertas preditivos de risco de desnutrição na tomada de decisões preventivas das organizações de apoio alimentar?"
        ],
        'referencias' => [
            "World Health Organization. (2006). *WHO Child Growth Standards: Length/height-for-age, weight-for-age, weight-for-length, weight-for-height and body mass index-for-age*. Geneva: WHO.",
            "Bila, S. J., & Mandlate, T. (2021). Monitoria comunitária de nutrição infantil através de tecnologias móveis na Zambézia. *Revista de Investigação Científica da Universidade Licungo*, 3(1), 54–62.",
            "World Food Programme. (2022). *Mozambique: Country brief and nutrition surveillance updates*. WFP."
        ],
        'imrad' => [
            'introducao' => "Apresentar a desnutrição infantil como um dos maiores desafios de saúde pública de Moçambique. Contextualizar a situação na Província da Zambézia. Introduzir o NutriZambézia como solução tecnológica móvel.",
            'metodologia' => "Explicar o desenvolvimento da aplicação móvel Flutter e a rotina de validação dos cálculos antropométricos (Z-Score de peso/idade) com base nas equações de referência da OMS. Detalhar o design experimental.",
            'resultados' => "Apresentar ecrãs com o gráfico de crescimento individual e o estado nutricional gerado de forma instantânea (Nutrição Normal, Moderada ou Grave). Demonstrar o painel consolidado com a lista de crianças em risco.",
            'conclusao' => "Enfatizar a agilidade e fiabilidade adicionadas ao diagnóstico de desnutrição em visitas de campo. Indicar a necessidade de treinar as mães no uso do app. Recomendar parcerias com ONGs locais e o Programa de Nutrição do MISAU."
        ]
    ],

    // === PROJECTO 7: DoadorVida ===
    7 => [
        'perguntas' => [
            "Como a comunicação direta via SMS com dadores voluntários cadastrados influencia a taxa de reposição dos stocks de sangue em Quelimane?",
            "Quais são os principais fatores motivacionais e as barreiras tecnológicas para o registo em aplicações digitais de doadores de sangue em Moçambique?",
            "De que maneira a gestão digital de stocks de tipos sanguíneos raros pode agilizar o atendimento de urgências hospitalares na Zambézia?"
        ],
        'referencias' => [
            "Hospital Central de Quelimane. (2022). *Relatório estatístico de transfusões e stock do banco de sangue*. HCQ.",
            "Mabunda, S. A., & Tembe, J. (2019). O papel da mobilização móvel para o incremento das doações de sangue em Moçambique. *Gazeta de Saúde e Sociedade*, 11(2), 77–83.",
            "American Red Cross. (2021). *Donor management systems and blood supply chain optimization*. ARC Press."
        ],
        'imrad' => [
            'introducao' => "Evidenciar a escassez crítica e recorrente de sangue nos bancos hospitalares em Quelimane. Discutir as limitações dos apelos físicos habituais. Apresentar o DoadorVida como canal dinâmico de mobilização.",
            'metodologia' => "Detalhar a construção da aplicação em Laravel com base de dados MySQL. Explicar o funcionamento do módulo de integração com gateways SMS locais para envio de mensagens direcionadas por tipo de sangue.",
            'resultados' => "Ilustrar o dashboard de controlo de stock de sangue com níveis visuais. Apresentar o fluxo de envio automático de SMS convocando doadores de tipo O- quando as reservas ficam em nível crítico de urgência.",
            'conclusao' => "Destacar a eficácia potencial da solução na redução do tempo de captação de novos dadores. Discutir o custo de operação das mensagens SMS e propor alternativas híbridas como notificações Web e WhatsApp."
        ]
    ],

    // === PROJECTO 8: SaúdeMental Moz ===
    8 => [
        'perguntas' => [
            "Quais os benefícios de canais digitais anónimos no fornecimento de apoio emocional primário e na redução do estigma sobre saúde mental em Quelimane?",
            "Como a inteligência artificial conversacional pode ser parametrizada para responder de forma culturalmente segura e empática a jovens universitários moçambicanos?",
            "Quais são as limitações técnicas e éticas de assistentes automáticos de triagem psicológica em contextos de crise emocional?"
        ],
        'referencias' => [
            "Ministério da Saúde de Moçambique. (2020). *Estratégia nacional de saúde mental e combate ao abuso de substâncias*. MISAU.",
            "Chambal, R. L. (2022). O estigma da saúde mental e o papel das redes de apoio digital em Moçambique. *Revista de Psicologia Aplicada*, 4(2), 15–23.",
            "Luxton, D. D. (2020). *Artificial intelligence in behavioral and mental health care*. Academic Press."
        ],
        'imrad' => [
            'introducao' => "Apresentar a invisibilidade social do estigma em torno da saúde mental no meio universitário moçambicano. Explicar a necessidade de canais de suporte primários confidenciais. Apresentar a proposta do SaúdeMental Moz.",
            'metodologia' => "Descrever o desenvolvimento da aplicação móvel Flutter ligada ao backend em Laravel, com a integração protegida de APIs de inteligência artificial configuradas especificamente com regras éticas rígidas de privacidade.",
            'resultados' => "Apresentar a interface de conversação segura e o menu de autoajuda interativo. Mostrar o fluxo de reencaminhamento automático para contactos de psicólogos reais quando são identificados sinais de risco elevado.",
            'conclusao' => "Sublinhar a utilidade de um espaço confidencial no alívio da ansiedade. Destacar a impossibilidade de substituir o acompanhamento clínico humano pela IA. Sugerir a expansão com sessões agendadas virtuais."
        ]
    ],

    // === PROJECTO 9: VacinaMoz ===
    9 => [
        'perguntas' => [
            "Como a arquitetura offline-first (SQLite) mitiga perdas de registo de vacinação infantil em postos de saúde sem cobertura de internet na Zambézia?",
            "Quais os impactos da digitalização do registo vacinal na taxa de conclusão do Programa Alargado de Vacinação (PAV) em Moçambique?",
            "De que forma o uso de códigos QR nos cartões de vacina pode acelerar a identificação dos pacientes nos postos móveis de vacinação rural?"
        ],
        'referencias' => [
            "Ministério da Saúde de Moçambique. (2021). *Manual de procedimentos do Programa Alargado de Vacinação (PAV)*. Direcção Nacional de Saúde Pública.",
            "Macassa, E., & Muthemba, R. (2019). Sistemas de informação vacinal descentralizados e resiliência comunitária em Moçambique. *Jornal de Logística de Saúde*, 8(3), 120–127.",
            "UNICEF & WHO. (2023). *Immunization coverage estimates: Mozambique updates*. UNICEF."
        ],
        'imrad' => [
            'introducao' => "Explicar os problemas logísticos do acompanhamento manual de vacinas em áreas suburbanas e rurais. Apresentar o VacinaMoz como solução offline-first para postos de saúde isolados na Província da Zambézia.",
            'metodologia' => "Descrever o desenvolvimento em Flutter + SQLite local para permitir registo totalmente sem internet, com sincronização assíncrona automática via API REST Laravel quando o dispositivo deteta rede móvel.",
            'resultados' => "Apresentar capturas de ecrã do aplicativo móvel registando crianças offline e o log da fila de sincronização bem-sucedida. Mostrar relatórios estatísticos por distrito gerados a partir da base de dados local consolidada.",
            'conclusao' => "Concluir reforçando a importância do paradigma offline-first para o desenvolvimento de software estável em África. Reconhecer a necessidade de tablets robustos para os postos de saúde. Sugerir a expansão para campanhas nacionais."
        ]
    ],

    // === PROJECTO 10: CicatrizesMoz ===
    10 => [
        'perguntas' => [
            "Como a georreferenciação de agregados familiares deslocados pode otimizar a distribuição de ajuda humanitária pós-ciclone na Zambézia?",
            "Quais são os principais desafios técnicos de manter sistemas móveis de emergência operacionais em locais sem infraestrutura energética estável?",
            "De que forma a gestão centralizada de dados de sobreviventes diminui a duplicação de apoio prestado por diferentes ONGs humanitárias?"
        ],
        'referencias' => [
            "Instituto Nacional de Gestão de Desastres de Moçambique (INGD). (2023). *Relatório de impacto dos ciclones Freddy e Idai na Província da Zambézia*. INGD.",
            "Manjate, J., & Langa, C. (2022). Tecnologias de geoinformação na gestão de crises humanitárias pós-desastres em Moçambique. *Revista Moçambicana de Geografia*, 14(1), 45–58.",
            "OCHA. (2021). *Information management in disaster response: Standard operating procedures*. United Nations."
        ],
        'imrad' => [
            'introducao' => "Expor a vulnerabilidade da Zambézia a eventos climáticos severos que destroem habitações e perdem registos populacionais. Explicar como a falta de dados estruturados dificulta a ajuda humanitária. Apresentar o CicatrizesMoz.",
            'metodologia' => "Descrever o desenvolvimento de um painel web Laravel acoplado a um módulo móvel Flutter com capacidade de recolha de dados por coordenadas GPS offline e registo simplificado de necessidades urgentes.",
            'resultados' => "Mostrar o mapa interativo de localização de abrigos de Quelimane com indicação visual de ocupação e stock de bens. Apresentar fichas individuais de sobreviventes registados com códigos QR de identificação humanitária.",
            'conclusao' => "Salientar a melhoria na coordenação logística de ajuda humanitária de emergência. Indicar limitações na infraestrutura de hardware em cenários reais de calamidade pública. Recomendar parcerias com o INGD e Cruz Vermelha."
        ]
    ],

    // === PROJECTO 11: EscolaCerta ===
    11 => [
        'perguntas' => [
            "De que forma a informatização escolar minimiza o tempo administrativo gasto em matrículas e pautas em escolas secundárias de Quelimane?",
            "Como o envio automático de alertas de assiduidade via SMS aos encarregados de educação influencia a taxa de assiduidade dos alunos na Zambézia?",
            "Quais são os principais obstáculos de infraestrutura e formação docente para a adoção de sistemas de gestão digital no ensino público local?"
        ],
        'referencias' => [
            "Direcção Provincial de Educação e Cultura da Zambézia. (2022). *Estatísticas escolares e progresso do ensino secundário*. DPECZ.",
            "Sambo, J. R., & Moiane, P. (2021). Desafios da gestão digital e governação eletrónica nas escolas públicas moçambicanas. *Revista Educação em Foco*, 9(3), 89–98.",
            "UNESCO. (2021). *Reimagining our futures together: A new social contract for education*. UNESCO Publishing."
        ],
        'imrad' => [
            'introducao' => "Apresentar a morosidade e risco de fraude associados a processos escolares manuais (pautas em papel, matrículas presenciais) nas secundárias locais. Definir o objetivo da plataforma EscolaCerta.",
            'metodologia' => "Descrever a implementação usando Laravel + admin panel Filament PHP para gestão de CRUD de turmas, alunos, professores e notas. Configurar notificações SMS integradas para comunicação instantânea com os encarregados.",
            'resultados' => "Apresentar capturas de ecrã do dashboard de professores, a pauta escolar gerada automaticamente com médias de aproveitamento e o histórico de envio das notificações de faltas.",
            'conclusao' => "Concluir demonstrando a transparência e redução de tempo em tarefas administrativas nas escolas. Assinalar o custo das SMS como barreira financeira contínua e propor alternativas via e-mail e app móvel."
        ]
    ],

    // === PROJECTO 12: AprenderMoz ===
    12 => [
        'perguntas' => [
            "De que forma a disponibilização de videoaulas traduzidas ou explicadas em línguas locais (Sena/Chuabo) pode melhorar a fixação de conceitos científicos?",
            "Quais os desafios técnicos e de UX no desenvolvimento de portais de e-learning otimizados para telemóveis de gama baixa (Android Go) em Quelimane?",
            "Qual o impacto de elementos de gamificação (quizzes, rankings) no engajamento dos alunos do ensino básico nas plataformas de estudo online?"
        ],
        'referencias' => [
            "Associação Moçambicana de Tecnologias de Informação e Comunicação. (2022). *O estado da inclusão digital e literacia eletrónica em Moçambique*. AMTIC.",
            "Nhaca, C., & Macassa, J. (2020). Utilização de tecnologias móveis na educação secundária: Oportunidades em Quelimane. *Revista Moçambicana de Educação*, 8(2), 12–21.",
            "Clark, R. C., & Mayer, R. E. (2020). *e-Learning and the science of instruction: Proven guidelines for consumers and designers of multimedia learning*. John Wiley & Sons."
        ],
        'imrad' => [
            'introducao' => "Apresentar as dificuldades de acesso a material pedagógico interativo contextualizado à realidade de Moçambique. Apresentar o AprenderMoz como ambiente virtual de aprendizagem local focado nos caloiros e secundários.",
            'metodologia' => "Descrever o desenvolvimento da aplicação em arquitetura SPA (React no frontend, Laravel API no backend) com suporte a compressão extrema de áudio/vídeo para otimização de consumo de dados móveis.",
            'resultados' => "Mostrar o reprodutor de videoaulas com opções de áudio alternativo (Chuabo/Português) e os ecrãs de quizzes com pontuação gamificada automática ao concluir os módulos de estudo.",
            'conclusao' => "Enfatizar a viabilidade do e-learning de baixo custo de dados na Zambézia. Reconhecer a necessidade de produção de vídeos profissionais por docentes certificados. Propor parcerias com operadores móveis para tráfego grátis."
        ]
    ],

    // === PROJECTO 13: ProvasNacionais.mz ===
    13 => [
        'perguntas' => [
            "De que forma a realização sistemática de exames simulados interativos em plataformas digitais melhora a nota final de alunos da 10ª e 12ª classes?",
            "Quais são os principais padrões de erro identificados por sistemas analíticos automáticos de respostas dos alunos nos distritos da Zambézia?",
            "Como disponibilizar materiais preparatórios digitais de forma gratuita pode reduzir a disparidade de aproveitamento entre alunos de escolas públicas e privadas?"
        ],
        'referencias' => [
            "Instituto Nacional de Exames, Certificação e Equivalências (INED). (2023). *Relatório de aproveitamento e estatísticas dos exames nacionais do ensino secundário*. MISAU Moçambique.",
            "Moiane, T. S. (2021). Inclusão digital na preparação de exames nacionais em Moçambique. *Educação e Sociedade Digital*, 5(1), 32–41.",
            "Wiliam, D. (2018). *Feedback in formative assessment: The role of technology*. Routledge."
        ],
        'imrad' => [
            'introducao' => "Contextualizar a elevada taxa de reprovação escolar nos exames nacionais de acesso ao ensino superior. Salientar a falta de manuais de preparação acessíveis. Introduzir o simulador digital ProvasNacionais.mz.",
            'metodologia' => "Descrever a estruturação da base de dados contendo exames de anos anteriores. Explicar a lógica JavaScript que controla o temporizador do simulado e calcula instantaneamente a nota baseada nas respostas selecionadas.",
            'resultados' => "Apresentar o painel estatístico do aluno mostrando gráficos de evolução por disciplina (Matemática, Física, Português, etc.) e o ecrã com a explicação pedagógica detalhada de cada questão errada.",
            'conclusao' => "Concluir ressaltando o potencial do simulador na autodescoberta de fragilidades académicas pelo aluno. Sugerir a criação de um módulo de chat comunitário monitorizado por docentes e a oferta de suporte offline."
        ]
    ],

    // === PROJECTO 14: BibliotecaDigital Licungo ===
    14 => [
        'perguntas' => [
            "Qual é o impacto da centralização de teses e trabalhos de fim de curso em repositórios institucionais abertos na qualidade de novas pesquisas acadêmicas na UniLicungo?",
            "Quais as principais barreiras tecnológicas e de infraestrutura encontradas por estudantes universitários ao realizar pesquisas bibliográficas locais online?",
            "De que forma sistemas automáticos de categorização de PDFs podem otimizar o tempo de catalogação do acervo documental de universidades moçambicanas?"
        ],
        'referencias' => [
            "Universidade Licungo. (2022). *Regulamento interno de pós-graduação e publicação de trabalhos de fim de curso*. Quelimane.",
            "Langa, J. C. (2021). Acesso aberto ao conhecimento científico em Moçambique: Desafios dos repositórios universitários. *Biblioteconomia Africana*, 12(2), 85–94.",
            "Suber, P. (2019). *Open access*. MIT Press."
        ],
        'imrad' => [
            'introducao' => "Discutir a dificuldade física de consultar monografias e artigos académicos antigos por falta de informatização nas bibliotecas da Zambézia. Apresentar a BibliotecaDigital Licungo como repositório aberto de conhecimento local.",
            'metodologia' => "Descrever a arquitetura Laravel e MySQL para armazenamento dos ficheiros PDF, organizados por faculdade, curso e ano de publicação. Implementar sistema de pesquisa avançada por palavras-chave e autores.",
            'resultados' => "Mostrar o ecrã de pesquisa rápida com filtros avançados de publicação e a funcionalidade de leitura direta de PDFs no navegador. Exibir relatórios administrativos com estatísticas dos documentos mais descarregados.",
            'conclusao' => "Destacar o papel da plataforma no combate ao plágio académico e na democratização da leitura científica. Identificar barreiras como custos de alojamento em nuvem. Recomendar a expansão para outras faculdades da região."
        ]
    ],

    // === PROJECTO 15: TutorIA ===
    15 => [
        'perguntas' => [
            "Como agentes inteligentes baseados em modelos de linguagem de grande escala (LLM) podem atuar como assistentes de tutoria individualizados para caloiros de engenharia informática?",
            "Quais as preocupações éticas e pedagógicas decorrentes do uso de inteligência artificial generativa na elaboração de trabalhos de programação na UniLicungo?",
            "Qual a viabilidade económica e tecnológica de adaptar modelos de inteligência artificial open-source (como LLaMA) ao currículo académico local?"
        ],
        'referencias' => [
            "Mário, A. J., & Sambo, V. (2023). Inteligência artificial no ensino superior em Moçambique: Ameaça ou aliada? *Revista Moçambicana de Tecnologia Educativa*, 6(1), 22–31.",
            "African Union. (2022). *AI for Africa: Harnessing technology for educational advancement*. AU Task Force Report.",
            "Luckin, R. (2020). *Machine learning and human intelligence: The role of AI in education*. UCL Press."
        ],
        'imrad' => [
            'introducao' => "Evidenciar a sobrecarga de turmas numerosas nos primeiros anos universitários, limitando a mentoria individualizada dos docentes. Introduzir o TutorIA como assistente virtual complementar para caloiros de informática.",
            'metodologia' => "Explicar o desenvolvimento da interface Web utilizando React integrada a um servidor em Flask/Laravel que consome APIs externas de IA configuradas com contextos curriculares específicos do curso de Informática.",
            'resultados' => "Apresentar a interface de conversação interativa demonstrando a resolução guiada passo-a-passo de erros de código e a geração automática de quizzes de autoavaliação conceitual das matérias abordadas.",
            'conclusao' => "Concluir ressaltando o aumento da autoconfiança de estudo fora de sala de aula. Discutir riscos éticos de cópia de código automatizada. Sugerir a criação de filtros para que a IA oriente sem dar respostas prontas."
        ]
    ],

    // === PROJECTO 16: FrequênciaDigital ===
    16 => [
        'perguntas' => [
            "Como a introdução de sistemas de validação de presença baseados em QR Code dinâmico influencia a taxa de pontualidade em salas de aula da UniLicungo?",
            "Quais são os principais desafios técnicos de implementar soluções de controlo de presenças baseadas em localização GPS móvel em Quelimane?",
            "De que forma a automatização das pautas de frequência pode otimizar a produtividade administrativa dos docentes ao final do semestre académico?"
        ],
        'referencias' => [
            "Universidade Licungo. (2021). *Manual de avaliação do ensino superior e regulamentação de frequência de aulas*. Quelimane.",
            "Nhantumbo, F., & Tembe, A. (2020). Soluções de governação digital nas instituições de ensino superior em Quelimane. *Revista Moçambicana de Gestão Pública*, 8(2), 45–53.",
            "Mohammad, A. (2019). Smart attendance systems using QR Code and mobile technology: A comparative review. *Journal of Academic Software*, 11(3), 102–111."
        ],
        'imrad' => [
            'introducao' => "Apresentar o problema do tempo desperdiçado em chamadas orais manuais e o risco de assinaturas fraudulentas em turmas universitárias numerosas. Apresentar o conceito do sistema FrequênciaDigital.",
            'metodologia' => "Descrever o desenvolvimento da aplicação móvel Flutter e do painel web Laravel. Explicar como o professor projeta um QR Code dinâmico encriptado na tela, o qual deve ser lido pelos telemóveis dos alunos na sala.",
            'resultados' => "Exibir o painel de assiduidade do docente gerando estatísticas de faltas por aluno e por turma em tempo real. Mostrar relatórios de presença exportáveis para PDF e alertas automáticos de exclusão por limite de faltas.",
            'conclusao' => "Enfatizar a economia de tempo de aula útil e a fidedignidade dos registos digitais. Identificar a necessidade de acesso a dispositivos smartphone por todos os estudantes. Propor integração direta com o sistema de matrículas."
        ]
    ],

    // === PROJECTO 17: MentorJovem ===
    17 => [
        'perguntas' => [
            "De que forma programas de tutoria e mentoria partilhados via plataformas digitais auxiliam na integração académica e na redução da retenção de caloiros em Quelimane?",
            "Quais as preferências de canais de comunicação e as principais necessidades de orientação dos caloiros no início do percurso universitário na Zambézia?",
            "Como algoritmos de correspondência automática de interesses podem otimizar o emparelhamento entre estudantes experientes (mentores) e caloiros (mentados)?"
        ],
        'referencias' => [
            "Ministério do Ensino Superior, Ciência e Tecnologia de Moçambique. (2021). *Estratégia nacional de combate à retenção escolar no ensino superior*. MESCT.",
            "Moiane, J., & Langa, E. (2022). O papel da mentoria estudantil no sucesso académico universitário: O caso da Província da Zambézia. *Revista UniLicungo*, 5(2), 104–112.",
            "Kram, K. E. (2019). *Mentoring at work: Developmental relationships in organizational life*. University Press."
        ],
        'imrad' => [
            'introducao' => "Destacar o elevado índice de reprovação e desistência no 1.º ano de informática motivados por choque cultural e desorientação inicial. Apresentar o MentorJovem como resposta de acolhimento digital.",
            'metodologia' => "Explicar a modelagem de dados da plataforma em Laravel e React, focando-se no algoritmo de matching de interesses académicos e nas salas virtuais de chat em tempo real utilizando WebSockets.",
            'resultados' => "Apresentar capturas de ecrã do dashboard do mentor contendo a lista de caloiros sob sua orientação e o calendário de encontros de esclarecimento agendados e avaliados de forma simples.",
            'conclusao' => "Ressaltar o fortalecimento do espírito de comunidade estudantil e a melhoria no rendimento inicial das cadeiras de programação. Sugerir a inclusão de gamificação baseada em conquistas e medalhas digitais."
        ]
    ],

    // === PROJECTO 18: LínguaMoz ===
    18 => [
        'perguntas' => [
            "Como interfaces móveis focadas na preservação e tradução de línguas nacionais (Sena/Chuabo) podem apoiar a comunicação de profissionais de saúde em Quelimane?",
            "Quais os desafios de design e usabilidade enfrentados no registo de pronúncias fonéticas áudio numa aplicação móvel para contextos multilingues moçambicanos?",
            "De que forma a tecnologia móvel pode ser utilizada para salvaguardar o património linguístico intangível de gerações idosas em áreas rurais da Zambézia?"
        ],
        'referencias' => [
            "Ministério da Cultura e Turismo de Moçambique. (2021). *Políticas de valorização e preservação das línguas nacionais de Moçambique*. MCT.",
            "Cossa, A., & Chambal, M. (2020). Desafios da digitalização das línguas bantu em Moçambique: O caso das línguas do centro e norte. *Linguística e Sociedade*, 15(1), 58–67.",
            "Crystal, D. (2018). *Language death: The preservation of linguistic diversity*. Cambridge University Press."
        ],
        'imrad' => [
            'introducao' => "Abordar o risco de extinção progressiva de termos históricos e o problema de comunicação de médicos e ONGs em comunidades sem fluência em português. Justificar o desenvolvimento do aplicativo LínguaMoz.",
            'metodologia' => "Explicar a implementação em Flutter integrada com base de dados SQLite local, com suporte a compressão e reprodução de ficheiros de áudio reais de pronúncia pré-gravados em laboratório de linguística.",
            'resultados' => "Mostrar o ecrã com o dicionário interativo português-chuabo-sena e as lições básicas divididas por contextos cotidianos (consulta médica, mercado, escola) com quizzes de áudio correspondentes.",
            'conclusao' => "Concluir realçando o valor cultural e prático da aplicação para fins de inclusão e saúde. Apontar limites de espaço de armazenamento para ficheiros de áudio em telemóveis antigos. Recomendar a adição de novos dialetos."
        ]
    ],

    // === PROJECTO 19: CurrículoMoz ===
    19 => [
        'perguntas' => [
            "De que forma a simplificação do processo de estruturação curricular por vias digitais melhora a taxa de empregabilidade inicial dos recém-licenciados em Quelimane?",
            "Quais os erros mais comuns de formatação e estruturação de currículos apresentados por jovens moçambicanos às oportunidades locais de trabalho?",
            "Como a integração de assistentes baseados em regras ou IA na escrita curricular influencia a qualidade técnica do documento final?"
        ],
        'referencias' => [
            "Instituto Nacional do Emprego de Moçambique (INFP). (2022). *Relatório nacional do emprego jovem e inserção no mercado de trabalho*. INFP Moçambique.",
            "Tembe, L., & Bila, P. (2021). Literacia digital e habilidades de empregabilidade em jovens finalistas na Zambézia. *Revista Moçambicana de Desenvolvimento*, 7(2), 88–95.",
            "Bolles, R. N. (2021). *What color is your parachute? A practical guide for job-hunters and career-changers*. Ten Speed Press."
        ],
        'imrad' => [
            'introducao' => "Discutir a dificuldade técnica dos jovens de Quelimane em estruturar currículos alinhados com o mercado de trabalho local. Introduzir o CurrículoMoz como facilitador profissional de acesso aberto.",
            'metodologia' => "Explicar a construção em Laravel e React utilizando a biblioteca Dompdf para geração rápida e limpa de PDFs no formato padrão europeu e local moçambicano, a partir de formulários simples organizados por secções.",
            'resultados' => "Mostrar a interface com o preenchimento em tempo real e o currículo gerado de forma limpa em PDF, pronto para descarregar. Exibir dicas contextuais de formatação que surgem enquanto o utilizador digita.",
            'conclusao' => "Destacar o papel de inclusão da ferramenta ao reduzir a barreira da escrita profissional. Sugerir a criação futura de um gerador automático de cartas de apresentação e de um mural de vagas de emprego locais."
        ]
    ],

    // === PROJECTO 21: AgroZambézia ===
    21 => [
        'perguntas' => [
            "Como o acesso tardio a dados meteorológicos e preços de mercado afecta o rendimento de pequenos produtores de Quelimane e arredores?",
            "De que forma a tecnologia móvel simples pode aproximar o produtor rural do comprador urbano, eliminando intermediários na Zambézia?",
            "Qual a viabilidade de usar dados abertos para monitorizar desastres naturais ou ciclos de sementeira na província da Zambézia?"
        ],
        'referencias' => [
            "Instituto de Investigação Agrária de Moçambique (IIAM). (2022). *Manual de boas práticas agrícolas e calendário de culturas para a Zambézia*. IIAM.",
            "Macassa, E., & Muthemba, R. (2021). Uso de tecnologias de informação para mitigação de riscos agrícolas na Zambézia. *Revista Moçambicana de Agro-Tecnologia*, 4(1), 12–21.",
            "FAO. (2021). *Digital agriculture in Sub-Saharan Africa: Challenges and opportunities*. FAO Publishing."
        ],
        'imrad' => [
            'introducao' => "Apresentar a agricultura de subsistência como o pilar económico da Zambézia, descrevendo as perdas de colheitas causadas por falta de informação climática. Introduzir o aplicativo AgroZambézia.",
            'metodologia' => "Descrever o desenvolvimento da aplicação em Flutter integrada com APIs abertas de previsão meteorológica e base de dados MySQL local. Explicar como os preços de mercado são cadastrados e atualizados.",
            'resultados' => "Mostrar o ecrã com a previsão meteorológica diária simplificada e o calendário agrícola interativo sugerido para culturas locais (como arroz e mandioca) com alertas visuais de períodos ideais de sementeira.",
            'conclusao' => "Concluir ressaltando a utilidade no planeamento de sementeiras pelos produtores locais. Indicar a barreira linguística e de conectividade como desafios contínuos. Recomendar suporte para áudio em Chuabo no app."
        ]
    ],

    // === PROJECTO 51: OrientaVocacional ===
    51 => [
        'perguntas' => [
            "De que forma o aconselhamento vocacional baseado em perfis digitais de habilidades influencia a escolha de cursos superiores por estudantes do ensino secundário em Quelimane?",
            "Como o histórico de notas e preferências pessoais podem ser correlacionados em algoritmos para sugerir ramos de especialização académica adequados em Moçambique?",
            "Quais são os principais fatores socioeconómicos e familiares que interferem na decisão de carreira de jovens finalistas na Província da Zambézia?"
        ],
        'referencias' => [
            "Ministério da Educação e Desenvolvimento Humano de Moçambique. (2022). *Relatório de transição do ensino secundário para o ensino superior*. MINEDH.",
            "Nhantumbo, P., & Bila, C. (2021). Orientação escolar e profissional em escolas secundárias públicas da Zambézia: Práticas e desafios. *Revista Moçambicana de Psicologia Educacional*, 8(2), 75–84.",
            "Super, D. E. (2018). *The psychology of careers: An introduction to vocational development*. Harper & Row."
        ],
        'imrad' => [
            'introducao' => "Apresentar a desorientação de alunos finalistas da 12.ª classe ao escolher cursos universitários por falta de serviços de psicologia vocacional. Introduzir o portal OrientaVocacional.",
            'metodologia' => "Descrever o desenvolvimento utilizando Laravel + Blade + MySQL. Explicar a estrutura do questionário dinâmico baseado na teoria de Holland e a lógica de correspondência com as grelhas curriculares das universidades locais.",
            'resultados' => "Apresentar os ecrãs do questionário interativo e o relatório final de vocação contendo os três principais cursos sugeridos e a justificação pedagógica com base nas respostas dadas pelo estudante.",
            'conclusao' => "Concluir enfatizando a redução da taxa de frustração e abandono de cursos superiores no primeiro ano. Indicar limites na validação empírica do teste. Propor a inclusão de sessões virtuais com psicólogos da UniLicungo."
        ]
    ],

    // === PROJECTO 52: Cores & Perfis ===
    52 => [
        'perguntas' => [
            "Como a identificação de perfis comportamentais através de jogos digitais interativos pode otimizar a formação de equipas académicas no curso de informática em Quelimane?",
            "De que forma o modelo de personalidade de 4 cores (Verde, Azul, Amarelo, Vermelho) se correlaciona com o desempenho prático de estudantes em projetos de programação coletiva?",
            "Quais as preferências de dinâmicas de gamificação comportamental para jovens universitários de informática em Moçambique?"
        ],
        'referencias' => [
            "Associação Moçambicana de Psicologia. (2021). *Avaliação psicológica e perfis comportamentais em estudantes universitários*. AMP.",
            "Sambo, J., & Langa, T. (2022). Dinâmicas de trabalho em grupo e perfis de personalidade em cursos de ciência e tecnologia na Zambézia. *Revista Moçambicana de Ciências de Educação*, 10(1), 45–53.",
            "Marston, W. M. (2019). *Emotions of normal people: The psychological foundation of the DISC personality model*. Routledge."
        ],
        'imrad' => [
            'introducao' => "Problematizar a ocorrência frequente de conflitos de liderança e desequilíbrios de tarefas em grupos académicos no primeiro ano de faculdade. Apresentar o jogo interativo Cores & Perfis como ferramenta de harmonização.",
            'metodologia' => "Descrever a modelagem em Blade e JavaScript puro para controlo do jogo. Explicar o questionário gamificado de respostas rápidas que soma pontuações para definir a cor predominante do utilizador.",
            'resultados' => "Exibir o ecrã com o resultado da personalidade representada por cores dinâmicas e o relatório descritivo das características de cooperação e liderança da cor obtida pelo utilizador.",
            'conclusao' => "Discutir a utilidade da ferramenta na montagem equilibrada de equipas de desenvolvimento. Assinalar limitações metodológicas em questionários simplificados de personalidade. Sugerir a partilha de perfis entre colegas via QR Code."
        ]
    ]
];
