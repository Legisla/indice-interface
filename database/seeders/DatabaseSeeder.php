<?php

namespace Database\Seeders;

use App\Models\Congressperson;
use App\Models\CongresspersonAxis;
use App\Models\CongresspersonIndicator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (false) {

            $axes = [
                ['id' => 1, 'name' => 'Produção Legislativa', 'description' => ''],
                ['id' => 2, 'name' => 'Fiscalização', 'description' => ''],
                ['id' => 3, 'name' => 'Mobilização', 'description' => ''],
                ['id' => 4, 'name' => 'Alinhamento Partidário', 'description' => ''],
            ];

            foreach ($axes as $axis) {
                DB::table('axes')->updateOrInsert(
                    ['id' => $axis['id']],
                    [
                        'name' => $axis['name'],
                        'description' => $axis['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                );
            }

            $indicators = [
                [
                    'fk_axis_id' => 1,
                    'id' => 1,
                    'name' => 'Projetos',
                    'invert_score' => 0,
                    'description' => 'Total de proposições dos tipos PDL,PEC,PL,PLP,PLV'
                ],
                ['fk_axis_id' => 1,
                    'id' => 2,
                    'name' => 'Protagonismo',
                    'invert_score' => 0,
                    'description' => 'Total de proposições dos tipos PDL,PEC,PL,PLP,PLV e assinatura é a primeira e é preponente'
                ],
                [
                    'fk_axis_id' => 1,
                    'id' => 3,
                    'name' => 'Relevância das Autorias',
                    'invert_score' => 0,
                    'description' => "Total de proposições dos tipos PDL,PEC,PL,PLP,PLV e assinatura é a primeira  e preponente ,  ementa não possui os termos 'hora|dia|Dia|semana|Semana|Mês|ano|data| festa|calendário|título| prêmio|  medalha| nome|galeria|ponte|ferrovia| aeroporto|rotatória|honorpario' e tema não é 'Homenagens e Datas Comemorativas'"
                ],
                [
                    'fk_axis_id' => 1,
                    'id' => 4,
                    'name' => 'Votos em separado apresentados',
                    'invert_score' => 0,
                    'description' => 'Total de  proposições siglaTipo VTS'
                ],
                [
                    'fk_axis_id' => 1,
                    'id' => 5,
                    'name' => 'Substituitivos apresentados',
                    'invert_score' => 0,
                    'description' => 'Total de  proposições siglaTipo SBT'
                ],
                ['fk_axis_id' => 1,
                    'id' => 6,
                    'name' => 'Relatorias apresentadas',
                    'invert_score' => 0,
                    'description' => 'Total de  proposições siglaTipo PRL'
                ],
                [
                    'fk_axis_id' => 1,
                    'id' => 7,
                    'name' => 'Presença em Plenário',
                    'invert_score' => 0,
                    'description' => "Porcentagem da presença em eventos com localCamara.nome == 'Plenário da Câmara dos Deputados' e descricaoTipo 'Sessão Deliberativa'."
                ],
                [
                    'fk_axis_id' => 1,
                    'id' => 8,
                    'name' => 'Emendas de Plenário',
                    'invert_score' => 0,
                    'description' => "Total de proposições siglaTipo  EMP onde descricaoTipo diferente de 'Emenda de Plenário à MPV (Ato Conjunto 1/20)'"
                ],
                [
                    'fk_axis_id' => 2,
                    'id' => 9,
                    'name' => 'Requerimento e Fiscalização', 'invert_score' => 0,
                    'invert_score' => 0,
                    'description' => "Total de  proposições siglaTipo RIC e PFC"
                ],

                [
                    'fk_axis_id' => 2,
                    'id' => 10,
                    'name' => 'Emendas Parlamentares',
                    'invert_score' => 0,
                    'description' => "Valor total das emendas"
                ],
                [
                    'fk_axis_id' => 2,
                    'id' => 11,
                    'name' => 'Emendas de Medidas Provisórias',
                    'invert_score' => 0,
                    'description' => "Proposições tipoSigla EMP com  descricaoTipo == 'Emenda de Plenário MPV (Ato Conjunto 1/20)'"
                ],
                [
                    'fk_axis_id' => 2, 'id' => 12,
                    'name' => 'Emendas de orçamento',
                    'invert_score' => 0,
                    'description' => "Poposiões em que a descricaoTipo tem dos 3 valores: 'Sugestão de Emenda à LDO - Comissões' (siglaTipo SLD); 'Sugest�o de Emenda ao Orçamento - Comissões' (siglaTipo SOR); 'Emenda ao Orçamento' (siglaTipo EMO)"
                ],
                [
                    'fk_axis_id' => 3,
                    'id' => 13,
                    'name' => 'Projetos de autoria com status especial',
                    'invert_score' => 0,
                    'description' => "Total de proposiões onde a siglaTipo é PDL | PEC | PL | PLP | PLV  e statusProposicao->regime não contém 'Art. 151' nem é  '.'"
                ],

                [
                    'fk_axis_id' => 3,
                    'id' => 14,
                    'name' => 'Cargos ocupados na legislatura',
                    'invert_score' => 0,
                    'description' => "Cargos ocupados na legislatura, seguindo pontuação descrita em App\Enums\Memberships"
                ],
                [
                    'fk_axis_id' => 3,
                    'id' => 15,
                    'name' => 'Requerimentos de Audiência Pública',
                    'invert_score' => 0,
                    'description' => "Total de proposições 'Requerimento' (siglaTipo REQ)  e ou  ementa = 'Audiência Pública'  147"
                ],
                [
                    'fk_axis_id' => 4,
                    'id' => 16,
                    'name' => 'Desvio da posição majoritária do partido em votações',
                    'invert_score' => 1,
                    'description' => "Conferir votações e contar votos dos seguintes valores: 'Abstenção'|'Artigo 17'| 'Não' | 'Obstrução' | 'Sim'. Se os votos desse tipo se alinharem com a oritenação do partido, contar levantar porcentagem do total de orientações. comparar com orientação do partido e guardar porcentagem"
                ],
            ];

            foreach ($indicators as $indicator) {
                DB::table('indicators')->updateOrInsert(
                    ['id' => $indicator['id']],
                    [
                        'fk_axis_id' => $indicator['fk_axis_id'],
                        'name' => $indicator['name'],
                        'description' => $indicator['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                );
            }

            $states = [
                ['id' => 1, 'acronym' => "AC", "name" => "Acre"],
                ['id' => 2, 'acronym' => "AL", "name" => "Alagoas"],
                ['id' => 3, 'acronym' => "AM", "name" => "Amazonas"],
                ['id' => 4, 'acronym' => "AP", "name" => "Amapá"],
                ['id' => 5, 'acronym' => "BA", "name" => "Bahia"],
                ['id' => 6, 'acronym' => "CE", "name" => "Ceará"],
                ['id' => 7, 'acronym' => "DF", "name" => "Distrito Federal"],
                ['id' => 8, 'acronym' => "ES", "name" => "Espírito Santo"],
                ['id' => 9, 'acronym' => "GO", "name" => "Goiás"],
                ['id' => 10, 'acronym' => "MA", "name" => "Maranhão"],
                ['id' => 11, 'acronym' => "MG", "name" => "Minas Gerais"],
                ['id' => 12, 'acronym' => "MS", "name" => "Mato Grosso do Sul"],
                ['id' => 13, 'acronym' => "MT", "name" => "Mato Grosso"],
                ['id' => 14, 'acronym' => "PA", "name" => "Pará"],
                ['id' => 15, 'acronym' => "PB", "name" => "Paraíba"],
                ['id' => 16, 'acronym' => "PE", "name" => "Pernambuco"],
                ['id' => 17, 'acronym' => "PI", "name" => "Piauí"],
                ['id' => 18, 'acronym' => "PR", "name" => "Paraná"],
                ['id' => 19, 'acronym' => "RJ", "name" => "Rio de Janeiro"],
                ['id' => 20, 'acronym' => "RN", "name" => "Rio Grande do Norte"],
                ['id' => 21, 'acronym' => "RO", "name" => "Rondônia"],
                ['id' => 22, 'acronym' => "RR", "name" => "Roraima"],
                ['id' => 23, 'acronym' => "RS", "name" => "Rio Grande do Sul"],
                ['id' => 24, 'acronym' => "SC", "name" => "Santa Catarina"],
                ['id' => 25, 'acronym' => "SE", "name" => "Sergipe"],
                ['id' => 26, 'acronym' => "SP", "name" => "São Paulo"],
                ['id' => 27, 'acronym' => "TO", "name" => "Tocantins"],
            ];

            foreach ($states as $state) {
                DB::table('states')->updateOrInsert(
                    ['id' => $state['id']],
                    [
                        'acronym' => $state['acronym'],
                        'name' => $state['name'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                );
            }

            $siteConfigs = [
                ['id' => 1, 'type' => 's', 'key' => 'siteTitle', 'name' => 'Título do site', 'value' => 'Índice Legisla Brasil', 'description' => 'Título do site - informação para o header/seo do site'],
                ['id' => 2, 'type' => 's', 'key' => 'siteDescription', 'name' => 'Descrição do site', 'value' => 'Índice Legisla Brasil', 'description' => 'Descrição do site - informação para o header/seo do site'],
                ['id' => 3, 'type' => 's', 'key' => 'siteKeywords', 'name' => 'Palavras-chave do site', 'value' => 'Índice Legisla Brasil', 'description' => 'Palavras-chave do site - informação para o header/seo do site'],
                ['id' => 4, 'type' => 's', 'key' => 'siteAuthor', 'name' => 'Autor do site', 'value' => 'Índice Legisla Brasil', 'description' => 'Autor do site - informação para o header/seo do site'],
                ["id" => 5, 'type' => 's', "key" => "linkFacebook", "name" => "Página Facebook", "value" => "", "description" => "Link da Página oficial no Facebook"],
                ["id" => 6, 'type' => 's', "key" => "userInstagram", "name" => "Instagram", "value" => "", "description" => "Perfil oficial no Instagram"],
                ["id" => 7, 'type' => 's', "key" => "linkLinkedin", "name" => "LinkedIn", "value" => "", "description" => "Perfil oficial no LinkedIn"],
                ["id" => 8, 'type' => 's', "key" => "idPropertyAnalytics", "name" => "ID da vista da propriedade do Google Analytics", "value" => "", "description" => "Código usado para exibição dos gráficos de relatório do Google Analytics dentro do gerenciador. Encontre o ID da vista da propriedade no menu Vista da propriedade›Visualizar configurações›ID da vista da propriedade dentro do painel do Google Analytics"],
                ["id" => 9, 'type' => 's', "key" => "codeGoogleAnalytics", "name" => "Código de acompanhamento do Google Analytics", "value" => "", "description" => "Código usado de rastreamento do Google Analytics"],
                ["id" => 10, 'type' => 's', "key" => "facebookPixel", "name" => "Facebook Pixel", "value" => "", "description" => "Código do Facebook Pixel"],
                ["id" => 11, 'type' => 's', "key" => "emailSiteAdmin", "name" => "Email para Notificações do Sistema", "value" => "", "description" => "E-mail que receberá avisos do site."],
                ["id" => 12, 'type' => 's', "key" => "nationalExpenditureAverage", "name" => "Gasto de Gabinete Médio Nacional", "value" => "", "description" => "Gasto de Gabinete Médio Nacional - será exibido para comparação no site."],
            ];

            foreach ($siteConfigs as $siteConfig) {
                DB::table('site_configs')->updateOrInsert(
                    ['id' => $siteConfig['id']],
                    [
                        'key' => $siteConfig['key'],
                        'name' => $siteConfig['name'],
                        'value' => $siteConfig['value'],
                        'description' => $siteConfig['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                );
            }

        }


        if (false) {
            $types = [
                [
                    "cod" => "129",
                    "sigla" => "CON",
                    "nome" => "Consulta",
                    "descricao" => "Consulta"
                ],
                [
                    "cod" => "130",
                    "sigla" => "EMC",
                    "nome" => "Emenda na Comissão",
                    "descricao" => "Emenda Apresentada na Comissão"
                ],
                [
                    "cod" => "131",
                    "sigla" => "EMP",
                    "nome" => "Emenda de Plenário",
                    "descricao" => "Emenda de Plenário"
                ],
                [
                    "cod" => "132",
                    "sigla" => "EMS",
                    "nome" => "Emenda/Substitutivo do Senado",
                    "descricao" => "Emenda/Substitutivo do Senado"
                ],
                [
                    "cod" => "133",
                    "sigla" => "INC",
                    "nome" => "Indicação",
                    "descricao" => "Indicação"
                ],
                [
                    "cod" => "134",
                    "sigla" => "MSC",
                    "nome" => "Mensagem",
                    "descricao" => "Mensagem"
                ],
                [
                    "cod" => "135",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo",
                    "descricao" => "Projeto de Decreto Legislativo"
                ],
                [
                    "cod" => "136",
                    "sigla" => "PEC",
                    "nome" => "Proposta de Emenda à Constituição",
                    "descricao" => "Proposta de Emenda à Constituição (Art. 60 CF c/c art. 201 a 203, RICD)"
                ],
                [
                    "cod" => "137",
                    "sigla" => "PET",
                    "nome" => "Petição",
                    "descricao" => "Petição"
                ],
                [
                    "cod" => "138",
                    "sigla" => "PFC",
                    "nome" => "Proposta de Fiscalização e Controle",
                    "descricao" => "Proposta de Fiscalização e Controle"
                ],
                [
                    "cod" => "139",
                    "sigla" => "PL",
                    "nome" => "Projeto de Lei",
                    "descricao" => "Projeto de Lei"
                ],
                [
                    "cod" => "140",
                    "sigla" => "PLP",
                    "nome" => "Projeto de Lei Complementar",
                    "descricao" => "Projeto de Lei Complementar (Art. 61 CF)"
                ],
                [
                    "cod" => "141",
                    "sigla" => "PRC",
                    "nome" => "Projeto de Resolução",
                    "descricao" => "Projeto de Resolução"
                ],
                [
                    "cod" => "142",
                    "sigla" => "PRN",
                    "nome" => "Projeto de Resolução do Congresso Nacional",
                    "descricao" => "Projeto de Resolução (CN)"
                ],
                [
                    "cod" => "143",
                    "sigla" => "RCP",
                    "nome" => "Requerimento de Instituição de CPI",
                    "descricao" => "Requerimento de Instituição de Comissão Parlamentar de Inquérito"
                ],
                [
                    "cod" => "144",
                    "sigla" => "REC",
                    "nome" => "Recurso",
                    "descricao" => "Recurso"
                ],
                [
                    "cod" => "145",
                    "sigla" => "REM",
                    "nome" => "Reclamação",
                    "descricao" => "Reclamação"
                ],
                [
                    "cod" => "146",
                    "sigla" => "REP",
                    "nome" => "Representação",
                    "descricao" => "Representação"
                ],
                [
                    "cod" => "147",
                    "sigla" => "REQ",
                    "nome" => "Requerimento",
                    "descricao" => ""
                ],
                [
                    "cod" => "148",
                    "sigla" => "RIC",
                    "nome" => "Requerimento de Informação",
                    "descricao" => "Requerimento de Informação (Art. 116, RICD)"
                ],
                [
                    "cod" => "150",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Convocação",
                    "descricao" => ""
                ],
                [
                    "cod" => "151",
                    "sigla" => "SIT",
                    "nome" => "Solicitação de Informação ao TCU",
                    "descricao" => "Solicitação de Informação ao TCU"
                ],
                [
                    "cod" => "153",
                    "sigla" => "TVR",
                    "nome" => "Ato de Concessão e Renovação de Concessão de Emissora de Rádio e Televisão",
                    "descricao" => "TVR"
                ],
                [
                    "cod" => "154",
                    "sigla" => "REC",
                    "nome" => "Recurso do Congresso Nacional",
                    "descricao" => "Recurso do Congresso Nacional"
                ],
                [
                    "cod" => "171",
                    "sigla" => "INA",
                    "nome" => "Indicação de Autoridade",
                    "descricao" => "Indicação de Autoridade"
                ],
                [
                    "cod" => "181",
                    "sigla" => "OF",
                    "nome" => "Ofício",
                    "descricao" => "Ofício"
                ],
                [
                    "cod" => "185",
                    "sigla" => "P.C",
                    "nome" => "Parecer (CD)",
                    "descricao" => "Parecer (CD)"
                ],
                [
                    "cod" => "187",
                    "sigla" => "PAR",
                    "nome" => "Parecer de Comissão",
                    "descricao" => "Parecer de Comissão"
                ],
                [
                    "cod" => "189",
                    "sigla" => "MAN",
                    "nome" => "Manifestação do Relator",
                    "descricao" => "Manifestação do Relator"
                ],
                [
                    "cod" => "190",
                    "sigla" => "PRL",
                    "nome" => "Parecer do Relator",
                    "descricao" => "Parecer Relator"
                ],
                [
                    "cod" => "191",
                    "sigla" => "PRV",
                    "nome" => "Parecer Vencedor",
                    "descricao" => "Parecer Vencedor"
                ],
                [
                    "cod" => "192",
                    "sigla" => "PPP",
                    "nome" => "Parecer Proferido em Plenário",
                    "descricao" => "Parecer Proferido em Plenário"
                ],
                [
                    "cod" => "193",
                    "sigla" => "PRR",
                    "nome" => "Parecer Reformulado",
                    "descricao" => "Parecer Reformulado"
                ],
                [
                    "cod" => "195",
                    "sigla" => "CVO",
                    "nome" => "Complementação de Voto",
                    "descricao" => "Complementação de Voto"
                ],
                [
                    "cod" => "196",
                    "sigla" => "PES",
                    "nome" => "Parecer às Emendas Apresentadas ao Substitutivo do Relator",
                    "descricao" => "Parecer às emendas apresentadas ao Substitutivo do Relator "
                ],
                [
                    "cod" => "197",
                    "sigla" => "RDF",
                    "nome" => "Redação Final",
                    "descricao" => "Redação Final"
                ],
                [
                    "cod" => "201",
                    "sigla" => "MAN",
                    "nome" => "Manifestação pela Prejudicialidade da Matéria",
                    "descricao" => "Manifestação pela Prejudicialidade da Matéria"
                ],
                [
                    "cod" => "202",
                    "sigla" => "MAN",
                    "nome" => "Manifestação pela Incompetência da Comissão",
                    "descricao" => "Manifestação pela Incompetência da Comissão"
                ],
                [
                    "cod" => "211",
                    "sigla" => "PRF",
                    "nome" => "Projeto de Resolução do Senado Federal",
                    "descricao" => "Projeto de Resolução do Senado Federal"
                ],
                [
                    "cod" => "246",
                    "sigla" => "CST",
                    "nome" => "Solicitação de Pronunciamento",
                    "descricao" => "CST"
                ],
                [
                    "cod" => "253",
                    "sigla" => "SGM",
                    "nome" => "Ofício da Mesa",
                    "descricao" => "Ofício da Mesa"
                ],
                [
                    "cod" => "254",
                    "sigla" => "DIS",
                    "nome" => "Discurso",
                    "descricao" => "Discurso"
                ],
                [
                    "cod" => "255",
                    "sigla" => "SBT",
                    "nome" => "Substitutivo",
                    "descricao" => "Substitutivo"
                ],
                [
                    "cod" => "256",
                    "sigla" => "SBE",
                    "nome" => "Subemenda",
                    "descricao" => "Subemenda"
                ],
                [
                    "cod" => "257",
                    "sigla" => "EMR",
                    "nome" => "Emenda de Relator",
                    "descricao" => "Emenda de Relator"
                ],
                [
                    "cod" => "258",
                    "sigla" => "ESB",
                    "nome" => "Emenda ao Substitutivo",
                    "descricao" => "Emenda ao Substitutivo"
                ],
                [
                    "cod" => "260",
                    "sigla" => "VTS",
                    "nome" => "Voto em Separado",
                    "descricao" => "Voto em Separado"
                ],
                [
                    "cod" => "261",
                    "sigla" => "DTQ",
                    "nome" => "Destaque",
                    "descricao" => "Destaque"
                ],
                [
                    "cod" => "262",
                    "sigla" => "REL",
                    "nome" => "Relatório de Subcomissão",
                    "descricao" => "Relatório de Subcomissão"
                ],
                [
                    "cod" => "263",
                    "sigla" => "DTN",
                    "nome" => "Destaque (CN)",
                    "descricao" => "Destaque de Bancada (CN) ou Destaque Simples (CN)"
                ],
                [
                    "cod" => "270",
                    "sigla" => "DVT",
                    "nome" => "Declaração de Voto",
                    "descricao" => "Declaração de Voto"
                ],
                [
                    "cod" => "273",
                    "sigla" => "EML",
                    "nome" => "Emenda à LDO",
                    "descricao" => "Emenda à LDO"
                ],
                [
                    "cod" => "276",
                    "sigla" => "SDL",
                    "nome" => "Sugestão de Emenda à LDO - CLP",
                    "descricao" => "Sugestão de Emenda à LDO"
                ],
                [
                    "cod" => "285",
                    "sigla" => "SUG",
                    "nome" => "Sugestão",
                    "descricao" => "Sugestão"
                ],
                [
                    "cod" => "286",
                    "sigla" => "SUM",
                    "nome" => "Súmula",
                    "descricao" => "Súmula"
                ],
                [
                    "cod" => "287",
                    "sigla" => "EMO",
                    "nome" => "Emenda ao Orçamento",
                    "descricao" => "Emenda ao Orçamento"
                ],
                [
                    "cod" => "288",
                    "sigla" => "SOA",
                    "nome" => "Sugestão de Emenda ao Orçamento - CLP",
                    "descricao" => "Sugestão de Emenda ao Orçamento"
                ],
                [
                    "cod" => "289",
                    "sigla" => "REL",
                    "nome" => "Relatório de CPI",
                    "descricao" => "Relatório de CPI"
                ],
                [
                    "cod" => "290",
                    "sigla" => "EMD",
                    "nome" => "Emenda",
                    "descricao" => "Emenda"
                ],
                [
                    "cod" => "291",
                    "sigla" => "MPV",
                    "nome" => "Medida Provisória",
                    "descricao" => "Medida Provisória"
                ],
                [
                    "cod" => "292",
                    "sigla" => "REL",
                    "nome" => "Relatório",
                    "descricao" => "Relatório"
                ],
                [
                    "cod" => "293",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Sessão Solene",
                    "descricao" => ""
                ],
                [
                    "cod" => "294",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Audiência Pública",
                    "descricao" => ""
                ],
                [
                    "cod" => "295",
                    "sigla" => "DEN",
                    "nome" => "Denúncia",
                    "descricao" => "Denúncia"
                ],
                [
                    "cod" => "296",
                    "sigla" => "",
                    "nome" => "D) PARECERES, MANIFESTAÇÕES E REDAÇÃO FINAL",
                    "descricao" => "E) PARECERES, MANIFESTAÇÕES E REDAÇÃO FINAL"
                ],
                [
                    "cod" => "297",
                    "sigla" => "",
                    "nome" => "C) EMENDAS (RICD Cap. V)",
                    "descricao" => "D) EMENDAS (RICD Cap. V)"
                ],
                [
                    "cod" => "298",
                    "sigla" => "",
                    "nome" => "H) OUTRAS PROPOSIÇÕES ACESSÓRIAS",
                    "descricao" => "OUTRAS PROPOSIÇÕES ACESSÓRIAS"
                ],
                [
                    "cod" => "299",
                    "sigla" => "",
                    "nome" => "E) REQUERIMENTOS (RICD Cap IV)",
                    "descricao" => "F) REQUERIMENTOS (RICD Cap IV)"
                ],
                [
                    "cod" => "301",
                    "sigla" => "",
                    "nome" => "A) PROPOSIÇÕES CF/88 Art. 59",
                    "descricao" => "A) PROPOSIÇÕES CF/88 Art. 59"
                ],
                [
                    "cod" => "302",
                    "sigla" => "",
                    "nome" => "B) PROPOSIÇÕES CF/88 Arts 58, 70 e 223, e RICD Art 100.",
                    "descricao" => "B) PROPOSIÇÕES CF/88 Arts 58, 70 e 233, e RICD Art 100."
                ],
                [
                    "cod" => "303",
                    "sigla" => "",
                    "nome" => "F) SUGESTÕES",
                    "descricao" => "G) SUGESTÕES"
                ],
                [
                    "cod" => "304",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Apensação",
                    "descricao" => "Ar. 142, RICD"
                ],
                [
                    "cod" => "305",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Desapensação",
                    "descricao" => ""
                ],
                [
                    "cod" => "306",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Audiência solicitada por Deputado",
                    "descricao" => ""
                ],
                [
                    "cod" => "307",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Audiência solicitada por Comissão ou Deputado",
                    "descricao" => ""
                ],
                [
                    "cod" => "308",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Redistribuição",
                    "descricao" => ""
                ],
                [
                    "cod" => "310",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão ou Retirada de Assinatura em Proposição de Iniciativa Coletiva Obrigatória",
                    "descricao" => ""
                ],
                [
                    "cod" => "311",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada de Proposição de Iniciativa Individual",
                    "descricao" => ""
                ],
                [
                    "cod" => "312",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada de Proposição de Iniciativa Coletiva",
                    "descricao" => ""
                ],
                [
                    "cod" => "313",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão ou Retirada de Assinatura em Proposição de Iniciativa Individual",
                    "descricao" => ""
                ],
                [
                    "cod" => "314",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Envio de proposições pendentes de parecer à Comissão seguinte ou ao Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "315",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada do requerimento de urgência (matéria com requerimento apresentado e não votado)",
                    "descricao" => ""
                ],
                [
                    "cod" => "316",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada do requerimento de informação",
                    "descricao" => ""
                ],
                [
                    "cod" => "317",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Constituição de Comissão Parlamentar de Inquerito (CPI)",
                    "descricao" => ""
                ],
                [
                    "cod" => "318",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão na Ordem do Dia",
                    "descricao" => "Inclusão na Ordem do Dia (Art. 135 c/c 114, XIV, RICD)"
                ],
                [
                    "cod" => "319",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada de proposição",
                    "descricao" => "Retirada de proposição com parecer (Art. 104, c/c art. 114, V e VII, RICD)"
                ],
                [
                    "cod" => "321",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Extinção do regime de urgência (matéria com urgência votada)",
                    "descricao" => "Extinção do regime de urgência (Art. 156, c/c art. 104, RICD)"
                ],
                [
                    "cod" => "322",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Tramitação de proposição em regime de prioridade",
                    "descricao" => ""
                ],
                [
                    "cod" => "323",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Quebra de Interstício para Inclusão de Matéria na Ordem do Dia",
                    "descricao" => "Dispensa de interstício para inclusão na Ordem do Dia (Art. 150, § único, RICD)"
                ],
                [
                    "cod" => "324",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Destaque para votação em separado de parte de proposição (DVS)",
                    "descricao" => ""
                ],
                [
                    "cod" => "327",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Retirada da OD de proposições com pareceres favoraveis",
                    "descricao" => ""
                ],
                [
                    "cod" => "328",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Retirada de Pauta",
                    "descricao" => "Retirada da OD de proposição nela incluída (Art. 117, VI, RICD)"
                ],
                [
                    "cod" => "329",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Adiamento da Discussão",
                    "descricao" => "Adiamento de discussão nos termos do art. 177, c/c art. 101, II,2, RICD."
                ],
                [
                    "cod" => "330",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Dispensa da Discussão",
                    "descricao" => "Dispensa da discussão (Art. 101, II, 2, RICD)"
                ],
                [
                    "cod" => "331",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Encerramento da Discussão",
                    "descricao" => "Encerramento de discussão (Art. 178, § 2º, c/c art. 101, II, 2, RICD)"
                ],
                [
                    "cod" => "332",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Votação pelo Processo Nominal",
                    "descricao" => "Votação por determinado processo (Art. 101, II, 3, c/c art. 189, § 3º, RICD)"
                ],
                [
                    "cod" => "333",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Votação parcelada da proposição",
                    "descricao" => "Votação em globo ou parcelada (Art. 101, II, 3, c/c art. 189, § 3º RICD)"
                ],
                [
                    "cod" => "334",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Verificação de Votação",
                    "descricao" => "Verificação de votação (Art. art. 185, §5º, RICD)"
                ],
                [
                    "cod" => "335",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Votação por escrutínio secreto",
                    "descricao" => "Votação por escrutínio secreto (Art. 188, II, RICD)"
                ],
                [
                    "cod" => "336",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Adiamento da Votação",
                    "descricao" => "Adiamento da votação nos termos do Art. 193º c/c 117, X do RICD."
                ],
                [
                    "cod" => "337",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Preferência",
                    "descricao" => "Preferência para votação ou discussão de uma proposição (Art. 160, RICD)"
                ],
                [
                    "cod" => "338",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Dispensa do Avulso da Redação Final",
                    "descricao" => ""
                ],
                [
                    "cod" => "339",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Reconstituição de proposição",
                    "descricao" => ""
                ],
                [
                    "cod" => "340",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão na Ordem do Dia de proposição (Durante o período ordinário)",
                    "descricao" => ""
                ],
                [
                    "cod" => "341",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Publicação de Parecer de Comissão aprovado",
                    "descricao" => ""
                ],
                [
                    "cod" => "342",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Reabertura de discussão de projeto de Sessão Legislativa anterior",
                    "descricao" => ""
                ],
                [
                    "cod" => "343",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Transformação de Sessão Plenária em Comissão Geral",
                    "descricao" => ""
                ],
                [
                    "cod" => "344",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retificação de Ata",
                    "descricao" => ""
                ],
                [
                    "cod" => "345",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Prorrogação de sessão",
                    "descricao" => "Prorrogação de sessão (Art. 72, RICD)"
                ],
                [
                    "cod" => "346",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Prorrogação da Ordem do Dia",
                    "descricao" => "Prorrogação da Ordem do Dia (Art. 84, RICD)"
                ],
                [
                    "cod" => "347",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Convocação de Sessões Extraordinarias para matérias constantes do ato de convocação",
                    "descricao" => ""
                ],
                [
                    "cod" => "348",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Prorrogação de prazo de Comissão Temporária",
                    "descricao" => ""
                ],
                [
                    "cod" => "349",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Constituição de Comissão Externa",
                    "descricao" => ""
                ],
                [
                    "cod" => "350",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Realização de Sessão Extraordinária",
                    "descricao" => ""
                ],
                [
                    "cod" => "351",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Realização de Sessão secreta",
                    "descricao" => ""
                ],
                [
                    "cod" => "353",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Não realização de sessão solene em determinado dia",
                    "descricao" => ""
                ],
                [
                    "cod" => "354",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Voto de regozijo ou louvor",
                    "descricao" => ""
                ],
                [
                    "cod" => "355",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Voto de pesar",
                    "descricao" => ""
                ],
                [
                    "cod" => "356",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Convocação de Ministro de Estado no Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "357",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Quebra de sigilo (Requerimentos não especificados no RICD",
                    "descricao" => ""
                ],
                [
                    "cod" => "358",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Encaminha copia de Relatorio Final de C. Temporaria ",
                    "descricao" => ""
                ],
                [
                    "cod" => "359",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Constituição de Comissão Especial de PEC",
                    "descricao" => ""
                ],
                [
                    "cod" => "360",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inserção nos Anais",
                    "descricao" => ""
                ],
                [
                    "cod" => "361",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Publicação de documentos discursos de outro poder nao lidos na integra por deputado",
                    "descricao" => ""
                ],
                [
                    "cod" => "362",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Adocão de providências em face da ausência de resposta no prazo constitucional a RIC",
                    "descricao" => "Art. 50, § 2º da CF c/c art. 105, RICD."
                ],
                [
                    "cod" => "363",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Desarquivamento de Proposições",
                    "descricao" => ""
                ],
                [
                    "cod" => "364",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Afastamento para tratamento de saude superior a 120 dias.",
                    "descricao" => "Art. 235, II, RICD."
                ],
                [
                    "cod" => "365",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Afastamento para tratamento de saúde inferior a 120 dias.",
                    "descricao" => "Art. 235, II, RICD."
                ],
                [
                    "cod" => "366",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Afastamento por licença de saude e consecutivamente afastamento para tratar de assunto particular superior a 120 dias.",
                    "descricao" => "Art. 235, II e III, RICD."
                ],
                [
                    "cod" => "368",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Afastamento para investidura em cargo publico",
                    "descricao" => "Art. 56, inciso I da CF c/c com art. 235, IV, RICD."
                ],
                [
                    "cod" => "369",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Prorrogação de licença para tratamento de saúde (licença superior a 120 dias)",
                    "descricao" => ""
                ],
                [
                    "cod" => "370",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Interrupção da licença superior a 120 dias",
                    "descricao" => ""
                ],
                [
                    "cod" => "371",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Justificativa de falta",
                    "descricao" => ""
                ],
                [
                    "cod" => "372",
                    "sigla" => "REC",
                    "nome" => "Recurso contra devolução de requerimento de CPI (Art. 35, § 2º, RICD)",
                    "descricao" => "Contra devolução de requerimento de CPI (Art. 35, § 1º, RICD)"
                ],
                [
                    "cod" => "373",
                    "sigla" => "REC",
                    "nome" => "Recurso contra apreciação conclusiva de comissão (Art. 58, § 1º c/c art. 132, § 2º, RICD)",
                    "descricao" => "Contra apreciação conclusiva de comissão (Art. 58, § 1º, RICD)"
                ],
                [
                    "cod" => "374",
                    "sigla" => "REC",
                    "nome" => "Recurso contra apreciação conclusiva com pareceres contrarios (Art. 133, RICD)",
                    "descricao" => "Contra apreciação conclusiva com pareceres contrarios (Art. 133, RICD)"
                ],
                [
                    "cod" => "375",
                    "sigla" => "REC",
                    "nome" => "Recurso contra parecer terminativo de comissão (Art. 132, § 2º c/c art. 144, caput, RICD)",
                    "descricao" => "Contra parecer terminativo de comissão (Art. 132, § 2º c/c art. 144, caput, RICD)"
                ],
                [
                    "cod" => "376",
                    "sigla" => "REC",
                    "nome" => "Recurso contra devolução de proposição (Art. 137, § 2º, RICD)",
                    "descricao" => "Contra devolução de proposição (Art. 137, § 2º, RICD)"
                ],
                [
                    "cod" => "377",
                    "sigla" => "REC",
                    "nome" => "Recurso contra deferimento/indeferimento de audiencia (Art. 140, I, RICD)",
                    "descricao" => "Contra deferimento/indeferimento de audiencia (Art. 140, I, RICD)"
                ],
                [
                    "cod" => "378",
                    "sigla" => "REC",
                    "nome" => "Recurso contra redistribuição de proposição (Art. 141, RICD)",
                    "descricao" => "Contra redistribuição de proposição (Art. 141, § 4º, RICD)"
                ],
                [
                    "cod" => "379",
                    "sigla" => "REC",
                    "nome" => "Recurso contra apensação/desapensação de proposição (Art. 142, I, RICD)",
                    "descricao" => "Contra apensação/desapensação de proposição (Art. 142, I, RICD)"
                ],
                [
                    "cod" => "380",
                    "sigla" => "REC",
                    "nome" => "Recurso contra deferimento/indeferimento retirada proposição (Art. 104, caput, RICD)",
                    "descricao" => "Contra deferimento/indeferimento retirada proposição (Art. 104, caput, RICD)"
                ],
                [
                    "cod" => "381",
                    "sigla" => "REC",
                    "nome" => "Recurso contra declaração de prejudicialidade. (Art. 164, § 2º, RICD)",
                    "descricao" => "Contra declaração de prejudicialidade. (Art. 164, § 2º, RICD)"
                ],
                [
                    "cod" => "382",
                    "sigla" => "REC",
                    "nome" => "Recurso contra decisão do Presidente da CD em Questao de Ordem (Art. 95, § 8º, RICD)",
                    "descricao" => "Contra decisão do Presidente da CD em Questao de Ordem (Art. 95, § 8º, RICD)"
                ],
                [
                    "cod" => "383",
                    "sigla" => "REC",
                    "nome" => "Recurso contra decisão de Presidente de Comissão em Questão de Ordem (Art. 57, XXI c/c art. 17, III, f, RICD)",
                    "descricao" => "Contra decisão de Presidente de Comissão em Questão de Ordem (Art. 57, XXI c/c art. 17, III, f, RICD)"
                ],
                [
                    "cod" => "384",
                    "sigla" => "REC",
                    "nome" => "Recurso contra indeferimento de Requerimento de Infomação (Art. 115, parágrafo único, RICD)",
                    "descricao" => "Contra indeferimento de Requerimento de Infomação (Art. 115, parágrafo único, RICD)"
                ],
                [
                    "cod" => "385",
                    "sigla" => "REC",
                    "nome" => "Recurso contra nao recebimento de emenda (Art. 125, caput, RICD)",
                    "descricao" => "Contra nao recebimento de emenda (Art. 125, caput, RICD)"
                ],
                [
                    "cod" => "386",
                    "sigla" => "REC",
                    "nome" => "Recurso contra improcedencia de retificação de ata (Art. 80, § 1º, RICD)",
                    "descricao" => "Contra improcedencia de retificação de ata (Art. 80, § 1º, RICD)"
                ],
                [
                    "cod" => "387",
                    "sigla" => "REC",
                    "nome" => "Recurso contra indeferimento de requerimento para publicação em ata (Art. 98, § 3º, RICD)",
                    "descricao" => "Contra indeferimento de requerimento para publicação em ata (Art. 98, § 3º, RICD)"
                ],
                [
                    "cod" => "388",
                    "sigla" => "REC",
                    "nome" => "Recurso contra a não publicação de pronunciamento ou expressão (Art. 98, 6º, RICD)",
                    "descricao" => "Contra a não publicação de pronunciamento ou expressão (Art. 98, 6º, RICD)"
                ],
                [
                    "cod" => "389",
                    "sigla" => "REC",
                    "nome" => "Recurso contra nao recebimento de denuncia crime responsabilidade (Art. 218, § 3º, RICD)",
                    "descricao" => "Contra nao recebimento de denuncia crime responsabilidade (Art. 218, § 3º, RICD)"
                ],
                [
                    "cod" => "390",
                    "sigla" => "PLV",
                    "nome" => "Projeto de Lei de Conversão",
                    "descricao" => "Projeto de Lei de Conversão"
                ],
                [
                    "cod" => "391",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Urgência (Art. 154, II, do RICD)",
                    "descricao" => "Urgencia (Art. 154 do RICD)"
                ],
                [
                    "cod" => "392",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Urgência (Art. 155 do RICD)",
                    "descricao" => "Urgência (Art. 155 do RICD)"
                ],
                [
                    "cod" => "393",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Adiamento de discussão em regime de urgência",
                    "descricao" => "Aditamento de discussão em regime de urgência nos termos do art. 177, §1º do RICD."
                ],
                [
                    "cod" => "394",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Medida Provisória",
                    "descricao" => "Medida Provisória (Art. 62, § 3º da CF)"
                ],
                [
                    "cod" => "395",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Referendo ou Plebiscito",
                    "descricao" => "Plebiscito (Art. 49, XV da CF c/c o art. 3º Lei 9.709/98)"
                ],
                [
                    "cod" => "396",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Concessão, Renovação e Permissão de Radio/TV",
                    "descricao" => "Concessão/Renovação de Radio/TV (Art. 49, XII c/c 223 da CF)"
                ],
                [
                    "cod" => "397",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Acordos, tratados ou atos internacionais",
                    "descricao" => "Acordos, tratados ou atos internacionais (Art. 49, I da CF)"
                ],
                [
                    "cod" => "398",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Indicação de Autoridade ao TCU",
                    "descricao" => "Indicação de Autoridade ao TCU (Art. 49, XIII da CF)"
                ],
                [
                    "cod" => "400",
                    "sigla" => "PRC",
                    "nome" => "Projeto de Resolução de Criação de CPI",
                    "descricao" => "Criação de CPI (Art. 35 do RICD)"
                ],
                [
                    "cod" => "401",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Concessão ou Renovação de Rádio e TV ",
                    "descricao" => "Concessão de Rádio e TV (Art. 49, XII c/c 223 CF)"
                ],
                [
                    "cod" => "402",
                    "sigla" => "REC",
                    "nome" => "Recurso contra aplicação de censura verbal (Art. 11, Parágrafo único do CEDP)",
                    "descricao" => "Contra aplicação de censura verbal (Art. 11, Parágrafo único do CEDP)"
                ],
                [
                    "cod" => "403",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Comunica ausência do país",
                    "descricao" => "Comunica ausência do país"
                ],
                [
                    "cod" => "404",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Cancelamento de Urgência",
                    "descricao" => "Cancelamento de Urgência"
                ],
                [
                    "cod" => "405",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Retirada de proposição",
                    "descricao" => "Retirada de proposição"
                ],
                [
                    "cod" => "406",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Solicitação de urgência ",
                    "descricao" => "Solicitação de urgência "
                ],
                [
                    "cod" => "407",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Programação Monetária",
                    "descricao" => "Programação Monetária (Lei nº 9.069/95)"
                ],
                [
                    "cod" => "408",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Sustação de Atos Normativos do Poder Executivo",
                    "descricao" => "Susta atos normativos do Poder Executivo."
                ],
                [
                    "cod" => "409",
                    "sigla" => "AV",
                    "nome" => "Demonstrativo de emissão do real",
                    "descricao" => "Demonstrativo de emissão do real (Lei nº 9.069/95)"
                ],
                [
                    "cod" => "410",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Indicação de Líder",
                    "descricao" => "Indicação de Líder"
                ],
                [
                    "cod" => "411",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Acordos, convênios, tratados e atos internacionais",
                    "descricao" => "Acordos, convênios, tratados e atos internacionais"
                ],
                [
                    "cod" => "412",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Restituição de Autógrafos",
                    "descricao" => "Restituição de Autógrafos"
                ],
                [
                    "cod" => "413",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada de proposição sem parecer",
                    "descricao" => ""
                ],
                [
                    "cod" => "414",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de ausência do país por mais de 15 dias ",
                    "descricao" => "Mensagem de ausência do país por mais de 15 dias (Art. 49, III, CF)"
                ],
                [
                    "cod" => "415",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de ausência do país por menos de 15 dias  ",
                    "descricao" => "Mensagem de ausência do país por menos de 15 dias  (Art. 49, III, CF)"
                ],
                [
                    "cod" => "417",
                    "sigla" => "TVR",
                    "nome" => "Autorização - Rádio Comunitária",
                    "descricao" => "Autorização - Rádio Comunitária"
                ],
                [
                    "cod" => "418",
                    "sigla" => "TVR",
                    "nome" => "Concessão - Rádio Ondas Curtas",
                    "descricao" => "Concessão - Rádio Ondas Curtas"
                ],
                [
                    "cod" => "419",
                    "sigla" => "TVR",
                    "nome" => "Concessão - Rádio Ondas Médias",
                    "descricao" => "Concessão - Rádio Ondas Médias"
                ],
                [
                    "cod" => "420",
                    "sigla" => "TVR",
                    "nome" => "Concessão Rádio Ondas Médias Educativa",
                    "descricao" => "Concessão Rádio Ondas Médias Educativa"
                ],
                [
                    "cod" => "421",
                    "sigla" => "TVR",
                    "nome" => "Concessão Rádio Ondas Tropicais",
                    "descricao" => "Concessão Rádio Ondas Tropocais"
                ],
                [
                    "cod" => "422",
                    "sigla" => "TVR",
                    "nome" => "Concessão Radiodifusão Sons e Imagens",
                    "descricao" => "Concessão Radiodifusão Sons e Imagens"
                ],
                [
                    "cod" => "423",
                    "sigla" => "TVR",
                    "nome" => "Concessão TV Educativa",
                    "descricao" => "Concessão TV Educativa"
                ],
                [
                    "cod" => "424",
                    "sigla" => "TVR",
                    "nome" => "Permissão Frequência Modulada Educativa",
                    "descricao" => "Permissão Frequência Modulada Educativa"
                ],
                [
                    "cod" => "425",
                    "sigla" => "TVR",
                    "nome" => "Permissão Rádio Frequência Modulada",
                    "descricao" => "Permissão Rádio Frequência Modulada"
                ],
                [
                    "cod" => "426",
                    "sigla" => "TVR",
                    "nome" => "Permissão Rádio Ondas Médias Local",
                    "descricao" => "Permissão Rádio Ondas Médias Local"
                ],
                [
                    "cod" => "427",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Comunitária",
                    "descricao" => "Renovação Rádio Comunitária"
                ],
                [
                    "cod" => "428",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Frequência Modulada",
                    "descricao" => "Renovação Rádio Frequência Modulada"
                ],
                [
                    "cod" => "429",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Frequência Modulada Educativa",
                    "descricao" => "Renovação Rádio Frequência Modulada Educativa"
                ],
                [
                    "cod" => "430",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Ondas Curtas",
                    "descricao" => "Renovação Rádio Ondas Curtas"
                ],
                [
                    "cod" => "431",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Ondas Médias",
                    "descricao" => "Renovação Rádio Ondas Médias"
                ],
                [
                    "cod" => "432",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Ondas Médias Local",
                    "descricao" => "Renovação Rádio Ondas Médias Local"
                ],
                [
                    "cod" => "433",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Ondas Médias Educativa",
                    "descricao" => "Renovação Rádio Ondas Médias Educativa"
                ],
                [
                    "cod" => "434",
                    "sigla" => "TVR",
                    "nome" => "Renovação Rádio Ondas Tropicais",
                    "descricao" => "Renovação  Rádio Ondas Tropicais"
                ],
                [
                    "cod" => "435",
                    "sigla" => "TVR",
                    "nome" => "Renovação TV Sons e Imagens",
                    "descricao" => "Renovação TV Sons e Imagens"
                ],
                [
                    "cod" => "436",
                    "sigla" => "TVR",
                    "nome" => "Renovação TV Educativa",
                    "descricao" => "Renovação TV Educativa"
                ],
                [
                    "cod" => "437",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Cumprimento de meta",
                    "descricao" => "Cumprimento de meta"
                ],
                [
                    "cod" => "439",
                    "sigla" => "DCR",
                    "nome" => "Denúncia por Crime de Responsabilidade",
                    "descricao" => "Denúncia por crime de responsabilidade"
                ],
                [
                    "cod" => "440",
                    "sigla" => "",
                    "nome" => "J) NÃO PROPOSIÇÃO",
                    "descricao" => "Não Proposição"
                ],
                [
                    "cod" => "441",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Moção",
                    "descricao" => ""
                ],
                [
                    "cod" => "442",
                    "sigla" => "PEP",
                    "nome" => "Parecer às Emendas de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "443",
                    "sigla" => "PSS",
                    "nome" => "Parecer às Emendas ou ao Substitutivo do Senado",
                    "descricao" => ""
                ],
                [
                    "cod" => "444",
                    "sigla" => "PRC",
                    "nome" => "Projeto de Resolução de Alteração do Regimento e outros",
                    "descricao" => ""
                ],
                [
                    "cod" => "445",
                    "sigla" => "NIC",
                    "nome" => "Norma Interna",
                    "descricao" => ""
                ],
                [
                    "cod" => "448",
                    "sigla" => "REQ",
                    "nome" => "Requerimento não previsto",
                    "descricao" => ""
                ],
                [
                    "cod" => "449",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Implementação da Lei 10.147/00",
                    "descricao" => ""
                ],
                [
                    "cod" => "450",
                    "sigla" => "ERD",
                    "nome" => "Emenda de Redação",
                    "descricao" => ""
                ],
                [
                    "cod" => "451",
                    "sigla" => "PPR",
                    "nome" => "Parecer Reformulado de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "452",
                    "sigla" => "TER",
                    "nome" => "Termo de Implementação",
                    "descricao" => ""
                ],
                [
                    "cod" => "453",
                    "sigla" => "RLP",
                    "nome" => "Relatório Prévio",
                    "descricao" => ""
                ],
                [
                    "cod" => "454",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Perempção da Concessão",
                    "descricao" => ""
                ],
                [
                    "cod" => "455",
                    "sigla" => "RLF",
                    "nome" => "Relatório Final",
                    "descricao" => ""
                ],
                [
                    "cod" => "456",
                    "sigla" => "PRT",
                    "nome" => "Parecer Técnico",
                    "descricao" => ""
                ],
                [
                    "cod" => "457",
                    "sigla" => "PRO",
                    "nome" => "Proposta",
                    "descricao" => ""
                ],
                [
                    "cod" => "459",
                    "sigla" => "REC",
                    "nome" => "Recurso contra decisão de presidente de Comissão em Reclamação (Art. 96, § 2º, RICD)",
                    "descricao" => ""
                ],
                [
                    "cod" => "460",
                    "sigla" => "OBJ",
                    "nome" => "Objeto de Deliberação",
                    "descricao" => ""
                ],
                [
                    "cod" => "461",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Missão de Paz (Art. 15 da LC 97/99)",
                    "descricao" => "Art. 15 da Lei Complementar nº 97/99"
                ],
                [
                    "cod" => "462",
                    "sigla" => "",
                    "nome" => "I) OUTROS ITENS SUJEITOS À DELIBERAÇÃO",
                    "descricao" => ""
                ],
                [
                    "cod" => "463",
                    "sigla" => "",
                    "nome" => "G) PROPOSIÇÔES CN E SF TRAMITANDO NA CÂMARA (CMO E MERCOSUL)",
                    "descricao" => ""
                ],
                [
                    "cod" => "464",
                    "sigla" => "PLS",
                    "nome" => "Projeto de Lei do Senado Federal",
                    "descricao" => ""
                ],
                [
                    "cod" => "465",
                    "sigla" => "PLC",
                    "nome" => "Projeto de Lei da Câmara dos Deputados (SF)",
                    "descricao" => ""
                ],
                [
                    "cod" => "466",
                    "sigla" => "PDS",
                    "nome" => "Projeto de Decreto Legislativo (SF)",
                    "descricao" => ""
                ],
                [
                    "cod" => "467",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Adiamento de Votação de Matéria Urgente",
                    "descricao" => "Adiamento de Votação em Regime de Urgência, nos termos do art. 177, § 1º do RICD."
                ],
                [
                    "cod" => "468",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Encerramento de discussão em Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "482",
                    "sigla" => "RDV",
                    "nome" => "Redação do Vencido",
                    "descricao" => ""
                ],
                [
                    "cod" => "483",
                    "sigla" => "RST",
                    "nome" => "Redação para o segundo turno",
                    "descricao" => ""
                ],
                [
                    "cod" => "484",
                    "sigla" => "RLP(R)",
                    "nome" => "Relatório Prévio Reformulado",
                    "descricao" => ""
                ],
                [
                    "cod" => "485",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Aprovação de Contas dos Presidentes",
                    "descricao" => ""
                ],
                [
                    "cod" => "486",
                    "sigla" => "RPD",
                    "nome" => "Requerimento Procedimental de Sessão/Reunião",
                    "descricao" => ""
                ],
                [
                    "cod" => "487",
                    "sigla" => "EPP",
                    "nome" => "Emenda ao Plano Plurianual",
                    "descricao" => "Emenda ao Plano Plurianual"
                ],
                [
                    "cod" => "488",
                    "sigla" => "EAG",
                    "nome" => "Emenda Substitutiva Aglutinativa Global",
                    "descricao" => ""
                ],
                [
                    "cod" => "489",
                    "sigla" => "MSC",
                    "nome" => "Mensagem que Propõe alteração a Projeto",
                    "descricao" => ""
                ],
                [
                    "cod" => "490",
                    "sigla" => "PEA",
                    "nome" => "Parecer à Emenda Aglutinativa",
                    "descricao" => ""
                ],
                [
                    "cod" => "491",
                    "sigla" => "SPA",
                    "nome" => "Sugestão de Emenda ao PPA - CLP",
                    "descricao" => ""
                ],
                [
                    "cod" => "492",
                    "sigla" => "TVR",
                    "nome" => "Autorização - Rádio Comunitária - Dez anos",
                    "descricao" => "Autorização - Rádio Comunitária - Dez anos"
                ],
                [
                    "cod" => "493",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Perempção de Rádio/TV",
                    "descricao" => ""
                ],
                [
                    "cod" => "494",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Alteração de Decreto Legislativo",
                    "descricao" => ""
                ],
                [
                    "cod" => "495",
                    "sigla" => "AV",
                    "nome" => "Aviso",
                    "descricao" => ""
                ],
                [
                    "cod" => "496",
                    "sigla" => "IAN",
                    "nome" => "Indicação da ANC (1987-88)",
                    "descricao" => ""
                ],
                [
                    "cod" => "497",
                    "sigla" => "OF",
                    "nome" => "Ofício Externo",
                    "descricao" => ""
                ],
                [
                    "cod" => "498",
                    "sigla" => "PCA",
                    "nome" => "Parecer da ANC (1987-88)",
                    "descricao" => ""
                ],
                [
                    "cod" => "499",
                    "sigla" => "PDA",
                    "nome" => "Projeto de Decisão da ANC (1987-88)",
                    "descricao" => ""
                ],
                [
                    "cod" => "500",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Autorização do Congresso Nacional",
                    "descricao" => ""
                ],
                [
                    "cod" => "501",
                    "sigla" => "PRA",
                    "nome" => "Projeto de Resolução da ANC (1987-88)",
                    "descricao" => ""
                ],
                [
                    "cod" => "503",
                    "sigla" => "RCM",
                    "nome" => "Requerimento de Comissão Mista",
                    "descricao" => ""
                ],
                [
                    "cod" => "504",
                    "sigla" => "RQA",
                    "nome" => "Requerimento de Informações da ANC (1987-88)",
                    "descricao" => ""
                ],
                [
                    "cod" => "505",
                    "sigla" => "RQC",
                    "nome" => "Requerimento de Convocação",
                    "descricao" => ""
                ],
                [
                    "cod" => "506",
                    "sigla" => "AA",
                    "nome" => "Autógrafo",
                    "descricao" => ""
                ],
                [
                    "cod" => "507",
                    "sigla" => "REC",
                    "nome" => "Recurso contra Inadmissibilidade de PEC (Art. 202, § 1º do RICD)",
                    "descricao" => ""
                ],
                [
                    "cod" => "508",
                    "sigla" => "ESP",
                    "nome" => "Emenda Substitutiva de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "509",
                    "sigla" => "SSP",
                    "nome" => "Subemenda Substitutiva de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "513",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Implementação da Lei 10.707/03",
                    "descricao" => ""
                ],
                [
                    "cod" => "514",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Ministro do TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "515",
                    "sigla" => "",
                    "nome" => "K) PROPOSIÇÕES INATIVAS IMPORTADAS SINOPSE",
                    "descricao" => ""
                ],
                [
                    "cod" => "516",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão na Ordem do Dia de proposição (com previsão ou durante o período de Convocação Extraordinário)",
                    "descricao" => ""
                ],
                [
                    "cod" => "517",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Interrupção da licença inferior a 120 dias",
                    "descricao" => ""
                ],
                [
                    "cod" => "518",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Votação em globo dos destaques simples",
                    "descricao" => ""
                ],
                [
                    "cod" => "519",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Afastamento paramissão temporária de caráter diplomático ou cultural",
                    "descricao" => ""
                ],
                [
                    "cod" => "520",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Constituição de Comissão Especial de Projeto de Código",
                    "descricao" => ""
                ],
                [
                    "cod" => "521",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Constituição de Comissão Especial de Projeto",
                    "descricao" => ""
                ],
                [
                    "cod" => "522",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Constituição de Comissão Especial de Estudo",
                    "descricao" => ""
                ],
                [
                    "cod" => "523",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Convocação de Ministro de Estado na Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "524",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Convocação de Sessão Extraordinária do CN",
                    "descricao" => ""
                ],
                [
                    "cod" => "525",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Convocação de reunião extraordinária de comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "526",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Destaque votação de emenda ou parte",
                    "descricao" => ""
                ],
                [
                    "cod" => "527",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Destaque para votação de subemenda ou parte",
                    "descricao" => ""
                ],
                [
                    "cod" => "528",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Destaque para tornar parte de emenda ou proposição projeto autonomo",
                    "descricao" => ""
                ],
                [
                    "cod" => "529",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Destaque para votação de projeto ou substitutivo ou parte deles quando a preferencia cair sobre outro ou sobre proposições apensadas",
                    "descricao" => ""
                ],
                [
                    "cod" => "530",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Destaque para votação de parte da proposição",
                    "descricao" => ""
                ],
                [
                    "cod" => "531",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Prorrogação da sessão para discussão e votação da matéria da Ordem do Dia",
                    "descricao" => ""
                ],
                [
                    "cod" => "532",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Prorrogação da sessão para audiência de Ministro de Estado",
                    "descricao" => ""
                ],
                [
                    "cod" => "533",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Prorrogação da sessão para realização de homenagens",
                    "descricao" => ""
                ],
                [
                    "cod" => "534",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Prorrogação de licença para tratamento de saúde (Licença inferior a 120 dias)",
                    "descricao" => ""
                ],
                [
                    "cod" => "535",
                    "sigla" => "MMP",
                    "nome" => "Mensagem (MPU)",
                    "descricao" => ""
                ],
                [
                    "cod" => "536",
                    "sigla" => "RIN",
                    "nome" => "Requerimento de Resolução Interna",
                    "descricao" => ""
                ],
                [
                    "cod" => "537",
                    "sigla" => "MST",
                    "nome" => "Mensagem (STF)",
                    "descricao" => ""
                ],
                [
                    "cod" => "538",
                    "sigla" => "APJ",
                    "nome" => "Anteprojeto",
                    "descricao" => ""
                ],
                [
                    "cod" => "539",
                    "sigla" => "RQN",
                    "nome" => "Requerimento do Congresso Nacional",
                    "descricao" => "Solicitação feita pela Claudia da SGM em 30/05/2005 as 18=>14 (Incluído por MarcoRuas).\r\nRequerimento do Congresso nacional que servirá de suporte aos recursos R.C (novos recursos). "
                ],
                [
                    "cod" => "540",
                    "sigla" => "R.C",
                    "nome" => "Recurso do Congresso Nacional",
                    "descricao" => "Solicitação feita pela Claudia da SGM em 30/05/2005 as 18=>14 (Incluído por MarcoRuas).\r\nOs recursos existente em RCN serão transferidos para este novo código."
                ],
                [
                    "cod" => "541",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Tranferência de Controle Societário",
                    "descricao" => ""
                ],
                [
                    "cod" => "550",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo",
                    "descricao" => "Projeto de Decreto Legislativo"
                ],
                [
                    "cod" => "551",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Medida Provisória",
                    "descricao" => "Medida Provisória (Art. 62, § 3º da CF)"
                ],
                [
                    "cod" => "552",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Referendo ou Plebiscito",
                    "descricao" => "Plebiscito (Art. 49, XV da CF c/c o art. 3º Lei 9.709/98)"
                ],
                [
                    "cod" => "553",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Concessão, Renovação e Permissão de Radio/TV",
                    "descricao" => "Concessão/Renovação de Radio/TV (Art. 49, XII c/c 223 da CF)"
                ],
                [
                    "cod" => "554",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Acordos, tratados ou atos internacionais",
                    "descricao" => "Acordos, tratados ou atos internacionais (Art. 49, I da CF)"
                ],
                [
                    "cod" => "555",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Indicação de Autoridade ao TCU",
                    "descricao" => "Indicação de Autoridade ao TCU (Art. 49, XIII da CF)"
                ],
                [
                    "cod" => "556",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Programação Monetária",
                    "descricao" => "Programação Monetária (Lei nº 9.069/95)"
                ],
                [
                    "cod" => "557",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Sustação de Atos Normativos do Poder Executivo",
                    "descricao" => "Susta atos normativos do Poder Executivo."
                ],
                [
                    "cod" => "558",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Perempção da Concessão",
                    "descricao" => ""
                ],
                [
                    "cod" => "559",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Aprovação de Contas dos Presidentes",
                    "descricao" => ""
                ],
                [
                    "cod" => "560",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Alteração de Decreto Legislativo",
                    "descricao" => ""
                ],
                [
                    "cod" => "561",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Autorização do Congresso Nacional",
                    "descricao" => ""
                ],
                [
                    "cod" => "562",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Ministro do TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "563",
                    "sigla" => "PDL",
                    "nome" => "Projeto de Decreto Legislativo de Perempção",
                    "descricao" => ""
                ],
                [
                    "cod" => "600",
                    "sigla" => "CCN",
                    "nome" => "Consulta do Congresso Nacional",
                    "descricao" => "Solicitação feita pela Claudia da SGM em 31/05/2005 as 14=>30 (Incluído por MarceloLapa).\r\n"
                ],
                [
                    "cod" => "601",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo de Perempção",
                    "descricao" => ""
                ],
                [
                    "cod" => "602",
                    "sigla" => "MSC",
                    "nome" => "Mensagem Revogação ou Anulação de Portaria",
                    "descricao" => ""
                ],
                [
                    "cod" => "603",
                    "sigla" => "ADD",
                    "nome" => "Adendo",
                    "descricao" => ""
                ],
                [
                    "cod" => "604",
                    "sigla" => "DEC",
                    "nome" => "Decisão",
                    "descricao" => ""
                ],
                [
                    "cod" => "605",
                    "sigla" => "ATC",
                    "nome" => "Ato Convocatório",
                    "descricao" => ""
                ],
                [
                    "cod" => "606",
                    "sigla" => "PRST",
                    "nome" => "Parecer à Redação para o Segundo Turno",
                    "descricao" => ""
                ],
                [
                    "cod" => "607",
                    "sigla" => "RLP(V)",
                    "nome" => "Relatório Prévio Vencedor",
                    "descricao" => ""
                ],
                [
                    "cod" => "608",
                    "sigla" => "EMA",
                    "nome" => "Emenda Aglutinativa de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "609",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Criação de Frente Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "610",
                    "sigla" => "DOC",
                    "nome" => "Documento",
                    "descricao" => ""
                ],
                [
                    "cod" => "611",
                    "sigla" => "SOR",
                    "nome" => "Sugestão de Emenda ao Orçamento - Comissões",
                    "descricao" => ""
                ],
                [
                    "cod" => "612",
                    "sigla" => "SLD",
                    "nome" => "Sugestão de Emenda à LDO - Comissões",
                    "descricao" => ""
                ],
                [
                    "cod" => "613",
                    "sigla" => "SPP",
                    "nome" => "Sugestão de Emenda ao PPA - Comissões",
                    "descricao" => ""
                ],
                [
                    "cod" => "614",
                    "sigla" => "RPA",
                    "nome" => "Relatório Parcial",
                    "descricao" => ""
                ],
                [
                    "cod" => "615",
                    "sigla" => "MTC",
                    "nome" => "Mensagem (TCU)",
                    "descricao" => ""
                ],
                [
                    "cod" => "616",
                    "sigla" => "SPP-R",
                    "nome" => "Sugestão de Emenda ao PPA - revisão (Comissões)",
                    "descricao" => ""
                ],
                [
                    "cod" => "617",
                    "sigla" => "SPA-R",
                    "nome" => "Sugestão de Emenda ao PPA - revisão (CLP)",
                    "descricao" => ""
                ],
                [
                    "cod" => "618",
                    "sigla" => "REC",
                    "nome" => "Recurso do Conselho de Ética que contraria norma constitucional ou regimental (Art. 13 ou 14, CEDP)",
                    "descricao" => ""
                ],
                [
                    "cod" => "619",
                    "sigla" => "RFP",
                    "nome" => "Refomulação de Parecer - art. 130, parágrafo único do RICD.",
                    "descricao" => ""
                ],
                [
                    "cod" => "620",
                    "sigla" => "PPP",
                    "nome" => "Parecer Proferido em Plenário - Notas Taquigráficas",
                    "descricao" => ""
                ],
                [
                    "cod" => "621",
                    "sigla" => "PSS",
                    "nome" => "Parecer às Emendas ou ao Substitutivo do Senado - Notas Taquigráficas",
                    "descricao" => ""
                ],
                [
                    "cod" => "622",
                    "sigla" => "PRVP",
                    "nome" => "Proposta de Redação do Vencido em Primeiro Turno",
                    "descricao" => ""
                ],
                [
                    "cod" => "623",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Afastamento/Interrupção de tratamento de saúde",
                    "descricao" => ""
                ],
                [
                    "cod" => "624",
                    "sigla" => "SUC",
                    "nome" => "Sugestão a Projeto de Consolidação de Leis",
                    "descricao" => ""
                ],
                [
                    "cod" => "625",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Prejudicialidade",
                    "descricao" => ""
                ],
                [
                    "cod" => "626",
                    "sigla" => "MSC",
                    "nome" => "Mensagem de Cessão de Imóvel",
                    "descricao" => ""
                ],
                [
                    "cod" => "627",
                    "sigla" => "TVR",
                    "nome" => "Perempção de Rádio/TV",
                    "descricao" => ""
                ],
                [
                    "cod" => "628",
                    "sigla" => "TVR",
                    "nome" => "Revogação ou Anulação de Portaria de Rádio/TV",
                    "descricao" => ""
                ],
                [
                    "cod" => "629",
                    "sigla" => "TVR",
                    "nome" => "Transferência de Controle Societário",
                    "descricao" => ""
                ],
                [
                    "cod" => "630",
                    "sigla" => "REC",
                    "nome" => "Recurso contra indeferimento liminar de emenda à Medida Provisória (Art. 125, caput, RICD)",
                    "descricao" => ""
                ],
                [
                    "cod" => "631",
                    "sigla" => "REL",
                    "nome" => "Relatório de Comissão Externa",
                    "descricao" => ""
                ],
                [
                    "cod" => "632",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN)",
                    "descricao" => ""
                ],
                [
                    "cod" => "633",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Alteração do PPA e LDO",
                    "descricao" => ""
                ],
                [
                    "cod" => "634",
                    "sigla" => "PDN",
                    "nome" => "Projeto de Decreto Legislativo (CN)",
                    "descricao" => ""
                ],
                [
                    "cod" => "635",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN)",
                    "descricao" => ""
                ],
                [
                    "cod" => "636",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Relatório de Atividades do TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "637",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Relatório de Gestão Fiscal",
                    "descricao" => ""
                ],
                [
                    "cod" => "638",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Demonstrações Financeiras do Banco Central do Brasil",
                    "descricao" => ""
                ],
                [
                    "cod" => "639",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Contas do Governo da República",
                    "descricao" => ""
                ],
                [
                    "cod" => "640",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Relatório de Desempenho do Fundo Soberano do Brasil",
                    "descricao" => ""
                ],
                [
                    "cod" => "641",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Subtítulos com Indícios de Irregularidades Graves Apontadas pelo TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "642",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Operações de Redesconto e Empréstimo realizadas pelo Banco Central",
                    "descricao" => ""
                ],
                [
                    "cod" => "643",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN)",
                    "descricao" => ""
                ],
                [
                    "cod" => "644",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN)",
                    "descricao" => ""
                ],
                [
                    "cod" => "645",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN) de Relatório de Avaliação do Cumprimento das Metas Fiscais/Superávit Primário, MCN",
                    "descricao" => ""
                ],
                [
                    "cod" => "646",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN) de Relatório de Gestão Fiscal, MCN",
                    "descricao" => ""
                ],
                [
                    "cod" => "647",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN) de Operações de Crédito Incluídas na LOA Pedentes de Contratação, MCN",
                    "descricao" => ""
                ],
                [
                    "cod" => "648",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN) de Relatório de Avaliação do PPA, MCN",
                    "descricao" => ""
                ],
                [
                    "cod" => "649",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN) de Contas do Governo da República, MCN",
                    "descricao" => ""
                ],
                [
                    "cod" => "650",
                    "sigla" => "MCN",
                    "nome" => "Mensagem (CN) de Relatório de Avaliação de Receitas e Despesas, MCN",
                    "descricao" => ""
                ],
                [
                    "cod" => "651",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Relatório de Gestão Fiscal",
                    "descricao" => ""
                ],
                [
                    "cod" => "652",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Relatório Trimestral Gerencial do BNDES",
                    "descricao" => ""
                ],
                [
                    "cod" => "653",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Operações de Empréstimo de Capital de Giro Contratadas pela Caixa Econômica Federal",
                    "descricao" => ""
                ],
                [
                    "cod" => "654",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Demonstrações Contábeis de Fundo Constitucional de Financiamento",
                    "descricao" => ""
                ],
                [
                    "cod" => "655",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Contas do Governo da República",
                    "descricao" => ""
                ],
                [
                    "cod" => "656",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Subtítulos com Indícios de Irregularidades Graves apontadas pelo TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "657",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Crédito Especial",
                    "descricao" => ""
                ],
                [
                    "cod" => "658",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Crédito Suplementar",
                    "descricao" => ""
                ],
                [
                    "cod" => "659",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Lei Orçamentária Anual (LOA)",
                    "descricao" => ""
                ],
                [
                    "cod" => "660",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Lei de Diretrizes Orçamentárias (LDO)",
                    "descricao" => ""
                ],
                [
                    "cod" => "661",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Plano Plurianual",
                    "descricao" => ""
                ],
                [
                    "cod" => "662",
                    "sigla" => "MSF",
                    "nome" => "Mensagem (SF)",
                    "descricao" => ""
                ],
                [
                    "cod" => "663",
                    "sigla" => "PRP",
                    "nome" => "Parecer do Relator Parcial",
                    "descricao" => ""
                ],
                [
                    "cod" => "664",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Retirada de Emenda a Medida Provisória",
                    "descricao" => ""
                ],
                [
                    "cod" => "665",
                    "sigla" => "EMRP",
                    "nome" => "Emenda de Relator Parcial",
                    "descricao" => ""
                ],
                [
                    "cod" => "666",
                    "sigla" => "CAC",
                    "nome" => "Comunicado de Alteração do Controle Societário",
                    "descricao" => ""
                ],
                [
                    "cod" => "667",
                    "sigla" => "RRL",
                    "nome" => "Relatório do Relator (CMO)",
                    "descricao" => ""
                ],
                [
                    "cod" => "668",
                    "sigla" => "CVR",
                    "nome" => "Contestação ao Voto do Relator",
                    "descricao" => ""
                ],
                [
                    "cod" => "669",
                    "sigla" => "PARF",
                    "nome" => "Parecer de Comissão para Redação Final",
                    "descricao" => ""
                ],
                [
                    "cod" => "670",
                    "sigla" => "MPV",
                    "nome" => "Medida Provisória de Crédito Extraordinário",
                    "descricao" => ""
                ],
                [
                    "cod" => "671",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Relatório de Atividades da Autoridade Pública Olímpica - APO",
                    "descricao" => ""
                ],
                [
                    "cod" => "672",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Relatório de Gestão Fiscal do Tribunal de Contas da União",
                    "descricao" => ""
                ],
                [
                    "cod" => "673",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Lei de Incentivo ao Esporte",
                    "descricao" => ""
                ],
                [
                    "cod" => "674",
                    "sigla" => "SRL",
                    "nome" => "Sugestão de Emenda a Relatório",
                    "descricao" => ""
                ],
                [
                    "cod" => "675",
                    "sigla" => "RPL",
                    "nome" => "Relatório Preliminar",
                    "descricao" => ""
                ],
                [
                    "cod" => "676",
                    "sigla" => "RRC",
                    "nome" => "Relatório de Receita",
                    "descricao" => ""
                ],
                [
                    "cod" => "679",
                    "sigla" => "RPLE",
                    "nome" => "Relatório Preliminar Apresentado com Emendas",
                    "descricao" => ""
                ],
                [
                    "cod" => "680",
                    "sigla" => "ERR",
                    "nome" => "Errata",
                    "descricao" => ""
                ],
                [
                    "cod" => "681",
                    "sigla" => "CAE",
                    "nome" => "Relatório de Atividades do Comitê de Admissibilidade de Emendas (CAE)",
                    "descricao" => ""
                ],
                [
                    "cod" => "682",
                    "sigla" => "COI",
                    "nome" => "Relatório do COI",
                    "descricao" => ""
                ],
                [
                    "cod" => "683",
                    "sigla" => "RAT",
                    "nome" => "Relatório Setorial",
                    "descricao" => ""
                ],
                [
                    "cod" => "685",
                    "sigla" => "CAE",
                    "nome" => "Relatório do CAE",
                    "descricao" => ""
                ],
                [
                    "cod" => "686",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Participação ou Realização de Eventos fora da Câmara",
                    "descricao" => ""
                ],
                [
                    "cod" => "687",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Reapresentação de Projeto de Lei Rejeitado na mesma Sessão Legislativa",
                    "descricao" => ""
                ],
                [
                    "cod" => "688",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão de Matéria para Apreciação Imediata na Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "689",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Informações de Execução das Obras do PAC",
                    "descricao" => ""
                ],
                [
                    "cod" => "690",
                    "sigla" => "OFS",
                    "nome" => "Ofício do Senado Federal",
                    "descricao" => ""
                ],
                [
                    "cod" => "691",
                    "sigla" => "OFS",
                    "nome" => "Ofício do Senado Federal de Fundo Constitucional de Financiamento ",
                    "descricao" => ""
                ],
                [
                    "cod" => "692",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Alteração da LDO",
                    "descricao" => ""
                ],
                [
                    "cod" => "693",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Alteração da LOA",
                    "descricao" => ""
                ],
                [
                    "cod" => "694",
                    "sigla" => "MSG",
                    "nome" => "Mensagem (SF)",
                    "descricao" => ""
                ],
                [
                    "cod" => "695",
                    "sigla" => "MSG",
                    "nome" => "Mensagem (SF) de Contas do Governo da República",
                    "descricao" => ""
                ],
                [
                    "cod" => "696",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Demonstrações Contábeis do Fundo Constitucional de Financiamento do Norte (FNO)",
                    "descricao" => ""
                ],
                [
                    "cod" => "697",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Demonstrações Contábeis do Fundo Constitucional de Financiamento do Centro-Oeste (FCO)",
                    "descricao" => ""
                ],
                [
                    "cod" => "698",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Demonstrações Contábeis do Fundo Constitucional de Financiamento do Nordeste (FNE).",
                    "descricao" => ""
                ],
                [
                    "cod" => "699",
                    "sigla" => "PLN",
                    "nome" => "Projeto de Lei (CN) de Alteração do PPA",
                    "descricao" => ""
                ],
                [
                    "cod" => "700",
                    "sigla" => "",
                    "nome" => "Outras Proposições - Comissão Mista",
                    "descricao" => ""
                ],
                [
                    "cod" => "701",
                    "sigla" => "SBT-A",
                    "nome" => "Substitutivo adotado pela Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "702",
                    "sigla" => "EMC-A",
                    "nome" => "Emenda Adotada pela Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "703",
                    "sigla" => "SBE-A",
                    "nome" => "Subemenda Adotada pela Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "704",
                    "sigla" => "RPLOA",
                    "nome" => "Relatório Preliminar",
                    "descricao" => ""
                ],
                [
                    "cod" => "705",
                    "sigla" => "ANEXO",
                    "nome" => "Anexo",
                    "descricao" => ""
                ],
                [
                    "cod" => "706",
                    "sigla" => "EMPV",
                    "nome" => "Emenda à Medida Provisória (CN)",
                    "descricao" => ""
                ],
                [
                    "cod" => "707",
                    "sigla" => "REL",
                    "nome" => "Relatório do Congresso Nacional",
                    "descricao" => ""
                ],
                [
                    "cod" => "708",
                    "sigla" => "OF",
                    "nome" => "Ofício do Congresso Nacional",
                    "descricao" => ""
                ],
                [
                    "cod" => "709",
                    "sigla" => "SBR",
                    "nome" => "Subemenda de Relator",
                    "descricao" => ""
                ],
                [
                    "cod" => "710",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Contas do Gestor Federal do SUS",
                    "descricao" => ""
                ],
                [
                    "cod" => "711",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Demonstrações Financeiras do Banco Central do Brasil",
                    "descricao" => ""
                ],
                [
                    "cod" => "712",
                    "sigla" => "AVN",
                    "nome" => "Aviso (CN) de Contas do TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "713",
                    "sigla" => "ERD-A",
                    "nome" => "Emenda de Redação Adotada",
                    "descricao" => ""
                ],
                [
                    "cod" => "714",
                    "sigla" => "PIN",
                    "nome" => "Proposta de Instrução Normativa",
                    "descricao" => ""
                ],
                [
                    "cod" => "715",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Contas do TCU",
                    "descricao" => ""
                ],
                [
                    "cod" => "810",
                    "sigla" => "ATA",
                    "nome" => "Ata",
                    "descricao" => ""
                ],
                [
                    "cod" => "814",
                    "sigla" => "CRVITAEDOC",
                    "nome" => "Curriculum Vitae/Outro Documento",
                    "descricao" => null
                ],
                [
                    "cod" => "822",
                    "sigla" => "OF",
                    "nome" => "Ofício do Congresso Nacional",
                    "descricao" => ""
                ],
                [
                    "cod" => "823",
                    "sigla" => "OF",
                    "nome" => "Ofício do Senado Federal",
                    "descricao" => ""
                ],
                [
                    "cod" => "830",
                    "sigla" => "PR/CNMP",
                    "nome" => "Parecer do Conselho Nacional do Ministério Público",
                    "descricao" => null
                ],
                [
                    "cod" => "831",
                    "sigla" => "PR/CNJ",
                    "nome" => "Parecer do Conselho Nacional de Justiça",
                    "descricao" => null
                ],
                [
                    "cod" => "832",
                    "sigla" => "OFN",
                    "nome" => "Ofício (CN) de Relatório Anual da Agência Nacional de Transportes Aquaviários - Antaq",
                    "descricao" => ""
                ],
                [
                    "cod" => "833",
                    "sigla" => "",
                    "nome" => "L) DOCUMENTOS DE CPI",
                    "descricao" => ""
                ],
                [
                    "cod" => "834",
                    "sigla" => "DOCCPI",
                    "nome" => "Documento de CPI",
                    "descricao" => ""
                ],
                [
                    "cod" => "835",
                    "sigla" => "DOCCPI",
                    "nome" => "Documento de CPI sigiloso",
                    "descricao" => ""
                ],
                [
                    "cod" => "836",
                    "sigla" => "OFJ",
                    "nome" => "Ofício de Órgão do Poder Judiciário",
                    "descricao" => ""
                ],
                [
                    "cod" => "837",
                    "sigla" => "OFE",
                    "nome" => "Ofício de Órgão do Poder Executivo",
                    "descricao" => ""
                ],
                [
                    "cod" => "838",
                    "sigla" => "MAD",
                    "nome" => "Manifestação do(a) Denunciado(a)",
                    "descricao" => ""
                ],
                [
                    "cod" => "839",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo sobre Declaração de Guerra e correlatos",
                    "descricao" => ""
                ],
                [
                    "cod" => "840",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo sobre Estado de Defesa, Estado de Sítio e Intervenção Federal nos Estados",
                    "descricao" => ""
                ],
                [
                    "cod" => "841",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo sobre transferência temporária da sede do Governo Federal",
                    "descricao" => ""
                ],
                [
                    "cod" => "842",
                    "sigla" => "PDC",
                    "nome" => "Projeto de Decreto Legislativo para autorizar o Presidente ou o Vice-Presidente da República a se ausentarem do paíse, por mais de 15 dias (art. 49, II, CF)",
                    "descricao" => ""
                ],
                [
                    "cod" => "843",
                    "sigla" => "SIP",
                    "nome" => "Solicitação para instauração de processo",
                    "descricao" => "Artigo 217 do RICD"
                ],
                [
                    "cod" => "844",
                    "sigla" => "REC",
                    "nome" => "Recurso contra aplicação de censura escrita (Art. 12, § 2º do CEDP)",
                    "descricao" => "Contra aplicação de censura escrita (Art. 12, § 2º do CEDP)"
                ],
                [
                    "cod" => "845",
                    "sigla" => "OF",
                    "nome" => "Demonstrativo de emissão do real",
                    "descricao" => ""
                ],
                [
                    "cod" => "846",
                    "sigla" => "DTQ",
                    "nome" => "Destaque para Votação em Separado",
                    "descricao" => ""
                ],
                [
                    "cod" => "847",
                    "sigla" => "DTQ",
                    "nome" => "Destaque de Bancada",
                    "descricao" => ""
                ],
                [
                    "cod" => "848",
                    "sigla" => "RCEX",
                    "nome" => "Relatório de Comissão Externa",
                    "descricao" => ""
                ],
                [
                    "cod" => "849",
                    "sigla" => "RCEL",
                    "nome" => "Relatório de Comissão de Estudo Legislativo",
                    "descricao" => ""
                ],
                [
                    "cod" => "850",
                    "sigla" => "DEF",
                    "nome" => "Defesa Escrita",
                    "descricao" => ""
                ],
                [
                    "cod" => "851",
                    "sigla" => "DEF",
                    "nome" => "Defesa Prévia",
                    "descricao" => ""
                ],
                [
                    "cod" => "852",
                    "sigla" => "PRLP",
                    "nome" => "Parecer Preliminar",
                    "descricao" => ""
                ],
                [
                    "cod" => "853",
                    "sigla" => "PRLP(V)",
                    "nome" => "Parecer Preliminar Vencedor",
                    "descricao" => ""
                ],
                [
                    "cod" => "854",
                    "sigla" => "RGT",
                    "nome" => "Relatório de Grupo de Trabalho",
                    "descricao" => ""
                ],
                [
                    "cod" => "855",
                    "sigla" => "REL-A",
                    "nome" => "Relatório Adotado pela Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "856",
                    "sigla" => "RRR",
                    "nome" => "Relatório Reformulado",
                    "descricao" => ""
                ],
                [
                    "cod" => "857",
                    "sigla" => "RVC",
                    "nome" => "Relatório Vencedor",
                    "descricao" => ""
                ],
                [
                    "cod" => "858",
                    "sigla" => "CMC",
                    "nome" => "Comunicação de Medida Cautelar",
                    "descricao" => ""
                ],
                [
                    "cod" => "859",
                    "sigla" => "DOC",
                    "nome" => "Indicação de Líder de Partido ou Bloco Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "860",
                    "sigla" => "DOC",
                    "nome" => "Indicação de Vice-Líder de Partido ou Bloco Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "861",
                    "sigla" => "DOC",
                    "nome" => "Adesão a Grupo ou Frente Parlamentar Registrada",
                    "descricao" => ""
                ],
                [
                    "cod" => "862",
                    "sigla" => "DOC",
                    "nome" => "Desligamento de Frente Parlamentar Registrada",
                    "descricao" => ""
                ],
                [
                    "cod" => "863",
                    "sigla" => "DOC",
                    "nome" => "Constituição de Bloco Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "864",
                    "sigla" => "DOC",
                    "nome" => "Adesão a Bloco Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "865",
                    "sigla" => "DOC",
                    "nome" => "Desligamento de Bloco Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "866",
                    "sigla" => "DOC",
                    "nome" => "Indicação de Coordenador de Bancada Estadual",
                    "descricao" => ""
                ],
                [
                    "cod" => "867",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inclusão na Ordem do Dia (Res 14/20, art. 4º, §3º)",
                    "descricao" => ""
                ],
                [
                    "cod" => "868",
                    "sigla" => "MIP",
                    "nome" => "Minuta de Proposição Legislativa",
                    "descricao" => ""
                ],
                [
                    "cod" => "869",
                    "sigla" => "EMC",
                    "nome" => "Emenda à PEC",
                    "descricao" => ""
                ],
                [
                    "cod" => "870",
                    "sigla" => "EMP",
                    "nome" => "Emenda de Plenário a Projeto com Urgência ",
                    "descricao" => ""
                ],
                [
                    "cod" => "871",
                    "sigla" => "EMP",
                    "nome" => "Emenda de Plenário a Projeto em Fase de Discussão do 2º Turno ",
                    "descricao" => ""
                ],
                [
                    "cod" => "872",
                    "sigla" => "ERD",
                    "nome" => "Emenda de Redação em Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "873",
                    "sigla" => "EMP",
                    "nome" => "Emenda de Plenário à MPV (Ato Conjunto 1/20)",
                    "descricao" => ""
                ],
                [
                    "cod" => "874",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Discussão por Partes",
                    "descricao" => ""
                ],
                [
                    "cod" => "875",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de quebra de insterstício para verificação de votação",
                    "descricao" => ""
                ],
                [
                    "cod" => "876",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Inversão de Pauta",
                    "descricao" => ""
                ],
                [
                    "cod" => "877",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Encerramento da Discussão de Projeto de Código",
                    "descricao" => ""
                ],
                [
                    "cod" => "878",
                    "sigla" => "REQ",
                    "nome" => "Requerimento de Urgência (art. 154, I ou III, do RICD)",
                    "descricao" => ""
                ],
                [
                    "cod" => "887",
                    "sigla" => "ECN",
                    "nome" => "Emenda (CN)",
                    "descricao" => "Emenda a Projeto do Congresso Nacional"
                ],
                [
                    "cod" => "888",
                    "sigla" => "DTS",
                    "nome" => "Destaque Simples",
                    "descricao" => ""
                ],
                [
                    "cod" => "889",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Retirada de Tramitação de Proposição de Iniciativa Individual em Sessão ou Reunião",
                    "descricao" => ""
                ],
                [
                    "cod" => "890",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Retirada de Tramitação de Proposição em Sessão ou Reunião",
                    "descricao" => ""
                ],
                [
                    "cod" => "891",
                    "sigla" => "PRLP",
                    "nome" => "Parecer Preliminar de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "892",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Adiamento da Discussão de Matéria Urgente",
                    "descricao" => ""
                ],
                [
                    "cod" => "895",
                    "sigla" => "AJECN",
                    "nome" => "Ajuste de Emenda Orçamentária (CN)",
                    "descricao" => "Ajuste de Emenda Orçamentária do Congresso Nacional"
                ],
                [
                    "cod" => "896",
                    "sigla" => "SRL",
                    "nome" => "Sugestão a Relatório (CN)",
                    "descricao" => "Sugestão a Relatório do Congresso Nacional"
                ],
                [
                    "cod" => "897",
                    "sigla" => "ATACN",
                    "nome" => "Ata (CN)",
                    "descricao" => "Ata do Congresso Nacional"
                ],
                [
                    "cod" => "898",
                    "sigla" => "REQ",
                    "nome" => "REQ - Tramitação de tratado internacional nos termos do art. 5º, § 3º, da CF",
                    "descricao" => "Requerimento - Tramitação de tratado internacional nos termos do art. 5º, § 3º, da CF"
                ],
                [
                    "cod" => "1000",
                    "sigla" => "RPD",
                    "nome" => "Requerimento de Encerramento da Discussão e do Encaminhamento de Matéria Urgente",
                    "descricao" => ""
                ],
                [
                    "cod" => "1001",
                    "sigla" => "PRLE",
                    "nome" => "Parecer Preliminar às Emendas de Plenário",
                    "descricao" => ""
                ],
                [
                    "cod" => "1002",
                    "sigla" => "DOC",
                    "nome" => "Denominação de Bloco Parlamentar",
                    "descricao" => ""
                ],
                [
                    "cod" => "1003",
                    "sigla" => "DOC",
                    "nome" => "Ofício da Primeira-Secretaria",
                    "descricao" => ""
                ],
                [
                    "cod" => "1004",
                    "sigla" => "PRO",
                    "nome" => "Proposta de Plano para Comissão",
                    "descricao" => ""
                ],
                [
                    "cod" => "1005",
                    "sigla" => "PRO",
                    "nome" => "Proposta de Regulamento",
                    "descricao" => ""
                ],
                [
                    "cod" => "1006",
                    "sigla" => "RLG",
                    "nome" => "Relatório Geral",
                    "descricao" => ""
                ],
                [
                    "cod" => "1007",
                    "sigla" => "QO",
                    "nome" => "Questão de Ordem",
                    "descricao" => ""
                ],
                [
                    "cod" => "1008",
                    "sigla" => "APM",
                    "nome" => "Complemento de Apoiamento",
                    "descricao" => ""
                ],
                [
                    "cod" => "1009",
                    "sigla" => "CFIS",
                    "nome" => "Relatório de Atividades do Comitê de Avaliação, Fiscalização e Controle de Execução Orçamentária",
                    "descricao" => ""
                ],
                [
                    "cod" => "1010",
                    "sigla" => "REQ",
                    "nome" => "Requerimento para Alteração da Ordem dos Trabalhos",
                    "descricao" => ""
                ],
                [
                    "cod" => "1011",
                    "sigla" => "DTQ",
                    "nome" => "Destaque de Emenda",
                    "descricao" => ""
                ],
                [
                    "cod" => "1012",
                    "sigla" => "DTQ",
                    "nome" => "Destaque de Preferência",
                    "descricao" => ""
                ],
                [
                    "cod" => "1013",
                    "sigla" => "DTQ",
                    "nome" => "Destaque para Proposição Autônoma",
                    "descricao" => ""
                ]
            ];
        }

        if (false) {

            $temas = [
                ['Abou Anni', 'Administração Pública', '1'],
                ['Abou Anni', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Abou Anni', 'Defesa e Segurança', '1'],
                ['Abou Anni', 'Direito Civil e Processual Civil', '1'],
                ['Abou Anni', 'Direito e Defesa do Consumidor', '1'],
                ['Abou Anni', 'Direito e Justiça', '1'],
                ['Abou Anni', 'Direito Penal e Processual Penal', '2'],
                ['Abou Anni', 'Economia', '2'],
                ['Abou Anni', 'Educação', '2'],
                ['Abou Anni', 'Finanças Públicas e Orçamento', '4'],
                ['Abou Anni', 'Homenagens e Datas Comemorativas', '1'],
                ['Abou Anni', 'Previdência e Assistência Social', '1'],
                ['Abou Anni', 'Saúde', '6'],
                ['Abou Anni', 'Trabalho e Emprego', '12'],
                ['Abou Anni', 'Viação, Transporte e Mobilidade', '28'],
                ['Adriana Ventura', 'Administração Pública', '44'],
                ['Adriana Ventura', 'Saúde', '30'],
                ['Adriana Ventura', 'Finanças Públicas e Orçamento', '18'],
                ['Adriana Ventura', 'Trabalho e Emprego', '12'],
                ['Adriana Ventura', 'Direito Penal e Processual Penal', '11'],
                ['Adriana Ventura', 'Política, Partidos e Eleições', '11'],
                ['Adriana Ventura', 'Direito Civil e Processual Civil', '7'],
                ['Adriana Ventura', 'Educação', '7'],
                ['Adriana Ventura', 'Indústria, Comércio e Serviços', '7'],
                ['Adriana Ventura', 'Direitos Humanos e Minorias', '6'],
                ['Adriana Ventura', 'Processo Legislativo e Atuação Parlamentar', '5'],
                ['Adriana Ventura', 'Comunicações', '3'],
                ['Adriana Ventura', 'Direito e Defesa do Consumidor', '3'],
                ['Adriana Ventura', 'Economia', '3'],
                ['Adriana Ventura', 'Ciência, Tecnologia e Inovação', '2'],
                ['Adriana Ventura', 'Defesa e Segurança', '2'],
                ['Adriana Ventura', 'Direito Constitucional', '2'],
                ['Adriana Ventura', 'Meio Ambiente e Desenvolvimento Sustentável', '2'],
                ['Adriana Ventura', 'Previdência e Assistência Social', '2'],
                ['Adriana Ventura', 'Turismo', '2'],
                ['Adriana Ventura', 'Viação, Transporte e Mobilidade', '2'],
                ['Adriana Ventura', 'Arte, Cultura e Religião', '1'],
                ['Adriana Ventura', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Adriana Ventura', 'Direito e Justiça', '1'],
                ['Adriana Ventura', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Adriana Ventura', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Alencar Santana', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['Alencar Santana', 'Finanças Públicas e Orçamento', '1'],
                ['Alencar Santana Braga', 'Administração Pública', '37'],
                ['Alencar Santana Braga', 'Agricultura, Pecuária, Pesca e Extrativismo', '9'],
                ['Alencar Santana Braga', 'Arte, Cultura e Religião', '5'],
                ['Alencar Santana Braga', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Alencar Santana Braga', 'Ciência, Tecnologia e Inovação', '4'],
                ['Alencar Santana Braga', 'Comunicações', '9'],
                ['Alencar Santana Braga', 'Defesa e Segurança', '15'],
                ['Alencar Santana Braga', 'Direito Civil e Processual Civil', '4'],
                ['Alencar Santana Braga', 'Direito Constitucional', '2'],
                ['Alencar Santana Braga', 'Direito e Defesa do Consumidor', '4'],
                ['Alencar Santana Braga', 'Direito e Justiça', '2'],
                ['Alencar Santana Braga', 'Direito Penal e Processual Penal', '12'],
                ['Alencar Santana Braga', 'Direitos Humanos e Minorias', '61'],
                ['Alencar Santana Braga', 'Economia', '14'],
                ['Alencar Santana Braga', 'Educação', '22'],
                ['Alencar Santana Braga', 'Energia, Recursos Hídricos e Minerais', '4'],
                ['Alencar Santana Braga', 'Estrutura Fundiária', '2'],
                ['Alencar Santana Braga', 'Finanças Públicas e Orçamento', '30'],
                ['Alencar Santana Braga', 'Homenagens e Datas Comemorativas', '5'],
                ['Alencar Santana Braga', 'Indústria, Comércio e Serviços', '14'],
                ['Alencar Santana Braga', 'Meio Ambiente e Desenvolvimento Sustentável', '11'],
                ['Alencar Santana Braga', 'Política, Partidos e Eleições', '5'],
                ['Alencar Santana Braga', 'Previdência e Assistência Social', '26'],
                ['Alencar Santana Braga', 'Relações Internacionais e Comércio Exterior', '4'],
                ['Alencar Santana Braga', 'Saúde', '57'],
                ['Alencar Santana Braga', 'Trabalho e Emprego', '37'],
                ['Alencar Santana Braga', 'Viação, Transporte e Mobilidade', '6'],
                ['Alencar Santana Braga', 'NA', '1'],
                ['Alex Manente', 'Administração Pública', '20'],
                ['Alex Manente', 'Defesa e Segurança', '4'],
                ['Alex Manente', 'Direito Civil e Processual Civil', '2'],
                ['Alex Manente', 'Direito e Justiça', '2'],
                ['Alex Manente', 'Direito Penal e Processual Penal', '9'],
                ['Alex Manente', 'Direitos Humanos e Minorias', '4'],
                ['Alex Manente', 'Economia', '1'],
                ['Alex Manente', 'Educação', '2'],
                ['Alex Manente', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Alex Manente', 'Estrutura Fundiária', '1'],
                ['Alex Manente', 'Finanças Públicas e Orçamento', '6'],
                ['Alex Manente', 'Homenagens e Datas Comemorativas', '2'],
                ['Alex Manente', 'Indústria, Comércio e Serviços', '2'],
                ['Alex Manente', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Alex Manente', 'Previdência e Assistência Social', '2'],
                ['Alex Manente', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Alex Manente', 'Saúde', '5'],
                ['Alex Manente', 'Trabalho e Emprego', '4'],
                ['Alexandre Frota', 'Administração Pública', '91'],
                ['Alexandre Frota', 'Agricultura, Pecuária, Pesca e Extrativismo', '7'],
                ['Alexandre Frota', 'Arte, Cultura e Religião', '12'],
                ['Alexandre Frota', 'Cidades e Desenvolvimento Urbano', '16'],
                ['Alexandre Frota', 'Ciência, Tecnologia e Inovação', '6'],
                ['Alexandre Frota', 'Ciências Exatas e da Terra', '1'],
                ['Alexandre Frota', 'Comunicações', '21'],
                ['Alexandre Frota', 'Defesa e Segurança', '58'],
                ['Alexandre Frota', 'Direito Civil e Processual Civil', '29'],
                ['Alexandre Frota', 'Direito Constitucional', '3'],
                ['Alexandre Frota', 'Direito e Defesa do Consumidor', '33'],
                ['Alexandre Frota', 'Direito e Justiça', '12'],
                ['Alexandre Frota', 'Direito Penal e Processual Penal', '73'],
                ['Alexandre Frota', 'Direitos Humanos e Minorias', '228'],
                ['Alexandre Frota', 'Economia', '22'],
                ['Alexandre Frota', 'Educação', '53'],
                ['Alexandre Frota', 'Energia, Recursos Hídricos e Minerais', '14'],
                ['Alexandre Frota', 'Esporte e Lazer', '29'],
                ['Alexandre Frota', 'Finanças Públicas e Orçamento', '66'],
                ['Alexandre Frota', 'Homenagens e Datas Comemorativas', '19'],
                ['Alexandre Frota', 'Indústria, Comércio e Serviços', '58'],
                ['Alexandre Frota', 'Meio Ambiente e Desenvolvimento Sustentável', '49'],
                ['Alexandre Frota', 'Política, Partidos e Eleições', '17'],
                ['Alexandre Frota', 'Previdência e Assistência Social', '31'],
                ['Alexandre Frota', 'Processo Legislativo e Atuação Parlamentar', '11'],
                ['Alexandre Frota', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Alexandre Frota', 'Saúde', '188'],
                ['Alexandre Frota', 'Trabalho e Emprego', '66'],
                ['Alexandre Frota', 'Viação, Transporte e Mobilidade', '52'],
                ['Alexandre Frota', 'NA', '3'],
                ['Alexandre Leite', 'Defesa e Segurança', '3'],
                ['Alexandre Leite', 'Direito Penal e Processual Penal', '1'],
                ['Alexandre Leite', 'Direitos Humanos e Minorias', '2'],
                ['Alexandre Leite', 'Economia', '2'],
                ['Alexandre Leite', 'Finanças Públicas e Orçamento', '2'],
                ['Alexandre Leite', 'Indústria, Comércio e Serviços', '1'],
                ['Alexandre Leite', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Alexandre Leite', 'Previdência e Assistência Social', '1'],
                ['Alexandre Leite', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Alexandre Leite', 'Trabalho e Emprego', '1'],
                ['Alexandre Leite', 'Viação, Transporte e Mobilidade', '1'],
                ['Alexandre Padilha', 'Saúde', '113'],
                ['Alexandre Padilha', 'Direitos Humanos e Minorias', '74'],
                ['Alexandre Padilha', 'Administração Pública', '57'],
                ['Alexandre Padilha', 'Trabalho e Emprego', '57'],
                ['Alexandre Padilha', 'Finanças Públicas e Orçamento', '38'],
                ['Alexandre Padilha', 'Previdência e Assistência Social', '35'],
                ['Alexandre Padilha', 'Educação', '21'],
                ['Alexandre Padilha', 'Indústria, Comércio e Serviços', '20'],
                ['Alexandre Padilha', 'Arte, Cultura e Religião', '18'],
                ['Alexandre Padilha', 'Defesa e Segurança', '16'],
                ['Alexandre Padilha', 'Economia', '14'],
                ['Alexandre Padilha', 'Agricultura, Pecuária, Pesca e Extrativismo', '13'],
                ['Alexandre Padilha', 'Comunicações', '8'],
                ['Alexandre Padilha', 'Direito Penal e Processual Penal', '8'],
                ['Alexandre Padilha', 'Meio Ambiente e Desenvolvimento Sustentável', '8'],
                ['Alexandre Padilha', 'Direito e Defesa do Consumidor', '7'],
                ['Alexandre Padilha', 'Homenagens e Datas Comemorativas', '7'],
                ['Alexandre Padilha', 'Viação, Transporte e Mobilidade', '7'],
                ['Alexandre Padilha', 'Direito Civil e Processual Civil', '5'],
                ['Alexandre Padilha', 'Direito Constitucional', '5'],
                ['Alexandre Padilha', 'Energia, Recursos Hídricos e Minerais', '5'],
                ['Alexandre Padilha', 'Ciência, Tecnologia e Inovação', '4'],
                ['Alexandre Padilha', 'Relações Internacionais e Comércio Exterior', '4'],
                ['Alexandre Padilha', 'Política, Partidos e Eleições', '3'],
                ['Alexandre Padilha', 'Cidades e Desenvolvimento Urbano', '2'],
                ['Alexandre Padilha', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Alexandre Padilha', 'Estrutura Fundiária', '1'],
                ['Alexandre Padilha', 'NA', '1'],
                ['Alexis Fonteyne', 'Administração Pública', '26'],
                ['Alexis Fonteyne', 'Comunicações', '1'],
                ['Alexis Fonteyne', 'Defesa e Segurança', '2'],
                ['Alexis Fonteyne', 'Direito Civil e Processual Civil', '5'],
                ['Alexis Fonteyne', 'Direito Constitucional', '1'],
                ['Alexis Fonteyne', 'Direito e Defesa do Consumidor', '2'],
                ['Alexis Fonteyne', 'Direito e Justiça', '1'],
                ['Alexis Fonteyne', 'Direito Penal e Processual Penal', '10'],
                ['Alexis Fonteyne', 'Direitos Humanos e Minorias', '5'],
                ['Alexis Fonteyne', 'Economia', '3'],
                ['Alexis Fonteyne', 'Educação', '3'],
                ['Alexis Fonteyne', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Alexis Fonteyne', 'Finanças Públicas e Orçamento', '21'],
                ['Alexis Fonteyne', 'Indústria, Comércio e Serviços', '11'],
                ['Alexis Fonteyne', 'Meio Ambiente e Desenvolvimento Sustentável', '2'],
                ['Alexis Fonteyne', 'Política, Partidos e Eleições', '7'],
                ['Alexis Fonteyne', 'Previdência e Assistência Social', '3'],
                ['Alexis Fonteyne', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Alexis Fonteyne', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Alexis Fonteyne', 'Saúde', '11'],
                ['Alexis Fonteyne', 'Trabalho e Emprego', '16'],
                ['Alexis Fonteyne', 'Viação, Transporte e Mobilidade', '2'],
                ['Antonio Bulhões', 'Direitos Humanos e Minorias', '1'],
                ['Antonio Bulhões', 'Indústria, Comércio e Serviços', '1'],
                ['Antonio Bulhões', 'Saúde', '1'],
                ['Antonio Carlos Mendes Thame', 'Administração Pública', '1'],
                ['Antonio Carlos Mendes Thame', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Arlindo Chinaglia', 'Administração Pública', '21'],
                ['Arlindo Chinaglia', 'Agricultura, Pecuária, Pesca e Extrativismo', '5'],
                ['Arlindo Chinaglia', 'Arte, Cultura e Religião', '2'],
                ['Arlindo Chinaglia', 'Ciência, Tecnologia e Inovação', '1'],
                ['Arlindo Chinaglia', 'Comunicações', '2'],
                ['Arlindo Chinaglia', 'Defesa e Segurança', '4'],
                ['Arlindo Chinaglia', 'Direito Civil e Processual Civil', '2'],
                ['Arlindo Chinaglia', 'Direito Constitucional', '2'],
                ['Arlindo Chinaglia', 'Direito e Justiça', '1'],
                ['Arlindo Chinaglia', 'Direito Penal e Processual Penal', '2'],
                ['Arlindo Chinaglia', 'Direitos Humanos e Minorias', '18'],
                ['Arlindo Chinaglia', 'Economia', '7'],
                ['Arlindo Chinaglia', 'Educação', '3'],
                ['Arlindo Chinaglia', 'Energia, Recursos Hídricos e Minerais', '2'],
                ['Arlindo Chinaglia', 'Finanças Públicas e Orçamento', '12'],
                ['Arlindo Chinaglia', 'Homenagens e Datas Comemorativas', '1'],
                ['Arlindo Chinaglia', 'Indústria, Comércio e Serviços', '4'],
                ['Arlindo Chinaglia', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Arlindo Chinaglia', 'Política, Partidos e Eleições', '1'],
                ['Arlindo Chinaglia', 'Previdência e Assistência Social', '14'],
                ['Arlindo Chinaglia', 'Relações Internacionais e Comércio Exterior', '4'],
                ['Arlindo Chinaglia', 'Saúde', '25'],
                ['Arlindo Chinaglia', 'Trabalho e Emprego', '11'],
                ['Arlindo Chinaglia', 'Viação, Transporte e Mobilidade', '1'],
                ['Arnaldo Jardim', 'Administração Pública', '2'],
                ['Arnaldo Jardim', 'Agricultura, Pecuária, Pesca e Extrativismo', '3'],
                ['Arnaldo Jardim', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Arnaldo Jardim', 'Ciência, Tecnologia e Inovação', '1'],
                ['Arnaldo Jardim', 'Comunicações', '1'],
                ['Arnaldo Jardim', 'Defesa e Segurança', '3'],
                ['Arnaldo Jardim', 'Direito e Defesa do Consumidor', '1'],
                ['Arnaldo Jardim', 'Direitos Humanos e Minorias', '3'],
                ['Arnaldo Jardim', 'Economia', '4'],
                ['Arnaldo Jardim', 'Educação', '1'],
                ['Arnaldo Jardim', 'Energia, Recursos Hídricos e Minerais', '2'],
                ['Arnaldo Jardim', 'Finanças Públicas e Orçamento', '6'],
                ['Arnaldo Jardim', 'Homenagens e Datas Comemorativas', '1'],
                ['Arnaldo Jardim', 'Indústria, Comércio e Serviços', '5'],
                ['Arnaldo Jardim', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Arnaldo Jardim', 'Previdência e Assistência Social', '3'],
                ['Arnaldo Jardim', 'Saúde', '9'],
                ['Arnaldo Jardim', 'Trabalho e Emprego', '3'],
                ['Arnaldo Jardim', 'Viação, Transporte e Mobilidade', '1'],
                ['Baleia Rossi', 'Administração Pública', '9'],
                ['Baleia Rossi', 'Arte, Cultura e Religião', '2'],
                ['Baleia Rossi', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Baleia Rossi', 'Defesa e Segurança', '3'],
                ['Baleia Rossi', 'Direito Civil e Processual Civil', '2'],
                ['Baleia Rossi', 'Direito Constitucional', '1'],
                ['Baleia Rossi', 'Direito e Defesa do Consumidor', '1'],
                ['Baleia Rossi', 'Direito e Justiça', '2'],
                ['Baleia Rossi', 'Direito Penal e Processual Penal', '1'],
                ['Baleia Rossi', 'Direitos Humanos e Minorias', '4'],
                ['Baleia Rossi', 'Economia', '2'],
                ['Baleia Rossi', 'Educação', '3'],
                ['Baleia Rossi', 'Finanças Públicas e Orçamento', '4'],
                ['Baleia Rossi', 'Homenagens e Datas Comemorativas', '5'],
                ['Baleia Rossi', 'Indústria, Comércio e Serviços', '1'],
                ['Baleia Rossi', 'Política, Partidos e Eleições', '3'],
                ['Baleia Rossi', 'Previdência e Assistência Social', '4'],
                ['Baleia Rossi', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Baleia Rossi', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Baleia Rossi', 'Saúde', '6'],
                ['Baleia Rossi', 'Trabalho e Emprego', '5'],
                ['Baleia Rossi', 'Viação, Transporte e Mobilidade', '3'],
                ['Bruna Furlan', 'Administração Pública', '1'],
                ['Bruna Furlan', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Bruna Furlan', 'Ciência, Tecnologia e Inovação', '2'],
                ['Bruna Furlan', 'Direito Civil e Processual Civil', '1'],
                ['Bruna Furlan', 'Direitos Humanos e Minorias', '1'],
                ['Bruna Furlan', 'Educação', '1'],
                ['Bruna Furlan', 'Finanças Públicas e Orçamento', '1'],
                ['Bruna Furlan', 'Indústria, Comércio e Serviços', '1'],
                ['Bruna Furlan', 'Saúde', '1'],
                ['Bruna Furlan', 'Trabalho e Emprego', '1'],
                ['Capitão Augusto', 'Administração Pública', '3'],
                ['Capitão Augusto', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['Capitão Augusto', 'Defesa e Segurança', '7'],
                ['Capitão Augusto', 'Direito Civil e Processual Civil', '2'],
                ['Capitão Augusto', 'Direito Constitucional', '1'],
                ['Capitão Augusto', 'Direito e Justiça', '1'],
                ['Capitão Augusto', 'Direito Penal e Processual Penal', '16'],
                ['Capitão Augusto', 'Direitos Humanos e Minorias', '4'],
                ['Capitão Augusto', 'Economia', '3'],
                ['Capitão Augusto', 'Finanças Públicas e Orçamento', '5'],
                ['Capitão Augusto', 'Homenagens e Datas Comemorativas', '3'],
                ['Capitão Augusto', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Capitão Augusto', 'Saúde', '9'],
                ['Capitão Augusto', 'Trabalho e Emprego', '3'],
                ['Capitão Augusto', 'Turismo', '1'],
                ['Capitão Augusto', 'Viação, Transporte e Mobilidade', '2'],
                ['Capitão Augusto', 'NA', '1'],
                ['Carla Zambelli', 'Administração Pública', '12'],
                ['Carla Zambelli', 'Arte, Cultura e Religião', '1'],
                ['Carla Zambelli', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Carla Zambelli', 'Ciência, Tecnologia e Inovação', '1'],
                ['Carla Zambelli', 'Comunicações', '3'],
                ['Carla Zambelli', 'Defesa e Segurança', '6'],
                ['Carla Zambelli', 'Direito Civil e Processual Civil', '5'],
                ['Carla Zambelli', 'Direito Constitucional', '3'],
                ['Carla Zambelli', 'Direito e Defesa do Consumidor', '3'],
                ['Carla Zambelli', 'Direito e Justiça', '1'],
                ['Carla Zambelli', 'Direito Penal e Processual Penal', '26'],
                ['Carla Zambelli', 'Direitos Humanos e Minorias', '19'],
                ['Carla Zambelli', 'Economia', '1'],
                ['Carla Zambelli', 'Educação', '7'],
                ['Carla Zambelli', 'Estrutura Fundiária', '1'],
                ['Carla Zambelli', 'Finanças Públicas e Orçamento', '4'],
                ['Carla Zambelli', 'Homenagens e Datas Comemorativas', '4'],
                ['Carla Zambelli', 'Indústria, Comércio e Serviços', '1'],
                ['Carla Zambelli', 'Meio Ambiente e Desenvolvimento Sustentável', '5'],
                ['Carla Zambelli', 'Política, Partidos e Eleições', '5'],
                ['Carla Zambelli', 'Previdência e Assistência Social', '4'],
                ['Carla Zambelli', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Carla Zambelli', 'Saúde', '21'],
                ['Carla Zambelli', 'Trabalho e Emprego', '1'],
                ['Carla Zambelli', 'Viação, Transporte e Mobilidade', '2'],
                ['Carlos Sampaio', 'Administração Pública', '9'],
                ['Carlos Sampaio', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Carlos Sampaio', 'Ciência, Tecnologia e Inovação', '2'],
                ['Carlos Sampaio', 'Defesa e Segurança', '3'],
                ['Carlos Sampaio', 'Direito Civil e Processual Civil', '3'],
                ['Carlos Sampaio', 'Direito e Justiça', '2'],
                ['Carlos Sampaio', 'Direito Penal e Processual Penal', '12'],
                ['Carlos Sampaio', 'Direitos Humanos e Minorias', '9'],
                ['Carlos Sampaio', 'Economia', '3'],
                ['Carlos Sampaio', 'Educação', '4'],
                ['Carlos Sampaio', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Carlos Sampaio', 'Finanças Públicas e Orçamento', '5'],
                ['Carlos Sampaio', 'Homenagens e Datas Comemorativas', '1'],
                ['Carlos Sampaio', 'Indústria, Comércio e Serviços', '3'],
                ['Carlos Sampaio', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Carlos Sampaio', 'Previdência e Assistência Social', '4'],
                ['Carlos Sampaio', 'Saúde', '18'],
                ['Carlos Sampaio', 'Trabalho e Emprego', '4'],
                ['Carlos Sampaio', 'Viação, Transporte e Mobilidade', '1'],
                ['Carlos Zarattini', 'Administração Pública', '25'],
                ['Carlos Zarattini', 'Agricultura, Pecuária, Pesca e Extrativismo', '3'],
                ['Carlos Zarattini', 'Arte, Cultura e Religião', '3'],
                ['Carlos Zarattini', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Carlos Zarattini', 'Ciência, Tecnologia e Inovação', '2'],
                ['Carlos Zarattini', 'Comunicações', '3'],
                ['Carlos Zarattini', 'Defesa e Segurança', '12'],
                ['Carlos Zarattini', 'Direito Civil e Processual Civil', '2'],
                ['Carlos Zarattini', 'Direito e Justiça', '3'],
                ['Carlos Zarattini', 'Direito Penal e Processual Penal', '3'],
                ['Carlos Zarattini', 'Direitos Humanos e Minorias', '26'],
                ['Carlos Zarattini', 'Economia', '5'],
                ['Carlos Zarattini', 'Educação', '7'],
                ['Carlos Zarattini', 'Energia, Recursos Hídricos e Minerais', '5'],
                ['Carlos Zarattini', 'Estrutura Fundiária', '1'],
                ['Carlos Zarattini', 'Finanças Públicas e Orçamento', '16'],
                ['Carlos Zarattini', 'Homenagens e Datas Comemorativas', '4'],
                ['Carlos Zarattini', 'Indústria, Comércio e Serviços', '6'],
                ['Carlos Zarattini', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Carlos Zarattini', 'Previdência e Assistência Social', '12'],
                ['Carlos Zarattini', 'Relações Internacionais e Comércio Exterior', '3'],
                ['Carlos Zarattini', 'Saúde', '23'],
                ['Carlos Zarattini', 'Trabalho e Emprego', '7'],
                ['Celso Russomanno', 'Administração Pública', '3'],
                ['Celso Russomanno', 'Arte, Cultura e Religião', '1'],
                ['Celso Russomanno', 'Comunicações', '4'],
                ['Celso Russomanno', 'Defesa e Segurança', '1'],
                ['Celso Russomanno', 'Direito Civil e Processual Civil', '2'],
                ['Celso Russomanno', 'Direito e Defesa do Consumidor', '7'],
                ['Celso Russomanno', 'Direito e Justiça', '2'],
                ['Celso Russomanno', 'Direito Penal e Processual Penal', '2'],
                ['Celso Russomanno', 'Direitos Humanos e Minorias', '2'],
                ['Celso Russomanno', 'Economia', '3'],
                ['Celso Russomanno', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Celso Russomanno', 'Finanças Públicas e Orçamento', '1'],
                ['Celso Russomanno', 'Homenagens e Datas Comemorativas', '1'],
                ['Celso Russomanno', 'Indústria, Comércio e Serviços', '1'],
                ['Celso Russomanno', 'Política, Partidos e Eleições', '2'],
                ['Celso Russomanno', 'Trabalho e Emprego', '3'],
                ['Celso Russomanno', 'Viação, Transporte e Mobilidade', '1'],
                ['Cezinha de Madureira', 'Administração Pública', '5'],
                ['Cezinha de Madureira', 'Arte, Cultura e Religião', '6'],
                ['Cezinha de Madureira', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Cezinha de Madureira', 'Ciência, Tecnologia e Inovação', '2'],
                ['Cezinha de Madureira', 'Comunicações', '7'],
                ['Cezinha de Madureira', 'Defesa e Segurança', '1'],
                ['Cezinha de Madureira', 'Direito Civil e Processual Civil', '1'],
                ['Cezinha de Madureira', 'Direito Constitucional', '2'],
                ['Cezinha de Madureira', 'Direito e Defesa do Consumidor', '1'],
                ['Cezinha de Madureira', 'Direito e Justiça', '1'],
                ['Cezinha de Madureira', 'Direito Penal e Processual Penal', '3'],
                ['Cezinha de Madureira', 'Direitos Humanos e Minorias', '4'],
                ['Cezinha de Madureira', 'Economia', '2'],
                ['Cezinha de Madureira', 'Educação', '3'],
                ['Cezinha de Madureira', 'Finanças Públicas e Orçamento', '4'],
                ['Cezinha de Madureira', 'Homenagens e Datas Comemorativas', '3'],
                ['Cezinha de Madureira', 'Indústria, Comércio e Serviços', '3'],
                ['Cezinha de Madureira', 'Política, Partidos e Eleições', '1'],
                ['Cezinha de Madureira', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Cezinha de Madureira', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Cezinha de Madureira', 'Saúde', '6'],
                ['Cezinha de Madureira', 'Trabalho e Emprego', '2'],
                ['Cezinha de Madureira', 'Viação, Transporte e Mobilidade', '1'],
                ['Coronel Tadeu', 'Administração Pública', '18'],
                ['Coronel Tadeu', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['Coronel Tadeu', 'Arte, Cultura e Religião', '6'],
                ['Coronel Tadeu', 'Cidades e Desenvolvimento Urbano', '2'],
                ['Coronel Tadeu', 'Comunicações', '4'],
                ['Coronel Tadeu', 'Defesa e Segurança', '19'],
                ['Coronel Tadeu', 'Direito Civil e Processual Civil', '4'],
                ['Coronel Tadeu', 'Direito Constitucional', '2'],
                ['Coronel Tadeu', 'Direito e Defesa do Consumidor', '4'],
                ['Coronel Tadeu', 'Direito e Justiça', '1'],
                ['Coronel Tadeu', 'Direito Penal e Processual Penal', '27'],
                ['Coronel Tadeu', 'Direitos Humanos e Minorias', '12'],
                ['Coronel Tadeu', 'Economia', '2'],
                ['Coronel Tadeu', 'Educação', '2'],
                ['Coronel Tadeu', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Coronel Tadeu', 'Esporte e Lazer', '1'],
                ['Coronel Tadeu', 'Estrutura Fundiária', '2'],
                ['Coronel Tadeu', 'Finanças Públicas e Orçamento', '8'],
                ['Coronel Tadeu', 'Homenagens e Datas Comemorativas', '6'],
                ['Coronel Tadeu', 'Indústria, Comércio e Serviços', '5'],
                ['Coronel Tadeu', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Coronel Tadeu', 'Política, Partidos e Eleições', '4'],
                ['Coronel Tadeu', 'Previdência e Assistência Social', '2'],
                ['Coronel Tadeu', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Coronel Tadeu', 'Saúde', '14'],
                ['Coronel Tadeu', 'Trabalho e Emprego', '13'],
                ['Coronel Tadeu', 'Viação, Transporte e Mobilidade', '9'],
                ['David Soares', 'Administração Pública', '7'],
                ['David Soares', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['David Soares', 'Arte, Cultura e Religião', '2'],
                ['David Soares', 'Cidades e Desenvolvimento Urbano', '1'],
                ['David Soares', 'Ciência, Tecnologia e Inovação', '3'],
                ['David Soares', 'Comunicações', '6'],
                ['David Soares', 'Defesa e Segurança', '5'],
                ['David Soares', 'Direito Civil e Processual Civil', '5'],
                ['David Soares', 'Direito Constitucional', '1'],
                ['David Soares', 'Direito e Defesa do Consumidor', '2'],
                ['David Soares', 'Direito e Justiça', '1'],
                ['David Soares', 'Direito Penal e Processual Penal', '10'],
                ['David Soares', 'Direitos Humanos e Minorias', '23'],
                ['David Soares', 'Economia', '4'],
                ['David Soares', 'Educação', '8'],
                ['David Soares', 'Energia, Recursos Hídricos e Minerais', '2'],
                ['David Soares', 'Esporte e Lazer', '1'],
                ['David Soares', 'Finanças Públicas e Orçamento', '9'],
                ['David Soares', 'Homenagens e Datas Comemorativas', '1'],
                ['David Soares', 'Indústria, Comércio e Serviços', '8'],
                ['David Soares', 'Meio Ambiente e Desenvolvimento Sustentável', '6'],
                ['David Soares', 'Previdência e Assistência Social', '3'],
                ['David Soares', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['David Soares', 'Saúde', '12'],
                ['David Soares', 'Trabalho e Emprego', '6'],
                ['David Soares', 'Viação, Transporte e Mobilidade', '7'],
                ['Dr. Sinval Malheiros', 'Direitos Humanos e Minorias', '2'],
                ['Dr. Sinval Malheiros', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Dr. Sinval Malheiros', 'Finanças Públicas e Orçamento', '2'],
                ['Dr. Sinval Malheiros', 'Homenagens e Datas Comemorativas', '1'],
                ['Dr. Sinval Malheiros', 'Saúde', '5'],
                ['Dr. Sinval Malheiros', 'Trabalho e Emprego', '3'],
                ['Dr. Sinval Malheiros', 'Viação, Transporte e Mobilidade', '2'],
                ['Eduardo Bolsonaro', 'Administração Pública', '3'],
                ['Eduardo Bolsonaro', 'Comunicações', '1'],
                ['Eduardo Bolsonaro', 'Defesa e Segurança', '2'],
                ['Eduardo Bolsonaro', 'Direito Penal e Processual Penal', '5'],
                ['Eduardo Bolsonaro', 'Direitos Humanos e Minorias', '4'],
                ['Eduardo Bolsonaro', 'Economia', '1'],
                ['Eduardo Bolsonaro', 'Educação', '5'],
                ['Eduardo Bolsonaro', 'Finanças Públicas e Orçamento', '1'],
                ['Eduardo Bolsonaro', 'Homenagens e Datas Comemorativas', '3'],
                ['Eduardo Bolsonaro', 'Indústria, Comércio e Serviços', '1'],
                ['Eduardo Bolsonaro', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Eduardo Bolsonaro', 'Política, Partidos e Eleições', '2'],
                ['Eduardo Bolsonaro', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Eduardo Bolsonaro', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Eduardo Bolsonaro', 'Saúde', '7'],
                ['Eduardo Bolsonaro', 'Viação, Transporte e Mobilidade', '1'],
                ['Eduardo Cury', 'Administração Pública', '3'],
                ['Eduardo Cury', 'Ciência, Tecnologia e Inovação', '2'],
                ['Eduardo Cury', 'Defesa e Segurança', '1'],
                ['Eduardo Cury', 'Direito e Justiça', '1'],
                ['Eduardo Cury', 'Direito Penal e Processual Penal', '1'],
                ['Eduardo Cury', 'Direitos Humanos e Minorias', '1'],
                ['Eduardo Cury', 'Economia', '2'],
                ['Eduardo Cury', 'Finanças Públicas e Orçamento', '3'],
                ['Eduardo Cury', 'Homenagens e Datas Comemorativas', '1'],
                ['Eduardo Cury', 'Indústria, Comércio e Serviços', '2'],
                ['Eduardo Cury', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Eduardo Cury', 'Previdência e Assistência Social', '2'],
                ['Eduardo Cury', 'Saúde', '1'],
                ['Eli Corrêa Filho', 'Administração Pública', '1'],
                ['Eli Corrêa Filho', 'Defesa e Segurança', '1'],
                ['Eli Corrêa Filho', 'Direito Civil e Processual Civil', '3'],
                ['Eli Corrêa Filho', 'Direito e Defesa do Consumidor', '1'],
                ['Eli Corrêa Filho', 'Direitos Humanos e Minorias', '1'],
                ['Eli Corrêa Filho', 'Política, Partidos e Eleições', '2'],
                ['Eli Corrêa Filho', 'Saúde', '1'],
                ['Eli Corrêa Filho', 'Viação, Transporte e Mobilidade', '1'],
                ['Ely Santos', 'Administração Pública', '1'],
                ['Ely Santos', 'Direitos Humanos e Minorias', '3'],
                ['Ely Santos', 'Educação', '1'],
                ['Ely Santos', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Enrico Misasi', 'Administração Pública', '5'],
                ['Enrico Misasi', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['Enrico Misasi', 'Defesa e Segurança', '1'],
                ['Enrico Misasi', 'Direito Civil e Processual Civil', '1'],
                ['Enrico Misasi', 'Direito Penal e Processual Penal', '1'],
                ['Enrico Misasi', 'Direitos Humanos e Minorias', '3'],
                ['Enrico Misasi', 'Economia', '1'],
                ['Enrico Misasi', 'Educação', '2'],
                ['Enrico Misasi', 'Finanças Públicas e Orçamento', '5'],
                ['Enrico Misasi', 'Indústria, Comércio e Serviços', '3'],
                ['Enrico Misasi', 'Meio Ambiente e Desenvolvimento Sustentável', '4'],
                ['Enrico Misasi', 'Previdência e Assistência Social', '3'],
                ['Enrico Misasi', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Enrico Misasi', 'Saúde', '6'],
                ['Enrico Misasi', 'Trabalho e Emprego', '3'],
                ['Enrico Misasi', 'Turismo', '1'],
                ['Fausto Pinato', 'Administração Pública', '8'],
                ['Fausto Pinato', 'Agricultura, Pecuária, Pesca e Extrativismo', '5'],
                ['Fausto Pinato', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Fausto Pinato', 'Ciência, Tecnologia e Inovação', '1'],
                ['Fausto Pinato', 'Defesa e Segurança', '2'],
                ['Fausto Pinato', 'Direito Civil e Processual Civil', '4'],
                ['Fausto Pinato', 'Direito e Justiça', '3'],
                ['Fausto Pinato', 'Direito Penal e Processual Penal', '4'],
                ['Fausto Pinato', 'Direitos Humanos e Minorias', '4'],
                ['Fausto Pinato', 'Economia', '3'],
                ['Fausto Pinato', 'Energia, Recursos Hídricos e Minerais', '2'],
                ['Fausto Pinato', 'Esporte e Lazer', '1'],
                ['Fausto Pinato', 'Estrutura Fundiária', '1'],
                ['Fausto Pinato', 'Finanças Públicas e Orçamento', '13'],
                ['Fausto Pinato', 'Homenagens e Datas Comemorativas', '1'],
                ['Fausto Pinato', 'Indústria, Comércio e Serviços', '5'],
                ['Fausto Pinato', 'Previdência e Assistência Social', '1'],
                ['Fausto Pinato', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Fausto Pinato', 'Saúde', '7'],
                ['Fausto Pinato', 'Trabalho e Emprego', '3'],
                ['Fausto Pinato', 'Viação, Transporte e Mobilidade', '5'],
                ['General Peternelli', 'Administração Pública', '10'],
                ['General Peternelli', 'Cidades e Desenvolvimento Urbano', '1'],
                ['General Peternelli', 'Ciência, Tecnologia e Inovação', '1'],
                ['General Peternelli', 'Comunicações', '2'],
                ['General Peternelli', 'Defesa e Segurança', '1'],
                ['General Peternelli', 'Direito Civil e Processual Civil', '3'],
                ['General Peternelli', 'Direito e Justiça', '1'],
                ['General Peternelli', 'Direito Penal e Processual Penal', '1'],
                ['General Peternelli', 'Direitos Humanos e Minorias', '9'],
                ['General Peternelli', 'Educação', '13'],
                ['General Peternelli', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['General Peternelli', 'Finanças Públicas e Orçamento', '7'],
                ['General Peternelli', 'Indústria, Comércio e Serviços', '2'],
                ['General Peternelli', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['General Peternelli', 'Política, Partidos e Eleições', '1'],
                ['General Peternelli', 'Previdência e Assistência Social', '2'],
                ['General Peternelli', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['General Peternelli', 'Saúde', '22'],
                ['General Peternelli', 'Trabalho e Emprego', '3'],
                ['General Peternelli', 'Viação, Transporte e Mobilidade', '2'],
                ['General Peternelli', 'NA', '1'],
                ['Geninho Zuliani', 'Saúde', '45'],
                ['Geninho Zuliani', 'Finanças Públicas e Orçamento', '32'],
                ['Geninho Zuliani', 'Direitos Humanos e Minorias', '30'],
                ['Geninho Zuliani', 'Direito Civil e Processual Civil', '24'],
                ['Geninho Zuliani', 'Administração Pública', '20'],
                ['Geninho Zuliani', 'Trabalho e Emprego', '17'],
                ['Geninho Zuliani', 'Cidades e Desenvolvimento Urbano', '12'],
                ['Geninho Zuliani', 'Meio Ambiente e Desenvolvimento Sustentável', '10'],
                ['Geninho Zuliani', 'Educação', '8'],
                ['Geninho Zuliani', 'Homenagens e Datas Comemorativas', '8'],
                ['Geninho Zuliani', 'Indústria, Comércio e Serviços', '8'],
                ['Geninho Zuliani', 'Previdência e Assistência Social', '8'],
                ['Geninho Zuliani', 'Direito Penal e Processual Penal', '7'],
                ['Geninho Zuliani', 'Energia, Recursos Hídricos e Minerais', '7'],
                ['Geninho Zuliani', 'Ciência, Tecnologia e Inovação', '5'],
                ['Geninho Zuliani', 'Viação, Transporte e Mobilidade', '5'],
                ['Geninho Zuliani', 'Direito e Defesa do Consumidor', '4'],
                ['Geninho Zuliani', 'Agricultura, Pecuária, Pesca e Extrativismo', '3'],
                ['Geninho Zuliani', 'Arte, Cultura e Religião', '3'],
                ['Geninho Zuliani', 'Defesa e Segurança', '3'],
                ['Geninho Zuliani', 'Economia', '3'],
                ['Geninho Zuliani', 'Turismo', '3'],
                ['Geninho Zuliani', 'Comunicações', '2'],
                ['Geninho Zuliani', 'Direito e Justiça', '1'],
                ['Geninho Zuliani', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Geninho Zuliani', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Gilberto Nascimento', 'Arte, Cultura e Religião', '2'],
                ['Gilberto Nascimento', 'Direitos Humanos e Minorias', '2'],
                ['Gilberto Nascimento', 'Finanças Públicas e Orçamento', '2'],
                ['Gilberto Nascimento', 'Homenagens e Datas Comemorativas', '2'],
                ['Gilberto Nascimento', 'Previdência e Assistência Social', '1'],
                ['Gilberto Nascimento', 'Saúde', '4'],
                ['Guiga Peixoto', 'Administração Pública', '5'],
                ['Guiga Peixoto', 'Cidades e Desenvolvimento Urbano', '4'],
                ['Guiga Peixoto', 'Defesa e Segurança', '1'],
                ['Guiga Peixoto', 'Direito Civil e Processual Civil', '2'],
                ['Guiga Peixoto', 'Direito e Defesa do Consumidor', '1'],
                ['Guiga Peixoto', 'Direito Penal e Processual Penal', '9'],
                ['Guiga Peixoto', 'Direitos Humanos e Minorias', '8'],
                ['Guiga Peixoto', 'Educação', '4'],
                ['Guiga Peixoto', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Guiga Peixoto', 'Finanças Públicas e Orçamento', '6'],
                ['Guiga Peixoto', 'Homenagens e Datas Comemorativas', '2'],
                ['Guiga Peixoto', 'Indústria, Comércio e Serviços', '1'],
                ['Guiga Peixoto', 'Política, Partidos e Eleições', '2'],
                ['Guiga Peixoto', 'Previdência e Assistência Social', '2'],
                ['Guiga Peixoto', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Guiga Peixoto', 'Saúde', '6'],
                ['Guiga Peixoto', 'Trabalho e Emprego', '3'],
                ['Guiga Peixoto', 'Viação, Transporte e Mobilidade', '2'],
                ['Guilherme Derrite', 'Administração Pública', '18'],
                ['Guilherme Derrite', 'Ciência, Tecnologia e Inovação', '1'],
                ['Guilherme Derrite', 'Comunicações', '2'],
                ['Guilherme Derrite', 'Defesa e Segurança', '30'],
                ['Guilherme Derrite', 'Direito Civil e Processual Civil', '1'],
                ['Guilherme Derrite', 'Direito Constitucional', '1'],
                ['Guilherme Derrite', 'Direito e Justiça', '3'],
                ['Guilherme Derrite', 'Direito Penal e Processual Penal', '33'],
                ['Guilherme Derrite', 'Direitos Humanos e Minorias', '11'],
                ['Guilherme Derrite', 'Educação', '5'],
                ['Guilherme Derrite', 'Esporte e Lazer', '3'],
                ['Guilherme Derrite', 'Finanças Públicas e Orçamento', '7'],
                ['Guilherme Derrite', 'Homenagens e Datas Comemorativas', '4'],
                ['Guilherme Derrite', 'Indústria, Comércio e Serviços', '1'],
                ['Guilherme Derrite', 'Política, Partidos e Eleições', '1'],
                ['Guilherme Derrite', 'Previdência e Assistência Social', '4'],
                ['Guilherme Derrite', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Guilherme Derrite', 'Saúde', '12'],
                ['Guilherme Derrite', 'Trabalho e Emprego', '8'],
                ['Guilherme Derrite', 'Viação, Transporte e Mobilidade', '2'],
                ['Guilherme Mussi', 'Administração Pública', '1'],
                ['Guilherme Mussi', 'Arte, Cultura e Religião', '1'],
                ['Guilherme Mussi', 'Direito e Justiça', '1'],
                ['Guilherme Mussi', 'Direito Penal e Processual Penal', '1'],
                ['Guilherme Mussi', 'Direitos Humanos e Minorias', '2'],
                ['Guilherme Mussi', 'Economia', '1'],
                ['Guilherme Mussi', 'Finanças Públicas e Orçamento', '2'],
                ['Guilherme Mussi', 'Homenagens e Datas Comemorativas', '1'],
                ['Guilherme Mussi', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Guilherme Mussi', 'Saúde', '3'],
                ['Guilherme Mussi', 'Trabalho e Emprego', '1'],
                ['Henrique do Paraíso', 'Administração Pública', '1'],
                ['Henrique do Paraíso', 'Direito e Defesa do Consumidor', '1'],
                ['Henrique do Paraíso', 'Direitos Humanos e Minorias', '1'],
                ['Henrique do Paraíso', 'Economia', '1'],
                ['Henrique do Paraíso', 'Finanças Públicas e Orçamento', '1'],
                ['Henrique do Paraíso', 'Indústria, Comércio e Serviços', '1'],
                ['Henrique do Paraíso', 'Viação, Transporte e Mobilidade', '1'],
                ['Herculano Passos', 'Administração Pública', '3'],
                ['Herculano Passos', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['Herculano Passos', 'Ciência, Tecnologia e Inovação', '1'],
                ['Herculano Passos', 'Defesa e Segurança', '2'],
                ['Herculano Passos', 'Direito e Defesa do Consumidor', '1'],
                ['Herculano Passos', 'Direito e Justiça', '1'],
                ['Herculano Passos', 'Direito Penal e Processual Penal', '1'],
                ['Herculano Passos', 'Direitos Humanos e Minorias', '1'],
                ['Herculano Passos', 'Educação', '1'],
                ['Herculano Passos', 'Finanças Públicas e Orçamento', '4'],
                ['Herculano Passos', 'Indústria, Comércio e Serviços', '2'],
                ['Herculano Passos', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Herculano Passos', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Herculano Passos', 'Saúde', '5'],
                ['Herculano Passos', 'Trabalho e Emprego', '1'],
                ['Herculano Passos', 'Turismo', '1'],
                ['Herculano Passos', 'Viação, Transporte e Mobilidade', '1'],
                ['Ivan Valente', 'Administração Pública', '63'],
                ['Ivan Valente', 'Direitos Humanos e Minorias', '59'],
                ['Ivan Valente', 'Saúde', '50'],
                ['Ivan Valente', 'Finanças Públicas e Orçamento', '34'],
                ['Ivan Valente', 'Trabalho e Emprego', '29'],
                ['Ivan Valente', 'Defesa e Segurança', '22'],
                ['Ivan Valente', 'Educação', '21'],
                ['Ivan Valente', 'Previdência e Assistência Social', '18'],
                ['Ivan Valente', 'Meio Ambiente e Desenvolvimento Sustentável', '15'],
                ['Ivan Valente', 'Comunicações', '10'],
                ['Ivan Valente', 'Indústria, Comércio e Serviços', '10'],
                ['Ivan Valente', 'Direito Penal e Processual Penal', '9'],
                ['Ivan Valente', 'Economia', '9'],
                ['Ivan Valente', 'Direito e Defesa do Consumidor', '8'],
                ['Ivan Valente', 'Energia, Recursos Hídricos e Minerais', '8'],
                ['Ivan Valente', 'Homenagens e Datas Comemorativas', '7'],
                ['Ivan Valente', 'Agricultura, Pecuária, Pesca e Extrativismo', '5'],
                ['Ivan Valente', 'Direito Civil e Processual Civil', '5'],
                ['Ivan Valente', 'Arte, Cultura e Religião', '4'],
                ['Ivan Valente', 'Ciência, Tecnologia e Inovação', '4'],
                ['Ivan Valente', 'Estrutura Fundiária', '3'],
                ['Ivan Valente', 'Relações Internacionais e Comércio Exterior', '3'],
                ['Ivan Valente', 'Política, Partidos e Eleições', '2'],
                ['Ivan Valente', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Ivan Valente', 'Direito Constitucional', '1'],
                ['Ivan Valente', 'Direito e Justiça', '1'],
                ['Ivan Valente', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Ivan Valente', 'Viação, Transporte e Mobilidade', '1'],
                ['Jefferson Campos', 'Administração Pública', '3'],
                ['Jefferson Campos', 'Ciência, Tecnologia e Inovação', '1'],
                ['Jefferson Campos', 'Comunicações', '1'],
                ['Jefferson Campos', 'Defesa e Segurança', '1'],
                ['Jefferson Campos', 'Direito Civil e Processual Civil', '2'],
                ['Jefferson Campos', 'Direito e Justiça', '1'],
                ['Jefferson Campos', 'Direito Penal e Processual Penal', '2'],
                ['Jefferson Campos', 'Direitos Humanos e Minorias', '4'],
                ['Jefferson Campos', 'Economia', '1'],
                ['Jefferson Campos', 'Finanças Públicas e Orçamento', '2'],
                ['Jefferson Campos', 'Homenagens e Datas Comemorativas', '2'],
                ['Jefferson Campos', 'Indústria, Comércio e Serviços', '1'],
                ['Jefferson Campos', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Jefferson Campos', 'Política, Partidos e Eleições', '1'],
                ['Jefferson Campos', 'Previdência e Assistência Social', '2'],
                ['Jefferson Campos', 'Saúde', '4'],
                ['Jefferson Campos', 'Trabalho e Emprego', '2'],
                ['Jefferson Campos', 'Viação, Transporte e Mobilidade', '3'],
                ['Joice Hasselmann', 'Administração Pública', '13'],
                ['Joice Hasselmann', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Joice Hasselmann', 'Ciência, Tecnologia e Inovação', '4'],
                ['Joice Hasselmann', 'Comunicações', '4'],
                ['Joice Hasselmann', 'Defesa e Segurança', '6'],
                ['Joice Hasselmann', 'Direito Civil e Processual Civil', '3'],
                ['Joice Hasselmann', 'Direito Constitucional', '3'],
                ['Joice Hasselmann', 'Direito e Justiça', '1'],
                ['Joice Hasselmann', 'Direito Penal e Processual Penal', '7'],
                ['Joice Hasselmann', 'Direitos Humanos e Minorias', '12'],
                ['Joice Hasselmann', 'Economia', '3'],
                ['Joice Hasselmann', 'Educação', '4'],
                ['Joice Hasselmann', 'Finanças Públicas e Orçamento', '11'],
                ['Joice Hasselmann', 'Indústria, Comércio e Serviços', '11'],
                ['Joice Hasselmann', 'Meio Ambiente e Desenvolvimento Sustentável', '2'],
                ['Joice Hasselmann', 'Política, Partidos e Eleições', '1'],
                ['Joice Hasselmann', 'Previdência e Assistência Social', '1'],
                ['Joice Hasselmann', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Joice Hasselmann', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Joice Hasselmann', 'Saúde', '17'],
                ['Joice Hasselmann', 'Trabalho e Emprego', '8'],
                ['Joice Hasselmann', 'Turismo', '1'],
                ['Joice Hasselmann', 'Viação, Transporte e Mobilidade', '1'],
                ['José Mentor', 'Trabalho e Emprego', '1'],
                ['Júnior Bozzella', 'Administração Pública', '5'],
                ['Júnior Bozzella', 'Arte, Cultura e Religião', '1'],
                ['Júnior Bozzella', 'Ciência, Tecnologia e Inovação', '1'],
                ['Júnior Bozzella', 'Comunicações', '1'],
                ['Júnior Bozzella', 'Defesa e Segurança', '3'],
                ['Júnior Bozzella', 'Direito Civil e Processual Civil', '4'],
                ['Júnior Bozzella', 'Direito Constitucional', '1'],
                ['Júnior Bozzella', 'Direito e Defesa do Consumidor', '3'],
                ['Júnior Bozzella', 'Direito e Justiça', '1'],
                ['Júnior Bozzella', 'Direito Penal e Processual Penal', '10'],
                ['Júnior Bozzella', 'Direitos Humanos e Minorias', '12'],
                ['Júnior Bozzella', 'Economia', '2'],
                ['Júnior Bozzella', 'Educação', '3'],
                ['Júnior Bozzella', 'Finanças Públicas e Orçamento', '3'],
                ['Júnior Bozzella', 'Homenagens e Datas Comemorativas', '1'],
                ['Júnior Bozzella', 'Indústria, Comércio e Serviços', '2'],
                ['Júnior Bozzella', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Júnior Bozzella', 'Saúde', '5'],
                ['Júnior Bozzella', 'Trabalho e Emprego', '7'],
                ['Júnior Bozzella', 'Viação, Transporte e Mobilidade', '2'],
                ['Kim Kataguiri', 'Administração Pública', '38'],
                ['Kim Kataguiri', 'Direito Penal e Processual Penal', '26'],
                ['Kim Kataguiri', 'Saúde', '22'],
                ['Kim Kataguiri', 'Finanças Públicas e Orçamento', '15'],
                ['Kim Kataguiri', 'Direito Civil e Processual Civil', '14'],
                ['Kim Kataguiri', 'Trabalho e Emprego', '14'],
                ['Kim Kataguiri', 'Política, Partidos e Eleições', '10'],
                ['Kim Kataguiri', 'Viação, Transporte e Mobilidade', '10'],
                ['Kim Kataguiri', 'Defesa e Segurança', '8'],
                ['Kim Kataguiri', 'Direitos Humanos e Minorias', '8'],
                ['Kim Kataguiri', 'Economia', '8'],
                ['Kim Kataguiri', 'Energia, Recursos Hídricos e Minerais', '6'],
                ['Kim Kataguiri', 'Indústria, Comércio e Serviços', '6'],
                ['Kim Kataguiri', 'Meio Ambiente e Desenvolvimento Sustentável', '6'],
                ['Kim Kataguiri', 'Ciência, Tecnologia e Inovação', '5'],
                ['Kim Kataguiri', 'Comunicações', '5'],
                ['Kim Kataguiri', 'Direito e Defesa do Consumidor', '5'],
                ['Kim Kataguiri', 'Processo Legislativo e Atuação Parlamentar', '5'],
                ['Kim Kataguiri', 'Educação', '4'],
                ['Kim Kataguiri', 'Direito e Justiça', '3'],
                ['Kim Kataguiri', 'Homenagens e Datas Comemorativas', '3'],
                ['Kim Kataguiri', 'Direito Constitucional', '2'],
                ['Kim Kataguiri', 'Previdência e Assistência Social', '2'],
                ['Kim Kataguiri', 'Arte, Cultura e Religião', '1'],
                ['Kim Kataguiri', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Luiz Carlos Motta', 'Administração Pública', '2'],
                ['Luiz Carlos Motta', 'Direito Civil e Processual Civil', '2'],
                ['Luiz Carlos Motta', 'Direito e Justiça', '1'],
                ['Luiz Carlos Motta', 'Direito Penal e Processual Penal', '1'],
                ['Luiz Carlos Motta', 'Direitos Humanos e Minorias', '4'],
                ['Luiz Carlos Motta', 'Educação', '2'],
                ['Luiz Carlos Motta', 'Finanças Públicas e Orçamento', '7'],
                ['Luiz Carlos Motta', 'Homenagens e Datas Comemorativas', '2'],
                ['Luiz Carlos Motta', 'Indústria, Comércio e Serviços', '4'],
                ['Luiz Carlos Motta', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Luiz Carlos Motta', 'Previdência e Assistência Social', '2'],
                ['Luiz Carlos Motta', 'Saúde', '11'],
                ['Luiz Carlos Motta', 'Trabalho e Emprego', '13'],
                ['Luiz Carlos Motta', 'Viação, Transporte e Mobilidade', '1'],
                ['Luiz Flávio Gomes', 'Administração Pública', '8'],
                ['Luiz Flávio Gomes', 'Defesa e Segurança', '1'],
                ['Luiz Flávio Gomes', 'Direito Civil e Processual Civil', '1'],
                ['Luiz Flávio Gomes', 'Direito e Justiça', '2'],
                ['Luiz Flávio Gomes', 'Direito Penal e Processual Penal', '11'],
                ['Luiz Flávio Gomes', 'Direitos Humanos e Minorias', '7'],
                ['Luiz Flávio Gomes', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Luiz Flávio Gomes', 'Finanças Públicas e Orçamento', '1'],
                ['Luiz Flávio Gomes', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Luiz Flávio Gomes', 'Política, Partidos e Eleições', '1'],
                ['Luiz Flávio Gomes', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Luiz Flávio Gomes', 'Trabalho e Emprego', '1'],
                ['Luiz Flávio Gomes', 'Viação, Transporte e Mobilidade', '4'],
                ['Luiz Philippe de Orleans e Bragança', 'Administração Pública', '26'],
                ['Luiz Philippe de Orleans e Bragança', 'Arte, Cultura e Religião', '5'],
                ['Luiz Philippe de Orleans e Bragança', 'Ciência, Tecnologia e Inovação', '6'],
                ['Luiz Philippe de Orleans e Bragança', 'Comunicações', '8'],
                ['Luiz Philippe de Orleans e Bragança', 'Defesa e Segurança', '13'],
                ['Luiz Philippe de Orleans e Bragança', 'Direito Civil e Processual Civil', '13'],
                ['Luiz Philippe de Orleans e Bragança', 'Direito Constitucional', '9'],
                ['Luiz Philippe de Orleans e Bragança', 'Direito e Defesa do Consumidor', '4'],
                ['Luiz Philippe de Orleans e Bragança', 'Direito e Justiça', '1'],
                ['Luiz Philippe de Orleans e Bragança', 'Direito Penal e Processual Penal', '19'],
                ['Luiz Philippe de Orleans e Bragança', 'Direitos Humanos e Minorias', '10'],
                ['Luiz Philippe de Orleans e Bragança', 'Economia', '11'],
                ['Luiz Philippe de Orleans e Bragança', 'Educação', '1'],
                ['Luiz Philippe de Orleans e Bragança', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Luiz Philippe de Orleans e Bragança', 'Finanças Públicas e Orçamento', '17'],
                ['Luiz Philippe de Orleans e Bragança', 'Homenagens e Datas Comemorativas', '3'],
                ['Luiz Philippe de Orleans e Bragança', 'Indústria, Comércio e Serviços', '5'],
                ['Luiz Philippe de Orleans e Bragança', 'Política, Partidos e Eleições', '10'],
                ['Luiz Philippe de Orleans e Bragança', 'Previdência e Assistência Social', '2'],
                ['Luiz Philippe de Orleans e Bragança', 'Processo Legislativo e Atuação Parlamentar', '3'],
                ['Luiz Philippe de Orleans e Bragança', 'Relações Internacionais e Comércio Exterior', '2'],
                ['Luiz Philippe de Orleans e Bragança', 'Saúde', '4'],
                ['Luiz Philippe de Orleans e Bragança', 'Trabalho e Emprego', '8'],
                ['Luiz Philippe de Orleans e Bragança', 'NA', '1'],
                ['Luiza Erundina', 'Administração Pública', '48'],
                ['Luiza Erundina', 'Agricultura, Pecuária, Pesca e Extrativismo', '4'],
                ['Luiza Erundina', 'Arte, Cultura e Religião', '5'],
                ['Luiza Erundina', 'Ciência, Tecnologia e Inovação', '4'],
                ['Luiza Erundina', 'Comunicações', '13'],
                ['Luiza Erundina', 'Defesa e Segurança', '22'],
                ['Luiza Erundina', 'Direito Civil e Processual Civil', '5'],
                ['Luiza Erundina', 'Direito Constitucional', '2'],
                ['Luiza Erundina', 'Direito e Defesa do Consumidor', '4'],
                ['Luiza Erundina', 'Direito e Justiça', '1'],
                ['Luiza Erundina', 'Direito Penal e Processual Penal', '7'],
                ['Luiza Erundina', 'Direitos Humanos e Minorias', '67'],
                ['Luiza Erundina', 'Economia', '10'],
                ['Luiza Erundina', 'Educação', '19'],
                ['Luiza Erundina', 'Energia, Recursos Hídricos e Minerais', '8'],
                ['Luiza Erundina', 'Estrutura Fundiária', '2'],
                ['Luiza Erundina', 'Finanças Públicas e Orçamento', '31'],
                ['Luiza Erundina', 'Homenagens e Datas Comemorativas', '4'],
                ['Luiza Erundina', 'Indústria, Comércio e Serviços', '10'],
                ['Luiza Erundina', 'Meio Ambiente e Desenvolvimento Sustentável', '13'],
                ['Luiza Erundina', 'Política, Partidos e Eleições', '2'],
                ['Luiza Erundina', 'Previdência e Assistência Social', '26'],
                ['Luiza Erundina', 'Relações Internacionais e Comércio Exterior', '2'],
                ['Luiza Erundina', 'Saúde', '62'],
                ['Luiza Erundina', 'Trabalho e Emprego', '31'],
                ['Luiza Erundina', 'Viação, Transporte e Mobilidade', '2'],
                ['Marcio Alvino', 'Administração Pública', '1'],
                ['Marcio Alvino', 'Direito e Justiça', '1'],
                ['Marcio Alvino', 'Direitos Humanos e Minorias', '3'],
                ['Marcio Alvino', 'Educação', '1'],
                ['Marcio Alvino', 'Homenagens e Datas Comemorativas', '2'],
                ['Marcio Alvino', 'Saúde', '3'],
                ['Marcio Alvino', 'Trabalho e Emprego', '1'],
                ['Marcio Alvino', 'Viação, Transporte e Mobilidade', '1'],
                ['Marco Bertaiolli', 'Administração Pública', '3'],
                ['Marco Bertaiolli', 'Ciência, Tecnologia e Inovação', '1'],
                ['Marco Bertaiolli', 'Defesa e Segurança', '1'],
                ['Marco Bertaiolli', 'Direito e Defesa do Consumidor', '2'],
                ['Marco Bertaiolli', 'Direito e Justiça', '1'],
                ['Marco Bertaiolli', 'Direitos Humanos e Minorias', '3'],
                ['Marco Bertaiolli', 'Economia', '1'],
                ['Marco Bertaiolli', 'Finanças Públicas e Orçamento', '3'],
                ['Marco Bertaiolli', 'Homenagens e Datas Comemorativas', '1'],
                ['Marco Bertaiolli', 'Indústria, Comércio e Serviços', '4'],
                ['Marco Bertaiolli', 'Previdência e Assistência Social', '2'],
                ['Marco Bertaiolli', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Marco Bertaiolli', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Marco Bertaiolli', 'Saúde', '1'],
                ['Marco Bertaiolli', 'Trabalho e Emprego', '2'],
                ['Marco Bertaiolli', 'Viação, Transporte e Mobilidade', '1'],
                ['Marcos Pereira', 'Administração Pública', '7'],
                ['Marcos Pereira', 'Ciência, Tecnologia e Inovação', '5'],
                ['Marcos Pereira', 'Direito Civil e Processual Civil', '3'],
                ['Marcos Pereira', 'Direitos Humanos e Minorias', '3'],
                ['Marcos Pereira', 'Economia', '1'],
                ['Marcos Pereira', 'Finanças Públicas e Orçamento', '8'],
                ['Marcos Pereira', 'Homenagens e Datas Comemorativas', '1'],
                ['Marcos Pereira', 'Indústria, Comércio e Serviços', '1'],
                ['Marcos Pereira', 'Política, Partidos e Eleições', '1'],
                ['Marcos Pereira', 'Previdência e Assistência Social', '2'],
                ['Marcos Pereira', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Marcos Pereira', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Marcos Pereira', 'Saúde', '1'],
                ['Marcos Pereira', 'Trabalho e Emprego', '5'],
                ['Marcos Pereira', 'Turismo', '1'],
                ['Maria Rosas', 'Administração Pública', '4'],
                ['Maria Rosas', 'Arte, Cultura e Religião', '2'],
                ['Maria Rosas', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Maria Rosas', 'Ciência, Tecnologia e Inovação', '3'],
                ['Maria Rosas', 'Defesa e Segurança', '2'],
                ['Maria Rosas', 'Direito Civil e Processual Civil', '1'],
                ['Maria Rosas', 'Direito e Defesa do Consumidor', '2'],
                ['Maria Rosas', 'Direito Penal e Processual Penal', '2'],
                ['Maria Rosas', 'Direitos Humanos e Minorias', '23'],
                ['Maria Rosas', 'Educação', '7'],
                ['Maria Rosas', 'Finanças Públicas e Orçamento', '4'],
                ['Maria Rosas', 'Homenagens e Datas Comemorativas', '1'],
                ['Maria Rosas', 'Indústria, Comércio e Serviços', '4'],
                ['Maria Rosas', 'Previdência e Assistência Social', '1'],
                ['Maria Rosas', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Maria Rosas', 'Saúde', '14'],
                ['Maria Rosas', 'Trabalho e Emprego', '6'],
                ['Miguel Haddad', 'Administração Pública', '2'],
                ['Miguel Haddad', 'Defesa e Segurança', '2'],
                ['Miguel Haddad', 'Direitos Humanos e Minorias', '1'],
                ['Miguel Haddad', 'Finanças Públicas e Orçamento', '2'],
                ['Miguel Haddad', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Miguel Lombardi', 'Administração Pública', '3'],
                ['Miguel Lombardi', 'Defesa e Segurança', '2'],
                ['Miguel Lombardi', 'Direito Civil e Processual Civil', '1'],
                ['Miguel Lombardi', 'Direito e Defesa do Consumidor', '2'],
                ['Miguel Lombardi', 'Direito Penal e Processual Penal', '2'],
                ['Miguel Lombardi', 'Direitos Humanos e Minorias', '6'],
                ['Miguel Lombardi', 'Economia', '3'],
                ['Miguel Lombardi', 'Finanças Públicas e Orçamento', '4'],
                ['Miguel Lombardi', 'Indústria, Comércio e Serviços', '3'],
                ['Miguel Lombardi', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Miguel Lombardi', 'Política, Partidos e Eleições', '1'],
                ['Miguel Lombardi', 'Previdência e Assistência Social', '3'],
                ['Miguel Lombardi', 'Saúde', '9'],
                ['Miguel Lombardi', 'Viação, Transporte e Mobilidade', '1'],
                ['Milton Vieira', 'Administração Pública', '6'],
                ['Milton Vieira', 'Arte, Cultura e Religião', '1'],
                ['Milton Vieira', 'Ciência, Tecnologia e Inovação', '1'],
                ['Milton Vieira', 'Defesa e Segurança', '2'],
                ['Milton Vieira', 'Direito Penal e Processual Penal', '4'],
                ['Milton Vieira', 'Direitos Humanos e Minorias', '3'],
                ['Milton Vieira', 'Economia', '2'],
                ['Milton Vieira', 'Educação', '1'],
                ['Milton Vieira', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Milton Vieira', 'Finanças Públicas e Orçamento', '6'],
                ['Milton Vieira', 'Homenagens e Datas Comemorativas', '1'],
                ['Milton Vieira', 'Indústria, Comércio e Serviços', '2'],
                ['Milton Vieira', 'Previdência e Assistência Social', '1'],
                ['Milton Vieira', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Milton Vieira', 'Saúde', '7'],
                ['Milton Vieira', 'Trabalho e Emprego', '1'],
                ['Milton Vieira', 'Turismo', '1'],
                ['Milton Vieira', 'Viação, Transporte e Mobilidade', '1'],
                ['Nilto Tatto', 'Direitos Humanos e Minorias', '82'],
                ['Nilto Tatto', 'Saúde', '80'],
                ['Nilto Tatto', 'Administração Pública', '67'],
                ['Nilto Tatto', 'Meio Ambiente e Desenvolvimento Sustentável', '48'],
                ['Nilto Tatto', 'Trabalho e Emprego', '45'],
                ['Nilto Tatto', 'Finanças Públicas e Orçamento', '41'],
                ['Nilto Tatto', 'Educação', '29'],
                ['Nilto Tatto', 'Previdência e Assistência Social', '29'],
                ['Nilto Tatto', 'Agricultura, Pecuária, Pesca e Extrativismo', '24'],
                ['Nilto Tatto', 'Defesa e Segurança', '24'],
                ['Nilto Tatto', 'Indústria, Comércio e Serviços', '23'],
                ['Nilto Tatto', 'Economia', '16'],
                ['Nilto Tatto', 'Direito Penal e Processual Penal', '14'],
                ['Nilto Tatto', 'Energia, Recursos Hídricos e Minerais', '13'],
                ['Nilto Tatto', 'Comunicações', '10'],
                ['Nilto Tatto', 'Estrutura Fundiária', '9'],
                ['Nilto Tatto', 'Homenagens e Datas Comemorativas', '9'],
                ['Nilto Tatto', 'Ciência, Tecnologia e Inovação', '8'],
                ['Nilto Tatto', 'Arte, Cultura e Religião', '7'],
                ['Nilto Tatto', 'Direito e Defesa do Consumidor', '7'],
                ['Nilto Tatto', 'Viação, Transporte e Mobilidade', '6'],
                ['Nilto Tatto', 'Cidades e Desenvolvimento Urbano', '5'],
                ['Nilto Tatto', 'Relações Internacionais e Comércio Exterior', '5'],
                ['Nilto Tatto', 'Direito Civil e Processual Civil', '4'],
                ['Nilto Tatto', 'Direito Constitucional', '3'],
                ['Nilto Tatto', 'Política, Partidos e Eleições', '3'],
                ['Nilto Tatto', 'Direito e Justiça', '1'],
                ['Nilto Tatto', 'Esporte e Lazer', '1'],
                ['Nilto Tatto', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Nilto Tatto', 'NA', '1'],
                ['Orlando Silva', 'Administração Pública', '13'],
                ['Orlando Silva', 'Agricultura, Pecuária, Pesca e Extrativismo', '2'],
                ['Orlando Silva', 'Arte, Cultura e Religião', '1'],
                ['Orlando Silva', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Orlando Silva', 'Ciência, Tecnologia e Inovação', '4'],
                ['Orlando Silva', 'Comunicações', '3'],
                ['Orlando Silva', 'Defesa e Segurança', '5'],
                ['Orlando Silva', 'Direito Civil e Processual Civil', '4'],
                ['Orlando Silva', 'Direito Constitucional', '1'],
                ['Orlando Silva', 'Direito e Defesa do Consumidor', '2'],
                ['Orlando Silva', 'Direito e Justiça', '2'],
                ['Orlando Silva', 'Direito Penal e Processual Penal', '2'],
                ['Orlando Silva', 'Direitos Humanos e Minorias', '34'],
                ['Orlando Silva', 'Economia', '3'],
                ['Orlando Silva', 'Educação', '16'],
                ['Orlando Silva', 'Esporte e Lazer', '1'],
                ['Orlando Silva', 'Finanças Públicas e Orçamento', '12'],
                ['Orlando Silva', 'Homenagens e Datas Comemorativas', '4'],
                ['Orlando Silva', 'Indústria, Comércio e Serviços', '5'],
                ['Orlando Silva', 'Meio Ambiente e Desenvolvimento Sustentável', '4'],
                ['Orlando Silva', 'Política, Partidos e Eleições', '1'],
                ['Orlando Silva', 'Previdência e Assistência Social', '12'],
                ['Orlando Silva', 'Relações Internacionais e Comércio Exterior', '3'],
                ['Orlando Silva', 'Saúde', '20'],
                ['Orlando Silva', 'Trabalho e Emprego', '15'],
                ['Orlando Silva', 'Viação, Transporte e Mobilidade', '2'],
                ['Paulo Freire Costa', 'Administração Pública', '1'],
                ['Paulo Freire Costa', 'Direitos Humanos e Minorias', '1'],
                ['Paulo Freire Costa', 'Educação', '1'],
                ['Paulo Freire Costa', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Paulo Freire Costa', 'Finanças Públicas e Orçamento', '1'],
                ['Paulo Freire Costa', 'Previdência e Assistência Social', '2'],
                ['Paulo Pereira da Silva', 'Administração Pública', '1'],
                ['Paulo Pereira da Silva', 'Defesa e Segurança', '1'],
                ['Paulo Pereira da Silva', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Paulo Teixeira', 'Saúde', '82'],
                ['Paulo Teixeira', 'Direitos Humanos e Minorias', '78'],
                ['Paulo Teixeira', 'Finanças Públicas e Orçamento', '63'],
                ['Paulo Teixeira', 'Administração Pública', '59'],
                ['Paulo Teixeira', 'Trabalho e Emprego', '56'],
                ['Paulo Teixeira', 'Previdência e Assistência Social', '40'],
                ['Paulo Teixeira', 'Indústria, Comércio e Serviços', '29'],
                ['Paulo Teixeira', 'Educação', '28'],
                ['Paulo Teixeira', 'Defesa e Segurança', '27'],
                ['Paulo Teixeira', 'Economia', '24'],
                ['Paulo Teixeira', 'Agricultura, Pecuária, Pesca e Extrativismo', '16'],
                ['Paulo Teixeira', 'Comunicações', '15'],
                ['Paulo Teixeira', 'Arte, Cultura e Religião', '14'],
                ['Paulo Teixeira', 'Direito Penal e Processual Penal', '14'],
                ['Paulo Teixeira', 'Meio Ambiente e Desenvolvimento Sustentável', '13'],
                ['Paulo Teixeira', 'Direito Civil e Processual Civil', '10'],
                ['Paulo Teixeira', 'Energia, Recursos Hídricos e Minerais', '10'],
                ['Paulo Teixeira', 'Viação, Transporte e Mobilidade', '8'],
                ['Paulo Teixeira', 'Estrutura Fundiária', '7'],
                ['Paulo Teixeira', 'Direito e Defesa do Consumidor', '6'],
                ['Paulo Teixeira', 'Homenagens e Datas Comemorativas', '6'],
                ['Paulo Teixeira', 'Política, Partidos e Eleições', '6'],
                ['Paulo Teixeira', 'Relações Internacionais e Comércio Exterior', '6'],
                ['Paulo Teixeira', 'Ciência, Tecnologia e Inovação', '5'],
                ['Paulo Teixeira', 'Cidades e Desenvolvimento Urbano', '4'],
                ['Paulo Teixeira', 'Direito Constitucional', '3'],
                ['Paulo Teixeira', 'Direito e Justiça', '3'],
                ['Paulo Teixeira', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Paulo Teixeira', 'NA', '1'],
                ['Policial Katia Sastre', 'Administração Pública', '3'],
                ['Policial Katia Sastre', 'Arte, Cultura e Religião', '1'],
                ['Policial Katia Sastre', 'Ciência, Tecnologia e Inovação', '2'],
                ['Policial Katia Sastre', 'Defesa e Segurança', '17'],
                ['Policial Katia Sastre', 'Direito Civil e Processual Civil', '1'],
                ['Policial Katia Sastre', 'Direito e Justiça', '1'],
                ['Policial Katia Sastre', 'Direito Penal e Processual Penal', '21'],
                ['Policial Katia Sastre', 'Direitos Humanos e Minorias', '18'],
                ['Policial Katia Sastre', 'Educação', '8'],
                ['Policial Katia Sastre', 'Esporte e Lazer', '1'],
                ['Policial Katia Sastre', 'Finanças Públicas e Orçamento', '3'],
                ['Policial Katia Sastre', 'Homenagens e Datas Comemorativas', '1'],
                ['Policial Katia Sastre', 'Saúde', '10'],
                ['Policial Katia Sastre', 'Trabalho e Emprego', '5'],
                ['Policial Katia Sastre', 'Viação, Transporte e Mobilidade', '2'],
                ['Pr. Marco Feliciano', 'Administração Pública', '3'],
                ['Pr. Marco Feliciano', 'Arte, Cultura e Religião', '1'],
                ['Pr. Marco Feliciano', 'Ciência, Tecnologia e Inovação', '1'],
                ['Pr. Marco Feliciano', 'Comunicações', '1'],
                ['Pr. Marco Feliciano', 'Direito Civil e Processual Civil', '1'],
                ['Pr. Marco Feliciano', 'Direito Constitucional', '1'],
                ['Pr. Marco Feliciano', 'Direito e Defesa do Consumidor', '1'],
                ['Pr. Marco Feliciano', 'Direito Penal e Processual Penal', '1'],
                ['Pr. Marco Feliciano', 'Direitos Humanos e Minorias', '5'],
                ['Pr. Marco Feliciano', 'Educação', '1'],
                ['Pr. Marco Feliciano', 'Finanças Públicas e Orçamento', '2'],
                ['Pr. Marco Feliciano', 'Homenagens e Datas Comemorativas', '1'],
                ['Pr. Marco Feliciano', 'Indústria, Comércio e Serviços', '2'],
                ['Pr. Marco Feliciano', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Pr. Marco Feliciano', 'Saúde', '5'],
                ['Pr. Marco Feliciano', 'Trabalho e Emprego', '3'],
                ['Pr. Marco Feliciano', 'Viação, Transporte e Mobilidade', '1'],
                ['Pr. Marco Feliciano', 'NA', '1'],
                ['Renata Abreu', 'Administração Pública', '17'],
                ['Renata Abreu', 'Arte, Cultura e Religião', '1'],
                ['Renata Abreu', 'Ciência, Tecnologia e Inovação', '2'],
                ['Renata Abreu', 'Comunicações', '7'],
                ['Renata Abreu', 'Defesa e Segurança', '10'],
                ['Renata Abreu', 'Direito Civil e Processual Civil', '8'],
                ['Renata Abreu', 'Direito e Defesa do Consumidor', '6'],
                ['Renata Abreu', 'Direito e Justiça', '2'],
                ['Renata Abreu', 'Direito Penal e Processual Penal', '10'],
                ['Renata Abreu', 'Direitos Humanos e Minorias', '39'],
                ['Renata Abreu', 'Economia', '2'],
                ['Renata Abreu', 'Educação', '6'],
                ['Renata Abreu', 'Energia, Recursos Hídricos e Minerais', '3'],
                ['Renata Abreu', 'Esporte e Lazer', '2'],
                ['Renata Abreu', 'Finanças Públicas e Orçamento', '11'],
                ['Renata Abreu', 'Homenagens e Datas Comemorativas', '5'],
                ['Renata Abreu', 'Indústria, Comércio e Serviços', '10'],
                ['Renata Abreu', 'Meio Ambiente e Desenvolvimento Sustentável', '4'],
                ['Renata Abreu', 'Política, Partidos e Eleições', '10'],
                ['Renata Abreu', 'Previdência e Assistência Social', '5'],
                ['Renata Abreu', 'Processo Legislativo e Atuação Parlamentar', '2'],
                ['Renata Abreu', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Renata Abreu', 'Saúde', '11'],
                ['Renata Abreu', 'Trabalho e Emprego', '6'],
                ['Renata Abreu', 'Viação, Transporte e Mobilidade', '3'],
                ['Ricardo Izar', 'Administração Pública', '7'],
                ['Ricardo Izar', 'Agricultura, Pecuária, Pesca e Extrativismo', '1'],
                ['Ricardo Izar', 'Arte, Cultura e Religião', '2'],
                ['Ricardo Izar', 'Cidades e Desenvolvimento Urbano', '2'],
                ['Ricardo Izar', 'Ciência, Tecnologia e Inovação', '3'],
                ['Ricardo Izar', 'Comunicações', '2'],
                ['Ricardo Izar', 'Defesa e Segurança', '4'],
                ['Ricardo Izar', 'Direito Civil e Processual Civil', '4'],
                ['Ricardo Izar', 'Direito Constitucional', '1'],
                ['Ricardo Izar', 'Direito e Defesa do Consumidor', '2'],
                ['Ricardo Izar', 'Direito e Justiça', '1'],
                ['Ricardo Izar', 'Direito Penal e Processual Penal', '4'],
                ['Ricardo Izar', 'Direitos Humanos e Minorias', '7'],
                ['Ricardo Izar', 'Economia', '1'],
                ['Ricardo Izar', 'Educação', '4'],
                ['Ricardo Izar', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Ricardo Izar', 'Finanças Públicas e Orçamento', '6'],
                ['Ricardo Izar', 'Homenagens e Datas Comemorativas', '4'],
                ['Ricardo Izar', 'Indústria, Comércio e Serviços', '8'],
                ['Ricardo Izar', 'Meio Ambiente e Desenvolvimento Sustentável', '16'],
                ['Ricardo Izar', 'Previdência e Assistência Social', '4'],
                ['Ricardo Izar', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Ricardo Izar', 'Saúde', '19'],
                ['Ricardo Izar', 'Trabalho e Emprego', '8'],
                ['Ricardo Izar', 'Viação, Transporte e Mobilidade', '2'],
                ['Ricardo Izar', 'NA', '1'],
                ['Ricardo Silva', 'Administração Pública', '15'],
                ['Ricardo Silva', 'Arte, Cultura e Religião', '1'],
                ['Ricardo Silva', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Ricardo Silva', 'Defesa e Segurança', '2'],
                ['Ricardo Silva', 'Direito Civil e Processual Civil', '3'],
                ['Ricardo Silva', 'Direito e Defesa do Consumidor', '4'],
                ['Ricardo Silva', 'Direito e Justiça', '2'],
                ['Ricardo Silva', 'Direito Penal e Processual Penal', '29'],
                ['Ricardo Silva', 'Direitos Humanos e Minorias', '28'],
                ['Ricardo Silva', 'Economia', '9'],
                ['Ricardo Silva', 'Educação', '1'],
                ['Ricardo Silva', 'Esporte e Lazer', '1'],
                ['Ricardo Silva', 'Finanças Públicas e Orçamento', '17'],
                ['Ricardo Silva', 'Homenagens e Datas Comemorativas', '3'],
                ['Ricardo Silva', 'Indústria, Comércio e Serviços', '6'],
                ['Ricardo Silva', 'Meio Ambiente e Desenvolvimento Sustentável', '4'],
                ['Ricardo Silva', 'Previdência e Assistência Social', '9'],
                ['Ricardo Silva', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Ricardo Silva', 'Saúde', '28'],
                ['Ricardo Silva', 'Trabalho e Emprego', '16'],
                ['Ricardo Silva', 'Viação, Transporte e Mobilidade', '3'],
                ['Ricardo Tripoli', 'Direitos Humanos e Minorias', '1'],
                ['Roberto Alves', 'Administração Pública', '6'],
                ['Roberto Alves', 'Arte, Cultura e Religião', '2'],
                ['Roberto Alves', 'Ciência, Tecnologia e Inovação', '1'],
                ['Roberto Alves', 'Comunicações', '6'],
                ['Roberto Alves', 'Defesa e Segurança', '2'],
                ['Roberto Alves', 'Direito Civil e Processual Civil', '3'],
                ['Roberto Alves', 'Direito Penal e Processual Penal', '9'],
                ['Roberto Alves', 'Direitos Humanos e Minorias', '13'],
                ['Roberto Alves', 'Economia', '1'],
                ['Roberto Alves', 'Educação', '1'],
                ['Roberto Alves', 'Esporte e Lazer', '1'],
                ['Roberto Alves', 'Finanças Públicas e Orçamento', '1'],
                ['Roberto Alves', 'Homenagens e Datas Comemorativas', '2'],
                ['Roberto Alves', 'Indústria, Comércio e Serviços', '2'],
                ['Roberto Alves', 'Política, Partidos e Eleições', '1'],
                ['Roberto Alves', 'Previdência e Assistência Social', '1'],
                ['Roberto Alves', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Roberto Alves', 'Saúde', '4'],
                ['Roberto Alves', 'Trabalho e Emprego', '1'],
                ['Roberto Alves', 'NA', '1'],
                ['Roberto de Lucena', 'Administração Pública', '25'],
                ['Roberto de Lucena', 'Arte, Cultura e Religião', '2'],
                ['Roberto de Lucena', 'Cidades e Desenvolvimento Urbano', '5'],
                ['Roberto de Lucena', 'Ciência, Tecnologia e Inovação', '2'],
                ['Roberto de Lucena', 'Comunicações', '6'],
                ['Roberto de Lucena', 'Defesa e Segurança', '7'],
                ['Roberto de Lucena', 'Direito Civil e Processual Civil', '4'],
                ['Roberto de Lucena', 'Direito Constitucional', '1'],
                ['Roberto de Lucena', 'Direito e Defesa do Consumidor', '11'],
                ['Roberto de Lucena', 'Direito e Justiça', '1'],
                ['Roberto de Lucena', 'Direito Penal e Processual Penal', '14'],
                ['Roberto de Lucena', 'Direitos Humanos e Minorias', '40'],
                ['Roberto de Lucena', 'Economia', '3'],
                ['Roberto de Lucena', 'Educação', '9'],
                ['Roberto de Lucena', 'Energia, Recursos Hídricos e Minerais', '5'],
                ['Roberto de Lucena', 'Esporte e Lazer', '3'],
                ['Roberto de Lucena', 'Estrutura Fundiária', '1'],
                ['Roberto de Lucena', 'Finanças Públicas e Orçamento', '24'],
                ['Roberto de Lucena', 'Homenagens e Datas Comemorativas', '6'],
                ['Roberto de Lucena', 'Indústria, Comércio e Serviços', '20'],
                ['Roberto de Lucena', 'Meio Ambiente e Desenvolvimento Sustentável', '7'],
                ['Roberto de Lucena', 'Política, Partidos e Eleições', '4'],
                ['Roberto de Lucena', 'Previdência e Assistência Social', '7'],
                ['Roberto de Lucena', 'Saúde', '30'],
                ['Roberto de Lucena', 'Trabalho e Emprego', '16'],
                ['Roberto de Lucena', 'Turismo', '6'],
                ['Roberto de Lucena', 'Viação, Transporte e Mobilidade', '17'],
                ['Roberto de Lucena', 'NA', '1'],
                ['Rodrigo Agostinho', 'Administração Pública', '62'],
                ['Rodrigo Agostinho', 'Meio Ambiente e Desenvolvimento Sustentável', '29'],
                ['Rodrigo Agostinho', 'Direito Penal e Processual Penal', '24'],
                ['Rodrigo Agostinho', 'Direitos Humanos e Minorias', '15'],
                ['Rodrigo Agostinho', 'Direito Civil e Processual Civil', '10'],
                ['Rodrigo Agostinho', 'Economia', '10'],
                ['Rodrigo Agostinho', 'Política, Partidos e Eleições', '10'],
                ['Rodrigo Agostinho', 'Saúde', '9'],
                ['Rodrigo Agostinho', 'Finanças Públicas e Orçamento', '8'],
                ['Rodrigo Agostinho', 'Indústria, Comércio e Serviços', '8'],
                ['Rodrigo Agostinho', 'Energia, Recursos Hídricos e Minerais', '5'],
                ['Rodrigo Agostinho', 'Defesa e Segurança', '4'],
                ['Rodrigo Agostinho', 'Estrutura Fundiária', '4'],
                ['Rodrigo Agostinho', 'Agricultura, Pecuária, Pesca e Extrativismo', '3'],
                ['Rodrigo Agostinho', 'Direito e Justiça', '3'],
                ['Rodrigo Agostinho', 'Educação', '3'],
                ['Rodrigo Agostinho', 'Homenagens e Datas Comemorativas', '3'],
                ['Rodrigo Agostinho', 'Previdência e Assistência Social', '3'],
                ['Rodrigo Agostinho', 'Relações Internacionais e Comércio Exterior', '3'],
                ['Rodrigo Agostinho', 'Trabalho e Emprego', '3'],
                ['Rodrigo Agostinho', 'Ciência, Tecnologia e Inovação', '2'],
                ['Rodrigo Agostinho', 'Direito e Defesa do Consumidor', '2'],
                ['Rodrigo Agostinho', 'Viação, Transporte e Mobilidade', '2'],
                ['Rodrigo Agostinho', 'Arte, Cultura e Religião', '1'],
                ['Rodrigo Agostinho', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Rodrigo Agostinho', 'Comunicações', '1'],
                ['Rodrigo Agostinho', 'Direito Constitucional', '1'],
                ['Rodrigo Agostinho', 'Esporte e Lazer', '1'],
                ['Rosana Valle', 'Administração Pública', '13'],
                ['Rosana Valle', 'Agricultura, Pecuária, Pesca e Extrativismo', '3'],
                ['Rosana Valle', 'Arte, Cultura e Religião', '3'],
                ['Rosana Valle', 'Cidades e Desenvolvimento Urbano', '4'],
                ['Rosana Valle', 'Ciência, Tecnologia e Inovação', '1'],
                ['Rosana Valle', 'Comunicações', '1'],
                ['Rosana Valle', 'Defesa e Segurança', '3'],
                ['Rosana Valle', 'Direito Civil e Processual Civil', '3'],
                ['Rosana Valle', 'Direito e Defesa do Consumidor', '6'],
                ['Rosana Valle', 'Direito Penal e Processual Penal', '3'],
                ['Rosana Valle', 'Direitos Humanos e Minorias', '22'],
                ['Rosana Valle', 'Economia', '7'],
                ['Rosana Valle', 'Educação', '3'],
                ['Rosana Valle', 'Energia, Recursos Hídricos e Minerais', '3'],
                ['Rosana Valle', 'Esporte e Lazer', '1'],
                ['Rosana Valle', 'Finanças Públicas e Orçamento', '10'],
                ['Rosana Valle', 'Homenagens e Datas Comemorativas', '3'],
                ['Rosana Valle', 'Indústria, Comércio e Serviços', '7'],
                ['Rosana Valle', 'Meio Ambiente e Desenvolvimento Sustentável', '5'],
                ['Rosana Valle', 'Política, Partidos e Eleições', '3'],
                ['Rosana Valle', 'Previdência e Assistência Social', '7'],
                ['Rosana Valle', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Rosana Valle', 'Saúde', '20'],
                ['Rosana Valle', 'Trabalho e Emprego', '10'],
                ['Rosana Valle', 'Turismo', '1'],
                ['Rosana Valle', 'Viação, Transporte e Mobilidade', '12'],
                ['Rui Falcão', 'Administração Pública', '20'],
                ['Rui Falcão', 'Agricultura, Pecuária, Pesca e Extrativismo', '5'],
                ['Rui Falcão', 'Arte, Cultura e Religião', '3'],
                ['Rui Falcão', 'Ciência, Tecnologia e Inovação', '3'],
                ['Rui Falcão', 'Comunicações', '9'],
                ['Rui Falcão', 'Defesa e Segurança', '10'],
                ['Rui Falcão', 'Direito Civil e Processual Civil', '3'],
                ['Rui Falcão', 'Direito Constitucional', '2'],
                ['Rui Falcão', 'Direito e Defesa do Consumidor', '1'],
                ['Rui Falcão', 'Direito e Justiça', '3'],
                ['Rui Falcão', 'Direito Penal e Processual Penal', '6'],
                ['Rui Falcão', 'Direitos Humanos e Minorias', '30'],
                ['Rui Falcão', 'Economia', '8'],
                ['Rui Falcão', 'Educação', '9'],
                ['Rui Falcão', 'Energia, Recursos Hídricos e Minerais', '3'],
                ['Rui Falcão', 'Finanças Públicas e Orçamento', '16'],
                ['Rui Falcão', 'Homenagens e Datas Comemorativas', '1'],
                ['Rui Falcão', 'Indústria, Comércio e Serviços', '7'],
                ['Rui Falcão', 'Meio Ambiente e Desenvolvimento Sustentável', '4'],
                ['Rui Falcão', 'Política, Partidos e Eleições', '3'],
                ['Rui Falcão', 'Previdência e Assistência Social', '15'],
                ['Rui Falcão', 'Relações Internacionais e Comércio Exterior', '4'],
                ['Rui Falcão', 'Saúde', '29'],
                ['Rui Falcão', 'Trabalho e Emprego', '20'],
                ['Rui Falcão', 'Viação, Transporte e Mobilidade', '3'],
                ['Sâmia Bomfim', 'Direitos Humanos e Minorias', '82'],
                ['Sâmia Bomfim', 'Saúde', '59'],
                ['Sâmia Bomfim', 'Administração Pública', '42'],
                ['Sâmia Bomfim', 'Trabalho e Emprego', '34'],
                ['Sâmia Bomfim', 'Educação', '27'],
                ['Sâmia Bomfim', 'Previdência e Assistência Social', '25'],
                ['Sâmia Bomfim', 'Finanças Públicas e Orçamento', '24'],
                ['Sâmia Bomfim', 'Defesa e Segurança', '21'],
                ['Sâmia Bomfim', 'Homenagens e Datas Comemorativas', '11'],
                ['Sâmia Bomfim', 'Meio Ambiente e Desenvolvimento Sustentável', '11'],
                ['Sâmia Bomfim', 'Comunicações', '9'],
                ['Sâmia Bomfim', 'Indústria, Comércio e Serviços', '9'],
                ['Sâmia Bomfim', 'Arte, Cultura e Religião', '8'],
                ['Sâmia Bomfim', 'Direito Penal e Processual Penal', '8'],
                ['Sâmia Bomfim', 'Direito Civil e Processual Civil', '7'],
                ['Sâmia Bomfim', 'Economia', '6'],
                ['Sâmia Bomfim', 'Agricultura, Pecuária, Pesca e Extrativismo', '5'],
                ['Sâmia Bomfim', 'Energia, Recursos Hídricos e Minerais', '5'],
                ['Sâmia Bomfim', 'Política, Partidos e Eleições', '5'],
                ['Sâmia Bomfim', 'Direito e Defesa do Consumidor', '3'],
                ['Sâmia Bomfim', 'Estrutura Fundiária', '3'],
                ['Sâmia Bomfim', 'Cidades e Desenvolvimento Urbano', '2'],
                ['Sâmia Bomfim', 'Ciência, Tecnologia e Inovação', '2'],
                ['Sâmia Bomfim', 'Relações Internacionais e Comércio Exterior', '2'],
                ['Sâmia Bomfim', 'Direito Constitucional', '1'],
                ['Sâmia Bomfim', 'Direito e Justiça', '1'],
                ['Samuel Moreira', 'Administração Pública', '5'],
                ['Samuel Moreira', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Samuel Moreira', 'Ciência, Tecnologia e Inovação', '1'],
                ['Samuel Moreira', 'Defesa e Segurança', '1'],
                ['Samuel Moreira', 'Direitos Humanos e Minorias', '1'],
                ['Samuel Moreira', 'Economia', '1'],
                ['Samuel Moreira', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Samuel Moreira', 'Finanças Públicas e Orçamento', '3'],
                ['Samuel Moreira', 'Indústria, Comércio e Serviços', '4'],
                ['Samuel Moreira', 'Previdência e Assistência Social', '2'],
                ['Samuel Moreira', 'Saúde', '5'],
                ['Samuel Moreira', 'Viação, Transporte e Mobilidade', '1'],
                ['Tabata Amaral', 'Administração Pública', '49'],
                ['Tabata Amaral', 'Direitos Humanos e Minorias', '48'],
                ['Tabata Amaral', 'Educação', '42'],
                ['Tabata Amaral', 'Saúde', '31'],
                ['Tabata Amaral', 'Finanças Públicas e Orçamento', '21'],
                ['Tabata Amaral', 'Trabalho e Emprego', '15'],
                ['Tabata Amaral', 'Defesa e Segurança', '14'],
                ['Tabata Amaral', 'Política, Partidos e Eleições', '10'],
                ['Tabata Amaral', 'Previdência e Assistência Social', '10'],
                ['Tabata Amaral', 'Direito Penal e Processual Penal', '8'],
                ['Tabata Amaral', 'Meio Ambiente e Desenvolvimento Sustentável', '8'],
                ['Tabata Amaral', 'Comunicações', '7'],
                ['Tabata Amaral', 'Homenagens e Datas Comemorativas', '7'],
                ['Tabata Amaral', 'Indústria, Comércio e Serviços', '6'],
                ['Tabata Amaral', 'Arte, Cultura e Religião', '5'],
                ['Tabata Amaral', 'Ciência, Tecnologia e Inovação', '5'],
                ['Tabata Amaral', 'Direito Civil e Processual Civil', '3'],
                ['Tabata Amaral', 'Direito Constitucional', '3'],
                ['Tabata Amaral', 'Direito e Defesa do Consumidor', '3'],
                ['Tabata Amaral', 'Economia', '3'],
                ['Tabata Amaral', 'Processo Legislativo e Atuação Parlamentar', '3'],
                ['Tabata Amaral', 'Estrutura Fundiária', '2'],
                ['Tabata Amaral', 'NA', '2'],
                ['Tabata Amaral', 'Direito e Justiça', '1'],
                ['Tabata Amaral', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Tabata Amaral', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Tabata Amaral', 'Turismo', '1'],
                ['Tiririca', 'Administração Pública', '5'],
                ['Tiririca', 'Arte, Cultura e Religião', '3'],
                ['Tiririca', 'Defesa e Segurança', '1'],
                ['Tiririca', 'Direito Civil e Processual Civil', '1'],
                ['Tiririca', 'Direito e Defesa do Consumidor', '1'],
                ['Tiririca', 'Direitos Humanos e Minorias', '1'],
                ['Tiririca', 'Economia', '1'],
                ['Tiririca', 'Educação', '4'],
                ['Tiririca', 'Finanças Públicas e Orçamento', '2'],
                ['Tiririca', 'Homenagens e Datas Comemorativas', '2'],
                ['Tiririca', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Tiririca', 'Saúde', '6'],
                ['Tiririca', 'Trabalho e Emprego', '4'],
                ['Tiririca', 'Viação, Transporte e Mobilidade', '3'],
                ['Vanderlei Macris', 'Administração Pública', '2'],
                ['Vanderlei Macris', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Vanderlei Macris', 'Ciência, Tecnologia e Inovação', '2'],
                ['Vanderlei Macris', 'Defesa e Segurança', '1'],
                ['Vanderlei Macris', 'Direito Civil e Processual Civil', '1'],
                ['Vanderlei Macris', 'Direito e Defesa do Consumidor', '1'],
                ['Vanderlei Macris', 'Direito e Justiça', '1'],
                ['Vanderlei Macris', 'Direitos Humanos e Minorias', '1'],
                ['Vanderlei Macris', 'Educação', '1'],
                ['Vanderlei Macris', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Vanderlei Macris', 'Esporte e Lazer', '1'],
                ['Vanderlei Macris', 'Finanças Públicas e Orçamento', '1'],
                ['Vanderlei Macris', 'Homenagens e Datas Comemorativas', '1'],
                ['Vanderlei Macris', 'Indústria, Comércio e Serviços', '2'],
                ['Vanderlei Macris', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Vanderlei Macris', 'Saúde', '3'],
                ['Vanderlei Macris', 'Trabalho e Emprego', '3'],
                ['Vicentinho', 'Administração Pública', '33'],
                ['Vicentinho', 'Agricultura, Pecuária, Pesca e Extrativismo', '11'],
                ['Vicentinho', 'Arte, Cultura e Religião', '5'],
                ['Vicentinho', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Vicentinho', 'Ciência, Tecnologia e Inovação', '4'],
                ['Vicentinho', 'Comunicações', '6'],
                ['Vicentinho', 'Defesa e Segurança', '8'],
                ['Vicentinho', 'Direito Civil e Processual Civil', '4'],
                ['Vicentinho', 'Direito Constitucional', '1'],
                ['Vicentinho', 'Direito e Defesa do Consumidor', '4'],
                ['Vicentinho', 'Direito e Justiça', '2'],
                ['Vicentinho', 'Direito Penal e Processual Penal', '7'],
                ['Vicentinho', 'Direitos Humanos e Minorias', '49'],
                ['Vicentinho', 'Economia', '13'],
                ['Vicentinho', 'Educação', '15'],
                ['Vicentinho', 'Energia, Recursos Hídricos e Minerais', '9'],
                ['Vicentinho', 'Esporte e Lazer', '1'],
                ['Vicentinho', 'Estrutura Fundiária', '2'],
                ['Vicentinho', 'Finanças Públicas e Orçamento', '26'],
                ['Vicentinho', 'Homenagens e Datas Comemorativas', '5'],
                ['Vicentinho', 'Indústria, Comércio e Serviços', '15'],
                ['Vicentinho', 'Meio Ambiente e Desenvolvimento Sustentável', '5'],
                ['Vicentinho', 'Política, Partidos e Eleições', '3'],
                ['Vicentinho', 'Previdência e Assistência Social', '21'],
                ['Vicentinho', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Vicentinho', 'Relações Internacionais e Comércio Exterior', '2'],
                ['Vicentinho', 'Saúde', '43'],
                ['Vicentinho', 'Trabalho e Emprego', '38'],
                ['Vicentinho', 'Viação, Transporte e Mobilidade', '4'],
                ['Vicentinho', 'NA', '1'],
                ['Vinicius Carvalho', 'Administração Pública', '5'],
                ['Vinicius Carvalho', 'Arte, Cultura e Religião', '3'],
                ['Vinicius Carvalho', 'Cidades e Desenvolvimento Urbano', '1'],
                ['Vinicius Carvalho', 'Ciência, Tecnologia e Inovação', '1'],
                ['Vinicius Carvalho', 'Comunicações', '1'],
                ['Vinicius Carvalho', 'Defesa e Segurança', '1'],
                ['Vinicius Carvalho', 'Direito Civil e Processual Civil', '1'],
                ['Vinicius Carvalho', 'Direito e Defesa do Consumidor', '3'],
                ['Vinicius Carvalho', 'Direito Penal e Processual Penal', '2'],
                ['Vinicius Carvalho', 'Direitos Humanos e Minorias', '2'],
                ['Vinicius Carvalho', 'Economia', '1'],
                ['Vinicius Carvalho', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Vinicius Carvalho', 'Finanças Públicas e Orçamento', '5'],
                ['Vinicius Carvalho', 'Homenagens e Datas Comemorativas', '3'],
                ['Vinicius Carvalho', 'Indústria, Comércio e Serviços', '4'],
                ['Vinicius Carvalho', 'Meio Ambiente e Desenvolvimento Sustentável', '2'],
                ['Vinicius Carvalho', 'Previdência e Assistência Social', '1'],
                ['Vinicius Carvalho', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Vinicius Carvalho', 'Saúde', '3'],
                ['Vinicius Carvalho', 'Trabalho e Emprego', '2'],
                ['Vinicius Carvalho', 'Viação, Transporte e Mobilidade', '1'],
                ['Vinicius Poit', 'Administração Pública', '21'],
                ['Vinicius Poit', 'Arte, Cultura e Religião', '1'],
                ['Vinicius Poit', 'Cidades e Desenvolvimento Urbano', '2'],
                ['Vinicius Poit', 'Ciência, Tecnologia e Inovação', '2'],
                ['Vinicius Poit', 'Comunicações', '2'],
                ['Vinicius Poit', 'Defesa e Segurança', '3'],
                ['Vinicius Poit', 'Direito Civil e Processual Civil', '3'],
                ['Vinicius Poit', 'Direito e Defesa do Consumidor', '3'],
                ['Vinicius Poit', 'Direito Penal e Processual Penal', '10'],
                ['Vinicius Poit', 'Direitos Humanos e Minorias', '6'],
                ['Vinicius Poit', 'Economia', '2'],
                ['Vinicius Poit', 'Educação', '3'],
                ['Vinicius Poit', 'Energia, Recursos Hídricos e Minerais', '3'],
                ['Vinicius Poit', 'Finanças Públicas e Orçamento', '8'],
                ['Vinicius Poit', 'Indústria, Comércio e Serviços', '6'],
                ['Vinicius Poit', 'Meio Ambiente e Desenvolvimento Sustentável', '3'],
                ['Vinicius Poit', 'Política, Partidos e Eleições', '7'],
                ['Vinicius Poit', 'Previdência e Assistência Social', '4'],
                ['Vinicius Poit', 'Processo Legislativo e Atuação Parlamentar', '1'],
                ['Vinicius Poit', 'Saúde', '12'],
                ['Vinicius Poit', 'Trabalho e Emprego', '9'],
                ['Vinicius Poit', 'Viação, Transporte e Mobilidade', '2'],
                ['Vitor Lippi', 'Administração Pública', '5'],
                ['Vitor Lippi', 'Ciência, Tecnologia e Inovação', '5'],
                ['Vitor Lippi', 'Defesa e Segurança', '1'],
                ['Vitor Lippi', 'Direito Civil e Processual Civil', '1'],
                ['Vitor Lippi', 'Direitos Humanos e Minorias', '1'],
                ['Vitor Lippi', 'Economia', '1'],
                ['Vitor Lippi', 'Educação', '1'],
                ['Vitor Lippi', 'Energia, Recursos Hídricos e Minerais', '1'],
                ['Vitor Lippi', 'Finanças Públicas e Orçamento', '5'],
                ['Vitor Lippi', 'Indústria, Comércio e Serviços', '2'],
                ['Vitor Lippi', 'Meio Ambiente e Desenvolvimento Sustentável', '1'],
                ['Vitor Lippi', 'Política, Partidos e Eleições', '1'],
                ['Vitor Lippi', 'Relações Internacionais e Comércio Exterior', '1'],
                ['Vitor Lippi', 'Saúde', '5'],
                ['Vitor Lippi', 'Trabalho e Emprego', '1'],
            ];

            $congressGuys = [];
            foreach ($temas as $item) {

                $congressGuys[$item[0]][] = [
                    'tema' => $item[1],
                    'quantidade' => (int)$item[2]
                ];
            }


            function cmp($a, $b)
            {
                return $a["quantidade"] <=> $b["quantidade"];
            }

            foreach ($congressGuys as $name => $themes) {
                usort($themes, "cmp");
            }
        }

    }
}
