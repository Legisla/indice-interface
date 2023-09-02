<?php

namespace App\Services\Resources;

use App\Enums\Memberships;
use App\Models\Amendment;
use App\Models\Body;
use App\Models\Congressperson;
use App\Models\CongresspersonIndicator;
use App\Models\Event;
use App\Models\Front;
use App\Models\Proposition;
use App\Models\Votation;
use App\Services\ImportService;
use App\Traits\GeneratesCsv;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class IndicatorsService
{
    use GeneratesCsv;

    public function __construct(private readonly ImportService $importService)
    {
    }

    public function process(): void
    {
        if (config('source.processment.debug_memory')) {
            $this->importService->report(
                'starting processment of indicators. memory  stats: ' . show_memory() .
                ' from the limit of ' .
                ini_get('memory_limit') .
                ' with chunks of ' .
                config('source.processment.indicators.chunk_size') .
                ' propositions per iteration'
            );
        }

        $this->importService->iterateProgressBar(
            Congressperson::getAllCurrent(),
            function ($congressperson) {

                if (config('source.processment.debug_memory')) {
                    $this->importService->report(
                        'starting processment of congressperson ' . $congressperson->external_id . ' indicators' .
                        ' with ' . Proposition::countByCongressperson($congressperson) . ' propositions. Memory usage: ' . show_memory()
                    );
                    $startTime = microtime(true);
                }

                CongresspersonIndicator::resetIndicatorsByCongressPerson($congressperson);

                Proposition::join('congressperson_proposition',
                    'congressperson_proposition.proposition_id',
                    '=',
                    'propositions.id')
                    ->where('congressperson_proposition.congressperson_id', $congressperson->id)
                    ->chunk(config('source.processment.indicators.chunk_size'), function ($chunkOfPropositions) use ($congressperson) {
                        $this->processPropositions($chunkOfPropositions, $congressperson);
                    });


                if (config('source.processment.debug_memory')) {
                    $this->importService->report(
                        'ending processment of indicators from external id: ' . $congressperson->external_id .
                        ' in ' . (microtime(true) - $startTime) . ' seconds. Memory usage: ' . show_memory()
                    );
                }
            });
    }

    public function processPropositions(EloquentCollection $propositions, Congressperson $congressperson): void
    {
        $types = [];

        $propositions->each(function ($proposition) use (&$types) {

            if (!isset($types[$proposition->acronymType])) {
                $types[$proposition->acronymType] = 0;
            }

            $types[$proposition->acronymType]++;
        });

        $this->processProjects($types, $congressperson);

        $this->processProtagonism($propositions, $congressperson);

        $this->processSeparateVotesPresented($types, $congressperson);

        $this->processSubstitutesPresented($types, $congressperson);

        $this->processReportsPresented($types, $congressperson);

        $this->processPresenceInPlenary($congressperson);

        $this->processPlenaryAmendments($propositions, $congressperson);

        $this->processRequerimentsAndFiscalization($types, $congressperson);

        $this->processParliamentaryAmendments($congressperson);

        $this->processBudgetAmendments($propositions, $congressperson);

        $this->processAuthorshipProjectsWithSpecialStatus($propositions, $congressperson);

        $this->processPositionsHeldInTheLegislature($congressperson);

        $this->processPublicHearingRequirements($propositions, $congressperson);

        $this->processDeviationFromThePAartyInVoting($congressperson);
    }


    /**
     * #1
     * Total de proposições das siglaTipo PDL,PEC,PL,PLP e PLV
     *
     * @param array          $types
     * @param Congressperson $congressperson
     * @return void
     */
    private function processProjects(array $types, Congressperson $congressperson): void
    {
        CongresspersonIndicator::saveOrUpdate(
            $congressperson->external_id,
            1,
            ($types['PDL'] ?? 0) + ($types['PEC'] ?? 0) + ($types['PL'] ?? 0) + ($types['PLP'] ?? 0) + ($types['PLV'] ?? 0),
        );
    }

    /**
     * #2
     * Total de proposições dos tipos PDL,PEC,PL,PLP,PLV e assinatura é a primeira e é preponente
     * https://dadosabertos.camara.leg.br/api/v2/proposicoes/2270349/autores
     *
     * @param EloquentCollection $propositions
     * @param Congressperson     $congressperson
     * @return void
     */
    private function processProtagonism(EloquentCollection $propositions, Congressperson $congressperson): void
    {
        $total = 0;

        $propositions->each(function ($proposition) use (&$total, $congressperson) {
            if (in_array($proposition->acronymType, ['PDL', 'PEC', 'PL', 'PLP', 'PLV'])) {

                $authors = json_decode($proposition->authors)->dados;

                foreach ($authors as $author) {

                    if ($author->tipo == 'Deputado' && $author->proponente == 1 && $author->ordemAssinatura == 1) {

                        $uriData = explode('/', $author->uri);

                        if (end($uriData) == $congressperson->external_id) {
                            $total++;
                            $this->processRelevanceOfAuthorships($proposition, $congressperson);
                        }
                    }
                }
            }
        });

        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 2, $total);
    }


    /**
     * #3
     * total de proposições dos tipos PDL,PEC,PL,PLP,PLV e assinatura é a primeira  e preponente
     * ementa não possui os termos 'hora|dia|Dia|semana|Semana|Mês|ano|data| festa|calendário|título| prêmio|
     * medalha| nome|galeria|ponte|ferrovia| aeroporto|rotatória|honorpario'
     * e tema não é 'Homenagens e Datas Comemorativas'
     * https://dadosabertos.camara.leg.br/api/v2/proposicoes/2270349/temas
     *
     * @param Proposition    $proposition
     * @param Congressperson $congressperson
     * @return void
     */
    private function processRelevanceOfAuthorships(Proposition $proposition, Congressperson $congressperson): void
    {
        if (
            !empty($proposition->menu)
            && !array_intersect(
                explode(' ', str_replace([',', '.'], ' ', strtolower($proposition->menu))),
                ['hora', 'dia', 'dia', 'semana', 'semana', 'mês', 'ano', 'data', 'festa', 'calendário', 'título', 'prêmio',
                    'medalha', 'nome', 'galeria', 'ponte', 'ferrovia', 'aeroporto', 'rotatória', 'honorário']
            )
        ) {

            $themes = json_decode($proposition->themes)->dados;

            $relevance = 1;
            foreach ($themes as $theme) {
                if (strtolower($theme->tema) == 'homenagens e datas comemorativas') {
                    $relevance = 0;
                }
            }

            if ($relevance) {
                CongresspersonIndicator::incrementOnly($congressperson->external_id, 3);
            }
        }
    }

    /**
     * #4
     * total de  proposições siglaTipo VTS
     *
     * @param array          $types
     * @param Congressperson $congressperson
     * @return void
     */
    private function processSeparateVotesPresented(array $types, Congressperson $congressperson): void
    {
        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 4, $types['VTS'] ?? 0);
    }

    /**
     * #5
     * total de  proposições siglaTipo SBT
     *
     * @param array          $types
     * @param Congressperson $congressperson
     * @return void
     */
    private function processSubstitutesPresented(array $types, Congressperson $congressperson): void
    {
        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 5, $types['SBT'] ?? 0);
    }

    /**
     * #6
     * total de  proposições siglaTipo PRL
     *
     * @param array          $types
     * @param Congressperson $congressperson
     * @return void
     */
    private function processReportsPresented(array $types, Congressperson $congressperson): void
    {
        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 6, $types['PRL'] ?? 0);
    }


    /**
     * #7
     * buscar por eventos local  localCamara.nome == 'Plen�rio da C�mara dos Deputados' e descricaoTipo 'Sess�o Deliberativa'.
     * guardar a porcentagem de presença
     * https://dadosabertos.camara.leg.br/api/v2/eventos?codTipoEvento=110&dataInicio=2019-01-01&itens=100&ordem=ASC&ordenarPor=dataHoraInicio
     * https://dadosabertos.camara.leg.br/api/v2/eventos/54849/deputados
     *
     * @param Congressperson $congressperson
     * @return void
     */
    private function processPresenceInPlenary(Congressperson $congressperson): void
    {
        $totalEvents = Event::getTotalEvents();
        $presence = Event::getTotalPresence($congressperson->external_id);

        CongresspersonIndicator::saveOrUpdate(
            $congressperson->external_id,
            7,
            $totalEvents ? number_format(($presence / $totalEvents) * 100, 0) : 0
        );
    }

    /**
     * #8
     * total de proposições siglaTipoe EMP onde descricaoTipo diferente de 'Emenda de Plenário à MPV (Ato Conjunto 1/20)'
     * https://dadosabertos.camara.leg.br/api/v2/proposicoes/2270349
     *
     * @param \Illuminate\Database\Eloquent\Collection $propositions
     * @param Congressperson                           $congressperson
     * @return void
     */
    private function processPlenaryAmendments(EloquentCollection $propositions, Congressperson $congressperson): void
    {
        $total = 0;

        $propositions->each(function ($proposition) use (&$total, $congressperson) {
            if ($proposition->acronymType === 'EMP') {

                if ((int)$proposition->typeCode !== 873) {
                    $total++;
                } else {
                    $this->processAmendmentsToProvisionalMeasures($congressperson);
                }
            }
        });

        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 8, $total);
    }

    /**
     * #9
     * total de  proposições siglaTipo RIC e PFC
     *
     * @param array          $types
     * @param Congressperson $congressperson
     * @return void
     */
    private function processRequerimentsAndFiscalization(array $types, Congressperson $congressperson): void
    {
        CongresspersonIndicator::saveOrUpdate(
            $congressperson->external_id,
            9,
            ($types['RIC'] ?? 0) + ($types['PFC'] ?? 0)
        );
    }

    /**
     * #10
     * Valor total das emendas
     *
     * @param Congressperson $congressperson
     * @return void
     */
    private function processParliamentaryAmendments(Congressperson $congressperson): void
    {
        CongresspersonIndicator::saveOrUpdate(
            $congressperson->external_id,
            10,
            Amendment::getTotalByCongresspersonId($congressperson->id));
    }

    /**
     * #11
     * proposições tipoSigla EMP com  descricaoTipo == 'Emenda de Plenário MPV (Ato Conjunto 1/20)'
     *
     * @param Congressperson $congressperson
     * @return void
     */
    private function processAmendmentsToProvisionalMeasures(Congressperson $congressperson): void
    {
        CongresspersonIndicator::incrementOnly($congressperson->external_id, 11);
    }

    /**
     * #12
     * Poposiões em que a descricaoTipo tem dos 3 valores:
     * 'Sugestão de Emenda à LDO - Comissões' (siglaTipo SLD)
     * 'Sugest�o de Emenda ao Orçamento - Comissões' (siglaTipo SOR)
     * 'Emenda ao Orçamento' (siglaTipo EMO)
     *
     * @param \Illuminate\Database\Eloquent\Collection $propositions
     * @param Congressperson                           $congressperson
     * @return void
     */
    private function processBudgetAmendments(EloquentCollection $propositions, Congressperson $congressperson): void
    {
        $total = 0;
        $propositions->each(function ($proposition) use (&$total) {
            if (in_array($proposition->acronymType, ['SLD', 'SOR', 'EMO'])) {
                $total++;
            }
        });
        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 12, $total);
    }

    /**
     * #13
     * total de proposiões onde a siglaTipo é PDL | PEC | PL | PLP | PLV  e statusProposicao->regime não contém 'Art. 151' nem é  '.'
     *
     * @param \Illuminate\Database\Eloquent\Collection $propositions
     * @param Congressperson                           $congressperson
     * @return void
     */
    private function processAuthorshipProjectsWithSpecialStatus(
        EloquentCollection $propositions,
        Congressperson     $congressperson
    ): void
    {
        $total = 0;
        $propositions->each(function ($proposition) use (&$total) {
            if (in_array($proposition->acronymType, ['PEC', 'PL', 'PLP', 'PLV', 'PDL'])) {

                $details = json_decode($proposition->details, true);
                $details = $details['dados'];

                if ($details['statusProposicao']['regime'] !== '.' &&
                    !strContainsSimplify($details['statusProposicao']['regime'], 'Art. 151')) {
                    $total++;
                }
            }
        });
        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 13, $total);
    }

    /**
     * #14
     * Cargos ocupados na legislatura, seguindo pontuação descrita em App\Enums\Memberships
     *
     * @param Congressperson $congressPerson
     * @return void
     */
    private function processPositionsHeldInTheLegislature(Congressperson $congressPerson): void
    {
        $total = Front::countByCongressperson($congressPerson);

        Body::getNotEmptyMembers()->each(function ($body) use ($congressPerson, &$total) {

            $members = json_decode($body->members, true);

            if (in_array($congressPerson->external_id, array_keys($members))) {

                foreach ($members[$congressPerson->external_id] as $position) {
                    $total += Memberships::tryFrom($position)?->score($body->name);
                }
            }
        });

        CongresspersonIndicator::saveOrUpdate($congressPerson->external_id, 14, $total);
    }

    /**
     * #15
     * descricaoTipo = 'Requerimento' (siglaTipo REQ)  e ou  ementa = 'Audiência Pública'  147
     *
     * @param \Illuminate\Database\Eloquent\Collection $propositions
     * @param Congressperson                           $congressperson
     * @return void
     */
    private function processPublicHearingRequirements(
        EloquentCollection $propositions,
        Congressperson     $congressperson
    ): void
    {
        $total = 0;
        $propositions->each(function ($proposition) use (&$total) {
            if ($proposition->acronymType == 'REQ'
                || strContainsSimplify($proposition->menu, 'Audiência Pública')) {
                $total++;
            }
        });

        CongresspersonIndicator::saveOrUpdate($congressperson->external_id, 15, $total);
    }

    /**
     * #16
     * levantar votos. checar por votos dos seguintes valores: 'Abstenção'|'Artigo 17'| 'Não' | 'Obstrução' | 'Sim'
     * comparar com orientação do partido
     *
     * @param Congressperson $congressperson
     * @return void
     */
    private function processDeviationFromThePAartyInVoting(Congressperson $congressperson): void
    {
        $total = 0;
        $disalignment = 0;

        $row = [];
        Votation::getAllWithVotes()->each(function ($votation) use ($congressperson, &$total, &$disalignment, &$row) {

            $votes = json_decode($votation->votes, true);

            if (empty($votes[$congressperson->external_id]) ||
                !in_array($votes[$congressperson->external_id], ['Abstenção', 'Não', 'Obstrução', 'Sim'])
            ) {
                return;
            }

            $total++;

            $countedVotes = [];
            $congressperson->getPartyColleaguesExternalId()->each(function ($externalId) use (&$countedVotes, $votes) {
                if (!isset($votes[$externalId])) {
                    return;
                }

                if (!isset($countedVotes[$votes[$externalId]])) {
                    $countedVotes[$votes[$externalId]] = 0;
                }
                $countedVotes[$votes[$externalId]]++;
            });

            $majorityVote = $countedVotes ? array_keys($countedVotes, max($countedVotes)) : [];

            if (count($majorityVote) == 1 && reset($majorityVote) != $votes[$congressperson->external_id]) {
                $disalignment++;
            }

            $row[] = [
                'votation_id' => $votation->id,
                'congressperson_external_id' => $congressperson->external_id,
                'name' => $congressperson->name,
                'vote' => $votes[$congressperson->external_id],
                'party majority' => is_array($majorityVote) ? implode(', ', $majorityVote) : $majorityVote,
                'vote_is_disaligned' => count($majorityVote) == 1 && reset($majorityVote) != $votes[$congressperson->external_id] ? 'yes' : 'no',
            ];

        });

        if (empty($row)) {
            $row[] = [
                'votation_id' => '-',
                'congressperson_external_id' => '-',
                'name' => '-',
                'vote' => '-',
                'party majority' => '-',
                'vote_is_disaligned' => '-',
            ];
        }

        $this->saveCsv($row, 'votations/votations_congressperson_external_id_' . $congressperson->external_id);

        CongresspersonIndicator::saveOrUpdate(
            $congressperson->external_id,
            16,
            $total ? number_format(($disalignment / $total) * 100, 0) : 0
        );
    }

}

