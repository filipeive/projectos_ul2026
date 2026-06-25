<?php
$file = 'resources/data/projects.json';
$data = json_decode(file_get_contents($file), true);

$newProjects = [
    [
        "number" => 53,
        "name" => "Maternidade Plus",
        "subtitle" => "Sistema digital de acompanhamento pré-natal",
        "sector" => "Saúde",
        "problema" => "Perda de dados devido a fichas de papel rasgadas ou esquecidas",
        "publico_alvo" => "Hospitais, Clínicas, Gestantes",
        "impacto" => "Melhoria no acompanhamento da curva de peso do bebé e alertas de vacinas",
        "tecnologias" => "PHP Puro / Laravel + MySQL",
        "dificuldade" => "Fácil",
        "startup" => "Alto",
        "parcerias" => "Hospitais Locais, Clínicas Materno-Infantis",
        "funcionalidades" => "Registo de pacientes, gráficos de evolução, alertas automáticos",
        "melhorias_futuras" => "Integração via SMS para lembrar as mães das consultas",
        "perguntas_pesquisa" => [
            "De que forma a digitalização do cartão da gestante contribui para a redução de erros médicos?",
            "Como sistemas de notificação via SMS impactam o comparecimento a consultas de rotina em Quelimane?",
            "Quais são as principais barreiras na adesão a plataformas de saúde digital por parte dos profissionais locais?"
        ],
        "dicas_estudo" => "Estruture um CRUD simples de pacientes e evoluções clínicas. Para gráficos, explore bibliotecas Javascript simples como Chart.js."
    ],
    [
        "number" => 54,
        "name" => "Olhos da Cidade",
        "subtitle" => "App de IA assistiva para pessoas com deficiência visual",
        "sector" => "Inclusão Social",
        "problema" => "Falta de mobilidade independente para pessoas com deficiência visual em Quelimane",
        "publico_alvo" => "Pessoas com deficiência visual, familiares",
        "impacto" => "Autonomia e mobilidade urbana aprimorada",
        "tecnologias" => "Flutter / React Native + IA de Reconhecimento",
        "dificuldade" => "Avançado",
        "startup" => "Médio",
        "parcerias" => "ADEMO, Associações de Inclusão",
        "funcionalidades" => "Reconhecimento de obstáculos via câmera, feedback de voz, leitura de texto básico",
        "melhorias_futuras" => "Integração avançada com GPS para navegação completa na cidade",
        "perguntas_pesquisa" => [
            "Quais as maiores barreiras de mobilidade e acessibilidade na cidade de Quelimane?",
            "Como a IA em tempo real nos telemóveis de entrada pode ser utilizada para reconhecimento de padrões urbanos?",
            "Qual o nível de aceitação de tecnologias assistivas pela comunidade local?"
        ],
        "dicas_estudo" => "Este projeto desafiante requer integração com as APIs de acessibilidade do telemóvel (Text-to-Speech) e uso de bibliotecas de Machine Learning no frontend."
    ],
    [
        "number" => 55,
        "name" => "Sangue Seguro Quelimane",
        "subtitle" => "Registo digital e convocação de dadores de sangue",
        "sector" => "Saúde",
        "problema" => "Dificuldade dos hospitais em encontrar dadores compatíveis rapidamente em emergências",
        "publico_alvo" => "Hospitais Central, Cruz Vermelha, Voluntários",
        "impacto" => "Salvar vidas reduzindo o tempo de procura de sangue",
        "tecnologias" => "Laravel + MySQL + SMS Gateway",
        "dificuldade" => "Médio",
        "startup" => "Baixo (Serviço de Utilidade Pública)",
        "parcerias" => "Hospital Central de Quelimane, Cruz Vermelha",
        "funcionalidades" => "Base de dados de dadores, disparo de SMS segmentado por grupo sanguíneo, agenda de doações",
        "melhorias_futuras" => "Módulo para hospitais periféricos da Zambézia se integrarem ao sistema central",
        "perguntas_pesquisa" => [
            "Qual o impacto de um sistema unificado na redução do tempo de espera por transfusões urgentes?",
            "Como campanhas digitais influenciam a adesão de novos dadores voluntários?",
            "Como garantir a privacidade e segurança dos dados de saúde em plataformas públicas?"
        ],
        "dicas_estudo" => "A focar-se na segurança de dados. O disparo de SMS pode ser simulado ou integrado usando Twilio/Plivo."
    ],
    [
        "number" => 56,
        "name" => "Alerta Cheias Zambézia",
        "subtitle" => "Mapa comunitário de monitorização e alerta de enchentes",
        "sector" => "Agricultura e Ambiente",
        "problema" => "Falta de informação em tempo real sobre ruas alagadas ou intransitáveis",
        "publico_alvo" => "Munícipes, INGC, Transporte Público",
        "impacto" => "Rotas mais seguras, prevenção de desastres locais",
        "tecnologias" => "React / Vue + Firebase / Supabase + Leaflet",
        "dificuldade" => "Médio",
        "startup" => "Médio",
        "parcerias" => "INGC, Município de Quelimane, Proteção Civil",
        "funcionalidades" => "Reporte comunitário, mapa interativo em tempo real, alertas push",
        "melhorias_futuras" => "Uso de dados da estação meteorológica para previsão automatizada",
        "perguntas_pesquisa" => [
            "De que forma o crowdsourcing (reporte colaborativo) melhora a eficiência na gestão urbana em períodos chuvosos?",
            "Como disponibilizar dados georreferenciados para telemóveis de baixa capacidade computacional?",
            "Qual a correlação entre ruas sem drenagem mapeadas e os surtos sazonais de doenças hídricas?"
        ],
        "dicas_estudo" => "Explore mapas baseados em OpenStreetMap (ex: Leaflet.js). A chave é criar uma interface muito rápida para reportar incidentes usando geolocalização do browser."
    ],
    [
        "number" => 57,
        "name" => "Txopela Partilhado UniLicungo",
        "subtitle" => "Plataforma de carpooling universitário para táxis e txopelas",
        "sector" => "Vida na Cidade",
        "problema" => "Custos altos de transporte individual e problemas de segurança pós-laboral",
        "publico_alvo" => "Estudantes, Docentes, Taxistas locais",
        "impacto" => "Economia estudantil, aumento da segurança, redução de emissões",
        "tecnologias" => "Laravel / PHP Puro + MySQL",
        "dificuldade" => "Médio",
        "startup" => "Alto",
        "parcerias" => "Associação de Estudantes, Praças de Txopela Locais",
        "funcionalidades" => "Matching de rotas, cálculo de partilha de custo, chat interno seguro",
        "melhorias_futuras" => "Integração com pagamento por M-Pesa / e-Mola diretamente na app",
        "perguntas_pesquisa" => [
            "Como a economia partilhada pode resolver problemas estruturais de transporte estudantil?",
            "Qual a percepção de segurança dos estudantes em plataformas de carpooling institucionais vs informais?",
            "De que forma a tecnologia reduz o custo financeiro da mobilidade académica pós-laboral?"
        ],
        "dicas_estudo" => "Implemente um algoritmo simples de agrupamento de usuários baseando-se em horários e zonas da cidade aproximadas (ex: Sagrada, Micajuine, etc)."
    ],
    [
        "number" => 58,
        "name" => "AgroLiga Zambézia",
        "subtitle" => "Plataforma B2B para conexão de camponeses e restaurantes",
        "sector" => "Empreendedorismo e PMEs",
        "problema" => "Desperdício de colheitas de pequenos camponeses por falta de canais de venda direta",
        "publico_alvo" => "Pequenos Produtores, Restaurantes, Mercados Formais",
        "impacto" => "Redução do desperdício alimentar e aumento da renda do pequeno produtor",
        "tecnologias" => "Laravel + Livewire + MySQL",
        "dificuldade" => "Fácil",
        "startup" => "Alto",
        "parcerias" => "Associações de Produtores, CTA",
        "funcionalidades" => "Vitrine de produtos disponíveis, gestão de encomendas e cotações, painel para restaurantes",
        "melhorias_futuras" => "Módulo de logística e transporte partilhado entre quintas e cidade",
        "perguntas_pesquisa" => [
            "Qual o impacto de plataformas B2B locais na eliminação de intermediários na agricultura familiar?",
            "Como otimizar a interface de aplicações web para produtores rurais com baixa literacia digital?",
            "Que impacto económico tem o escoamento rápido no desenvolvimento local dos distritos vizinhos de Quelimane?"
        ],
        "dicas_estudo" => "Pense no fluxo comercial (Produtor -> Registo de Produto -> Restaurante -> Compra). Focar na facilidade de uso para quem regista o produto (Produtor)."
    ]
];

$data = array_merge($data, $newProjects);
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Projetos adicionados com sucesso.\n";
?>
