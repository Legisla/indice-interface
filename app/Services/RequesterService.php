<?php

namespace App\Services;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;


class RequesterService
{

    readonly array $acceptJsonOptions;

    readonly array $acceptXmlOptions;

    readonly array $acceptAllOptions;
    /**
     * @var HttpClient
     */
    private HttpClient $httpClient;


    public function __construct()
    {
        $this->httpClient = new HttpClient;

        $this->acceptJsonOptions = [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'verify' => false,
        ];

        $this->acceptXmlOptions = [
            'headers' => [
                'Accept' => 'application/xml',
            ],
            'verify' => false,
        ];

        $this->acceptAllOptions = [
            'headers' => [
                'Accept' => '*/*',
            ],
            'verify' => false,
        ];
    }

    /**
     * @param string $function
     * @param array  $parameters
     * @return array|null
     */
    private function iteratePaginatedRequest(string $function, array $parameters): ?array
    {
        $doMoreRequest = true;
        $receivedData = [];
        $page = 1;
        while ($doMoreRequest) {

            $parameters['page'] = $page;
            $page++;

            $data = $this->{$function}(...$parameters);

            $receivedData = array_merge($receivedData, $data['dados'] ?? []);

            $links = [];
            !empty($data['links']) && array_walk($data['links'], function ($link) use (&$links) {
                $links[$link['rel']] = $link['href'];
            });

            if (!isset($links['next'])) {
                $doMoreRequest = false;
            }
        }

        return $receivedData;
    }

    /**
     * @return Collection
     * @throws GuzzleException
     */
    public function getParties(): Collection
    {
        return collect(
            value: json_decode(
                json: $this->httpClient->request(
                    method: 'GET',
                    uri: config('source.url.root') . config('source.url.parties.all'),
                    options: $this->acceptJsonOptions,
                )->getBody()->getContents(),
            )->dados,
        );
    }

    /**
     * @param int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getPartyDetails(int $externalId): Collection
    {
        return collect(
            value: json_decode(
                json: $this->httpClient->request(
                    method: 'GET',
                    uri: config('source.url.root') . config('source.url.parties.details') . $externalId,
                    options: $this->acceptJsonOptions,
                )->getBody()->getContents(),
            )->dados,
        );
    }

    /**
     * @param int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getPartyMembers(int $externalId): Collection
    {
        return collect(json_decode($this->httpClient->request(
            method:'GET',
            uri:config('source.url.root') . config('source.url.parties.details') .
            $externalId . config('source.url.parties.members'),
            options: $this->acceptJsonOptions,
        )->getBody()->getContents())->dados);
    }

    /**
     * @return Collection
     * @throws GuzzleException
     */
    public function getCongressperson(): Collection
    {
        return collect(
            value: json_decode(
                json: $this->httpClient->request(
                    method: 'GET',
                    uri: sprintf(
                        config('source.url.root') . config('source.url.congresspeople.all'),
                        config('source.legislature_id'),
                    ),
                    options: $this->acceptJsonOptions,
                )->getBody()->getContents(),
            )->dados,
        );
    }


    /**
     * @param int $congresspersonExternalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getCongresspersonDetail(int $congresspersonExternalId): Collection
    {
        $uri = config('source.url.root') .
            config('source.url.congresspeople.details') .
            $congresspersonExternalId;

        $content = $this->httpClient->request(
            method: 'GET',
            uri: $uri,
            options: $this->acceptJsonOptions,
        )->getBody()->getContents();

        if (str_contains($content, '<xml>')) {

            return collect(json_decode(json_encode(simplexml_load_string($content)))->dados);
        }

        if (!!$content) {

            return collect(json_decode($content)->dados);
        }

        return collect(
            value: json_decode(json_encode(simplexml_load_string($this->httpClient->request(
                method: 'GET',
                uri: $uri,
                options: $this->acceptXmlOptions,
            )->getBody()->getContents())))->dados,
        );
    }

    /**
     * @param int $congresspersonExternalId
     * @param int $year
     * @param int $month
     * @return float|null
     * @uses doRequestExpensesPaginated
     */
    public function getTotalExpenditureByMonth(int $congresspersonExternalId, int $year, int $month): ?float
    {
        $receivedData = $this->iteratePaginatedRequest(
            'doRequestExpensesPaginated',
            [$congresspersonExternalId, $year, $month]
        );

        return array_reduce($receivedData, function ($carry, $expense) {
            return $carry + $expense['valorDocumento'];
        }, 0);
    }

    /**
     * @param int $congresspersonExternalId
     * @param int $year
     * @param int $month
     * @param int $page
     * @return array|null
     * @throws GuzzleException
     */
    private function doRequestExpensesPaginated(int $congresspersonExternalId, int $year, int $month, int $page): ?array
    {
        // adiciona um try e um retry para solucionar situações quando a API retorna 403 por algum motivo inexplicado.
        try {
            $count = 0;
            $response = retry(5, function () use ($congresspersonExternalId, $year, $month, $page,&$count) {
                $count++;

                $guzzleResponse = $this->httpClient->request(
                    method: 'GET',
                    uri: config('source.url.root') .
                    sprintf(
                        config('source.url.congresspeople.expenses'),
                        $congresspersonExternalId,
                        $year,
                        $month,
                        $page
                    ),
                    options: $this->acceptJsonOptions
                );

                $guzzleResponseContent=$guzzleResponse->getBody()->getContents();
                $responseJson = json_decode($guzzleResponseContent, true);
                return $responseJson; 
            }, 100); // 3 tentativas, 100 milissegundos de atraso entre elas
        } catch (Exception $e) {
            Log::info('Erro na requisição');

            throw $e; 
        }
        
        return $response;
    }


    /**
     * @param int    $congresspersonExternalId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array|null
     * @uses getPropositionByCongressPersonPaginated
     */
    public function getPropositionDataByCongresspersonByDateRange(
        int    $congresspersonExternalId,
        Carbon $startDate,
        Carbon $endDate
    ): ?array
    {
        return $this->iteratePaginatedRequest(
            function: 'getPropositionByCongressPersonPaginated',
            parameters: [
                $congresspersonExternalId,
                $startDate,
                $endDate,
            ],
        );
    }

    /**
     * @param int    $congresspersonExternalId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int    $page
     * @return array|null
     * @throws GuzzleException
     */
    private function getPropositionByCongressPersonPaginated(
        int    $congresspersonExternalId,
        Carbon $startDate,
        Carbon $endDate,
        int    $page
    ): ?array
    {
        return json_decode(
            json: $this->httpClient->request(
                method: 'GET',
                uri: config('source.url.root') .
                sprintf(
                    config('source.url.propositions.all'),
                    $congresspersonExternalId,
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d'),
                    $page,
                ),
                options: $this->acceptJsonOptions
            )->getBody()->getContents(),
            associative: true
        );
    }

    /**
     * @param int $propositionId
     * @return string
     * @throws GuzzleException
     */
    public function getPropositionAuthors(int $propositionId): string
    {
        return $this->httpClient->request(
            'GET',
            config('source.url.root') .
            sprintf(config('source.url.propositions.authors'), $propositionId),
            $this->acceptJsonOptions
        )->getBody()->getContents();
    }

    /**
     * @param int $propositionId
     * @return string
     * @throws GuzzleException
     */
    public function getPropositionThemes(int $propositionId): string
    {
        return $this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') .
            sprintf(config('source.url.propositions.themes'), $propositionId),
            options: $this->acceptJsonOptions
        )->getBody()->getContents();
    }


    /**
     * @param int $propositionId
     * @return string
     * @throws GuzzleException
     */
    public function getPropositionDetails(int $propositionId): string
    {
        return $this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') . config('source.url.propositions.details') . $propositionId,
            options: $this->acceptJsonOptions
        )->getBody()->getContents();
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array|null
     * @uses getEventsPaginated
     */
    public function getEventsByRange(Carbon $startDate, Carbon $endDate): ?array
    {
        return $this->iteratePaginatedRequest(
            function: 'getEventsPaginated',
            parameters: [$startDate, $endDate],
        );
    }


    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int    $page
     * @return array|null
     * @throws GuzzleException
     */
    private function getEventsPaginated(Carbon $startDate, Carbon $endDate, int $page): ?array
    {
        return json_decode(
            $this->httpClient->request(
                method: 'GET',
                uri: config('source.url.root') .
                sprintf(config('source.url.events.all'),
                    $startDate->format('Y-m-d'),
                    $endDate->format('Y-m-d'),
                    $page,
                ),
                options: $this->acceptJsonOptions
            )->getBody()->getContents(),
            true
        );
    }

    /**
     * @param int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getEventPresence(int $externalId): Collection
    {
        return collect(
            value: json_decode(
                json: $this->httpClient->request(
                    method: 'GET',
                    uri: config('source.url.root') . sprintf(config('source.url.events.presence'), $externalId),
                    options: $this->acceptJsonOptions
                )->getBody()->getContents()
            )->dados
        );
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array|null
     * @uses getVotationPaginated
     */
    public function getVotations(Carbon $startDate, Carbon $endDate): ?array
    {
        return $this->iteratePaginatedRequest(
            function: 'getVotationPaginated',
            parameters: [$startDate, $endDate]
        );
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int    $page
     * @return array|null
     * @throws GuzzleException
     */
    private function getVotationPaginated(Carbon $startDate, Carbon $endDate, int $page): ?array
    {
        return json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') .
            sprintf(
                config('source.url.votations.all'),
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
                $page,
            ),
            options: $this->acceptJsonOptions
        )->getBody()->getContents(), true);
    }

    /**
     * @param string|int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getVotationVotes(string|int $externalId): Collection
    {
        return collect(json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') . sprintf(config('source.url.votations.votes'), $externalId),
            options: $this->acceptJsonOptions
        )->getBody()->getContents())?->dados);
    }

    /**
     * @param string|int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getVotationOrientations(string|int $externalId): Collection
    {
        return collect(json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') . sprintf(config('source.url.votations.orientations'), $externalId),
            options: $this->acceptJsonOptions
        )->getBody()->getContents())?->dados);
    }

    /**
     * @return Collection
     * @throws GuzzleException
     */
    public function getFronts(): Collection
    {
        return collect(json_decode(
            $this->httpClient->request(
                method: 'GET',
                uri: config('source.url.root') .
                sprintf(config('source.url.fronts.all'), config('source.legislature_id')),
                options: $this->acceptJsonOptions
            )->getBody()->getContents())?->dados);
    }


    /**
     * @param string|int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getFrontDetails(string|int $externalId): Collection
    {
        return collect(json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') . config('source.url.fronts.details') . $externalId,
            options: $this->acceptJsonOptions
        )->getBody()->getContents())?->dados);
    }


    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array|null
     * @uses getBodiesPaginated
     */
    public function getBodies(Carbon $startDate, Carbon $endDate): ?array
    {
        return $this->iteratePaginatedRequest(
            function: 'getBodiesPaginated',
            parameters: [$startDate, $endDate],
        );
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int    $page
     * @return array|null
     * @throws GuzzleException
     */
    private function getBodiesPaginated(Carbon $startDate, Carbon $endDate, int $page): ?array
    {
        return json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') .
            sprintf(config('source.url.bodies.all'),
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
                $page,
            ),
            options: $this->acceptJsonOptions
        )->getBody()->getContents(), true);
    }

    /**
     * @param string|int $externalId
     * @return Collection
     * @throws GuzzleException
     */
    public function getBodiesMembers(string|int $externalId): Collection
    {
        return collect(json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') . sprintf(config('source.url.bodies.members'), $externalId),
            options: $this->acceptJsonOptions
        )->getBody()->getContents())?->dados);
    }

    /**
     * @param string $name
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return string
     * @throws GuzzleException
     */
    public function getAmendments(string $name, Carbon $startDate, Carbon $endDate): string
    {
        return $this->httpClient->request(
            method: 'GET',
            uri: sprintf(
                config('source.url.amendments.all'),
                $name,
                $startDate->format('Y'),
                $endDate->format('Y')
            ) .
            config('source.url.amendments.selected_colunns'),
            options: $this->acceptAllOptions
        )->getBody()->getContents();
    }

    public function getLegislatureDetails(): Collection
    {
        return collect(json_decode($this->httpClient->request(
            method: 'GET',
            uri: config('source.url.root') . config('source.url.legislatures.all').config('source.legislature_id'),
            options: $this->acceptJsonOptions
        )->getBody()->getContents())?->dados);
    }
}
