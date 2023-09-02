<?php

namespace App\Enums;

enum Memberships: string
{
    case PRESIDENTE = 'Presidente';
    case PRIMEIRO_VICE_PRESIDENTE = '1º Vice-Presidente';
    case SEGUNDO_VICE_PRESIDENTE = '2º Vice-Presidente';
    case PRIMEIRO_SECRETARIO = '1º Secretário';
    case SEGUNDO_SECRETARIO = '2º Secretário';
    case TERCEIRO_SECRETARIO = '3º Secretário';
    case QUARTO_SECRETARIO = '4º Secretário';
    case PRIMEIRO_SUPLENTE_DE_SECRETARIO = '1º Suplente de Secretário';
    case SEGUNDO_SUPLENTE_DE_SECRETARIO = '2º Suplente de Secretário';
    case TERCEIRO_SUPLENTE_DE_SECRETARIO = '3º Suplente de Secretário';
    case QUARTO_SUPLENTE_DE_SECRETARIO = '4º Suplente de Secretário';
    case OUVIDOR_GERAL = 'Ouvidor-Geral';
    case COORDENADOR_GERAL = 'Coordenador-Geral';
    case SECRETARIO_DE_RELACOES_INTERNACIONAIS = 'Secretário de Relações Internacionais';
    case SECRETARIO_DE_COMUNICACAO_SOCIAL = 'Secretário de Comunicação Social';
    case SECRETARIO_DE_TRANSPARENCIA = 'Secretário de Transparência';
    case SEC_DE_PART_INTER_E_MIDIAS_DIGITAIS = 'Sec. de Part Inter e Mídias Digitais';
    case SECRETARIO_DA_JUVENTUDE = 'Secretário da Juventude';
    case PROCURADOR = 'Procurador';
    case PROCURADORA = 'Procuradora';
    case PRIMEIRO_PROCURADOR_ADJUNTO = '1º Procurador Adjunto';
    case SEGUNDO_PROCURADOR_ADJUNTO = '2º Procurador Adjunto';
    case TERCEIRO_PROCURADOR_ADJUNTO = '3º Procurador Adjunto';
    case CORREGEDOR = 'Corregedor';
    case TITULAR = 'Titular';
    case SUPLENTE = 'Suplente';
    case PRIMEIRO_COORDENADOR_ADJUNTO = '1º Coordenador Adjunto';
    case SEGUNDO_COORDENADOR_ADJUNTO = '2º Coordenador Adjunto';
    case TERCEIRO_COORDENADOR_ADJUNTO = '3º Coordenador Adjunto';
    case RELATOR = 'Relator';
    case TERCEIRO_VICE_PRESIDENTE = '3º Vice-Presidente';


    public function score(string $bodyName): int
    {
        return static::getScore($this, $bodyName);
    }

    public static function getScore(self $value, string $bodyName): int
    {
        return match ($value) {
            self::PRESIDENTE => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Comissão', 'Subcomissão']) ? 10 : 0,
            self::PRIMEIRO_VICE_PRESIDENTE => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Comissão', 'Subcomissão']) ? 8 : 0,
            self::SEGUNDO_VICE_PRESIDENTE => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Comissão', 'Subcomissão']) ? 6 : 0,
            self::PRIMEIRO_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Secretaria']) ? 10 : 0,
            self::SEGUNDO_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Secretaria']) ? 8 : 0,
            self::TERCEIRO_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Secretaria']) ? 6 : 0,
            self::QUARTO_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora', 'Secretaria']) ? 5 : 0,
            self::PRIMEIRO_SUPLENTE_DE_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora']) ? 4 : 0,
            self::SEGUNDO_SUPLENTE_DE_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora']) ? 3 : 0,
            self::TERCEIRO_SUPLENTE_DE_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora']) ? 2 : 0,
            self::QUARTO_SUPLENTE_DE_SECRETARIO => strContainsAtLeasOne($bodyName, ['Mesa Diretora']) ? 1 : 0,
            self::OUVIDOR_GERAL => strContainsAtLeasOne($bodyName, ['Ouvidoria Parlamentar']) ? 10 : 0,
            self::COORDENADOR_GERAL => strContainsAtLeasOne($bodyName, ['Coordenadoria']) ? 10 : 0,
            self::SECRETARIO_DE_RELACOES_INTERNACIONAIS => strContainsAtLeasOne($bodyName, ['Secretaria de Relações Internacionais']) ? 10 : 0,
            self::SECRETARIO_DE_COMUNICACAO_SOCIAL => strContainsAtLeasOne($bodyName, ['Secretaria de Comunicação Social']) ? 10 : 0,
            self::SECRETARIO_DE_TRANSPARENCIA => strContainsAtLeasOne($bodyName, ['Secretaria da Transparência']) ? 10 : 0,
            self::SEC_DE_PART_INTER_E_MIDIAS_DIGITAIS => strContainsAtLeasOne($bodyName, ['Secretaria de Participação, Interação e Mídias Digitais']) ? 10 : 0,
            self::SECRETARIO_DA_JUVENTUDE => strContainsAtLeasOne($bodyName, ['Secretaria da Primeira Infância, Adolescência e Juventude']) ? 10 : 0,
            self::PROCURADOR => strContainsAtLeasOne($bodyName, ['Procuradoria Parlamentar']) ? 10 : 0,
            self::PROCURADORA => strContainsAtLeasOne($bodyName, ['Procuradoria (Procuradoria da Mulher)']) ? 10 : 0,
            self::PRIMEIRO_PROCURADOR_ADJUNTO => strContainsAtLeasOne($bodyName, ['Procuradoria (Procuradoria da Mulher)']) ? 10 : 0,
            self::SEGUNDO_PROCURADOR_ADJUNTO => strContainsAtLeasOne($bodyName, ['Procuradoria (Procuradoria da Mulher)']) ? 8 : 0,
            self::TERCEIRO_PROCURADOR_ADJUNTO => strContainsAtLeasOne($bodyName, ['Procuradoria (Procuradoria da Mulher)']) ? 6 : 0,
            self::CORREGEDOR => strContainsAtLeasOne($bodyName, ['Corregedoria Parlamentar']) ? 10 : 0,
            self::TITULAR => strContainsAtLeasOne($bodyName, ['Comissão', 'Grupo de Trabalho', 'Subcomissão']) ? 10 : 0,
            self::SUPLENTE => strContainsAtLeasOne($bodyName, ['Comissão', 'Subcomissão']) ? 8 : 0,
            self::PRIMEIRO_COORDENADOR_ADJUNTO => strContainsAtLeasOne($bodyName, ['Coordenadoria']) ? 10 : 0,
            self::SEGUNDO_COORDENADOR_ADJUNTO => strContainsAtLeasOne($bodyName, ['Coordenadoria']) ? 8 : 0,
            self::TERCEIRO_COORDENADOR_ADJUNTO => strContainsAtLeasOne($bodyName, ['Coordenadoria']) ? 6 : 0,
            self::RELATOR => strContainsAtLeasOne($bodyName, ['Comissão', 'Grupo de Trabalho', 'Subcomissão']) ? 10 : 0,
            self::TERCEIRO_VICE_PRESIDENTE => strContainsAtLeasOne($bodyName, ['Comissão Parlamentar']) ? 6 : 0,
        };
    }

}
