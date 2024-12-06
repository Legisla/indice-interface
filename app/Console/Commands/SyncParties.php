<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Party;
use Illuminate\Support\Facades\Http;

class SyncParties extends Command
{
    /**
     * Nome e assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'sync:parties';

    /**
     * Descrição do comando.
     *
     * @var string
     */
    protected $description = 'Sincronizar partidos políticos a partir da API externa';

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Buscando partidos na API...");

        $url = 'https://dadosabertos.camara.leg.br/api/v2/partidos';
        $hasNext = true;

        // Enquanto houver próxima página, continuar buscando dados
        while ($hasNext) {
            // Faz a requisição para a API
            $response = Http::get($url);

            if ($response->failed()) {
                $this->error("Erro ao acessar a URL: {$url}");
                return 1;
            }

            $data = $response->json();

            // Verifica se os dados estão no formato esperado
            if (!isset($data['dados'])) {
                $this->error('Formato inesperado de dados retornado pela API.');
                return 1;
            }

            // Processa cada partido retornado na resposta
            foreach ($data['dados'] as $party) {
                $externalId = $party['id']; // ID do partido na API
                $name = $party['nome']; // Nome completo do partido
                $acronym = $party['sigla']; // Sigla do partido
                $urlLogo = "https://www.camara.leg.br/internet/Deputado/img/partidos/{$acronym}.gif"; // URL do logo
                $uri = $party['uri']; // URL do partido na API

                // Verifica se o partido já existe no banco de dados
                $existingParty = Party::where('external_id', $externalId)->first();

                if ($existingParty) {
                    $this->info("Partido {$acronym} já existe. Pulando.");
                } else {
                    // Cria um novo registro de partido no banco
                    Party::create([
                        'external_id' => $externalId,
                        'name' => $name,
                        'acronym' => $acronym,
                        'url_logo' => $urlLogo,
                        'url_site' => $uri,
                    ]);

                    $this->info("Partido criado: {$name} ({$acronym})");
                }
            }

            // Verifica se existe uma próxima página na API
            $hasNext = false;
            if (isset($data['links'])) {
                foreach ($data['links'] as $link) {
                    if ($link['rel'] === 'next') {
                        $url = $link['href']; // Atualiza a URL para a próxima página
                        $hasNext = true;
                        break;
                    }
                }
            }
        }

        $this->info("Sincronização de partidos concluída.");
        return 0;
    }
}
