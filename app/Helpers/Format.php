<?php

namespace App\Helpers;

use App\Enums\Configs;
use App\Enums\Stars;
use App\Models\Axis;
use App\Models\Congressperson;
use App\Models\CongresspersonAxis;
use App\Models\CongresspersonIndicator;
use App\Models\Indicator;
use App\Models\Party;
use App\Models\SiteConfig;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;

class Format
{

    /**
     * @param string $value
     * @return string|null
     */
    public static function filterNumbers(string $value): ?string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * @param string $value
     * @return float
     */
    public static function convertNumberToIso(string $value): float
    {
        return (float)str_replace('.', '', str_replace(',', '.', $value));
    }


    /**
     * @param array $dataset
     * @param int   $magnitude
     * @return array|null
     */

    /**
     * @param Congressperson $congressperson
     * @return array
     */
    public static function calculateTimes(Congressperson $congressperson): array
    {
        $office_time = $party_time = 0;
        $office_time = $party_time = 0;
        $office_time_seconds = $congressperson->time_in_office;
        $office_time = $party_time = 0;
        $office_time = round(($congressperson->time_in_office)/ 30.417  );
        if ($congressperson->entrance_on_party) {
            if (!$congressperson->exit_on_party) {
                $congressperson->exit_on_party = Carbon::now();
            }

            $party_time = $congressperson->entrance_on_party->diff($congressperson->exit_of_party)->format('%y');
        }

        return [
            $office_time,
            $party_time,
        ];
    }


    public static function getStatsData(Congressperson $congressperson)
    {
        $nationalIndicators = SiteConfig::getNationalIndicators();
        $stateIndicators = State::findIndicatorsById($congressperson->fk_state_id);
        $stateAxis = State::findAxisById($congressperson->fk_state_id);

        $ret = [];
        Axis::all()->each(function ($axis) use (&$ret, $stateAxis, $congressperson, $stateIndicators, $nationalIndicators) {
            $ret[$axis->id] = [
                'indicatorGraphData' => self::formatStatJson(
                    CongresspersonIndicator::findByAxisIdAndCongressperson($axis->id, $congressperson->id),
                    $stateIndicators[$axis->id],
                    $nationalIndicators[$axis->id],
                    $congressperson->congressperson_name,
                    $congressperson->state_acronym,
                ),
                'nationalAxis' => (float)SiteConfig::getByKey(Configs::tryFrom('nat_avg_' . $axis->id)),
                'congresPersonAxis' => CongresspersonAxis::findByAxisIdAndCongressperson($axis->id, $congressperson->id),
                'info' => [
                    'axisName' => $axis->name,
                    'indicators' => Indicator::findByAxesId($axis->id),
                ],
                'indicatorsMean' => self::indicatorsMean(
                    CongresspersonIndicator::findByAxisIdAndCongressperson($axis->id, $congressperson->id),
                    $stateIndicators[$axis->id],
                    $nationalIndicators[$axis->id]
                    )
            ];
        });

        return $ret;
    }


    public static function getStatsLinks()
    {
        return Axis::all()->map(function ($axis) {
            return [
                'id' => $axis->id,
                'name' => $axis->name,
                'link' => Str::slug($axis->name),
                'indicators' => array_map(
                    fn($indicator) => ['name' => $indicator, 'link' => Str::slug($indicator)],
                    Indicator::findByAxesId($axis->id)
                ),
            ];
        });
    }

    public static function indicatorsMean(
        array $congressPersonIndicators,
        array $stateIndicators,
        array $nationalIndicators
    ): array {
        // Cálculo para $congressPersonIndicators
        $totalCongress = 0;
        $countCongress = count($congressPersonIndicators);
        $meanCongress = 0.0;
    
        if ($countCongress > 0) {
            foreach ($congressPersonIndicators as $valor) {
                $totalCongress += floatval($valor);
            }
            $meanCongress = round(($totalCongress / $countCongress) * 10, 1);
        }
    
        // Cálculo para $stateIndicators
        $totalState = 0;
        $countState = count($stateIndicators);
        $meanState = 0.0;
    
        if ($countState > 0) {
            foreach ($stateIndicators as $valor) {
                $totalState += floatval($valor);
            }
            $meanState = round(($totalState / $countState) * 10, 1);
        }
    
        // Cálculo para $nationalIndicators
        $totalNational = 0;
        $countNational = count($nationalIndicators);
        $meanNational = 0.0;

        if ($countNational > 0) {
            foreach ($nationalIndicators as $valor) {
                $totalNational += floatval($valor);
            }

            $meanNational = round(($totalNational / $countNational)*10,1);
        }
        return ['deputyMean' => $meanCongress, 'stateMean' => $meanState, 'nationalMean' => $meanNational];
    }
    


    

    public static function formatStatJson(
        array  $congressPersonIndicators,
        array  $stateIndicators,
        array  $nationalIndicators,
        string $congressPersonName,
        string $stateName,
    ): string
    {
        $arr = [];

        ksort($congressPersonIndicators);

        foreach ($congressPersonIndicators as $key => $congressPersonIndicator) {
            $arr[] = [
                (string)$key,
                $congressPersonIndicator*10,
                $stateIndicators[$key]*10,
                $nationalIndicators[$key]*10,
            ];
        }

        $ret = "['Indicador', '{$congressPersonName}', 'Média {$stateName}', 'Média Brasil'],";
        foreach ($arr as $line) {
            $first = array_shift($line);
            $ret .= '["' . $first . '",' . implode(',', $line) . "],";
        }

        return $ret;
    }

    /**
     * @param string|null $slug
     * @return int|null
     */
    public static function findAttributeBySlug(string|null $slug)
    {
        if (!$slug) {
            return null;
        }

        $ret = null;
        Axis::all()->each(function ($axis) use (&$ret, $slug) {
            Str::slug($axis->name) === $slug && $ret = $axis->id;
        });

        if ($ret) {
            return $ret;
        }

        Indicator::all()->each(function ($indicator) use (&$ret, $slug) {
            Str::slug($indicator->name) === $slug && $ret = $indicator->id;
        });

        return $ret;
    }

    public static function translateStars(string|null $stars): ?int
    {
        if (!$stars) {
            return null;
        }

        $num = explode('-', $stars);

        return (int)Stars::tryFrom(reset($num))?->int();
    }

    public static function parseCsvStringToArray(string $csvString, string $separator = ';'): array
    {
        $arr = array_filter(array_map(
            fn($line) => array_filter(str_getcsv($line, $separator)),
            explode("\n", str_replace("\r", "", $csvString))
        ));

        $keys = array_shift($arr);

        return array_map(
            fn($line) => array_combine($keys, $line),
            $arr
        );
    }

    public static function tableAllData(
        $congressPeople,
        $axes,
        $indicators,
        $csv
    ): array
    {

        if (!$csv) {
            $ret = [[
                ['class' => 'thm', 'text' => 'Deputado'],
                ['class' => 'ths', 'text' => 'Estrelas'],
                ['class' => 'ths', 'text' => 'Score'],
                ['class' => 'ths', 'text' => 'Score não ajustado'],
            ]];
        } else {
            $ret = [[
                'Deputado',
                'Estrelas',
                'Score',
                'Score não ajustado',
            ]];
        }

        $axes->each(function ($axis) use (&$ret, $indicators, $csv) {
            $ret[0][] = ['class' => 'tha', 'text' => $axis->name . ' score'];
            $indicators->each(function ($indicator) use (&$ret, $axis, $csv) {
                if ($indicator->fk_axis_id == $axis->id) {
                    if (!$csv) {
                        $ret[0][] = ['class' => 'thi', 'text' => $indicator->name . ' valor'];
                        $ret[0][] = ['class' => 'thi', 'text' => $indicator->name . ' score'];
                    } else {
                        $ret[0][] = $indicator->name . ' valor';
                        $ret[0][] = $indicator->name . ' score';
                    }
                }
            });
        });

        $congressPeople->each(function ($congressPerson) use ($axes, $indicators, &$ret, $csv) {
            if (!$csv) {
                $ret[$congressPerson->id] = [
                    'name' => [
                        'class' => 'tdm',
                        'text' => $congressPerson->name .
                            '<br>(' . $congressPerson->party->acronym .
                            '-' . $congressPerson->state->acronym . ')',
                        'link' => route('deputado', ['id' => $congressPerson->external_id]),
                    ],
                    'stars' => ['class' => 'tds', 'text' => calculateStars($congressPerson->rate)],
                    'score_non_adjusted' => ['class' => 'tds', 'text' => $congressPerson->rate],
                    'score' => ['class' => 'tds', 'text' => $congressPerson->rate_non_adjusted],
                ];
            } else {
                $ret[$congressPerson->id] = [
                    $congressPerson->name .
                    ' (' . $congressPerson->party->acronym .
                    '-' . $congressPerson->state->acronym . ')',
                    calculateStars($congressPerson->rate),
                    $congressPerson->rate,
                    $congressPerson->rate_non_adjusted,
                ];
            }

            $axes->each(function ($axis) use (&$ret, $congressPerson, $indicators, $csv) {

                $scoreAxis =  CongresspersonAxis::findByAxisIdAndCongressperson($axis->id, $congressPerson->id);

                if (!$csv) {
                    $ret[$congressPerson->id][] = [
                        'class' => 'tda',
                        'text' => $scoreAxis,
                    ];
                } else {
                    $ret[$congressPerson->id][] = $scoreAxis;
                }

                $indicatorData = CongresspersonIndicator::findScoreAndValueByAxisIdAndCongressperson($axis->id, $congressPerson->id);

                $indicators->each(function ($indicator) use (&$ret, $axis, $indicatorData, $congressPerson, $csv) {
                    if ($indicator->fk_axis_id == $axis->id) {

                        $class = ' tdi';

                        if (!$indicatorData) {
                            if (!$csv) {
                                $ret[$congressPerson->id][] = ['class' => $class, 'text' => '-'];
                                $ret[$congressPerson->id][] = ['class' => $class, 'text' => '-'];
                            } else {
                                $ret[$congressPerson->id][] = '-';
                                $ret[$congressPerson->id][] = '-';
                            }
                        } else {

                            $class = $class . ($indicatorData[$indicator->id]['outlier'] ? ' outlier' : '');

                            if (!$csv) {
                                $ret[$congressPerson->id][] = ['class' => $class, 'text' => self::formatNumberIfLong($indicatorData[$indicator->id]['value'])];
                                $ret[$congressPerson->id][] = ['class' => $class, 'text' => $indicatorData[$indicator->id]['score']];
                            } else {
                                $ret[$congressPerson->id][] = self::formatNumberIfLong($indicatorData[$indicator->id]['value']);
                                $ret[$congressPerson->id][] = $indicatorData[$indicator->id]['score'];
                            }
                        }
                    }
                });

            });
        });

        return $ret;
    }

    /**
     * @param $number
     * @return string
     */
    public static function formatNumberIfLong($number): string
    {
        if (strlen($number) > 3) {
            return number_format($number, 0, ',', '.');
        }

        return $number;
    }

    /**
     * @param Collection $congresspersonDtls
     * @return array
     */
    public static function congresspersonDetails(Collection $congresspersonDtls): array
    {
        return [
            'external_id' => filterStrIntInput($congresspersonDtls, 'id'),
            'name' => filterStrIntInput($congresspersonDtls, 'nomeEleitoral', 'ultimoStatus'),
            'civilName' => filterStrIntInput($congresspersonDtls, 'nomeCivil'),
            'fk_party_id' => Party::findIdByAcronym(filterStrIntInput($congresspersonDtls, 'siglaPartido', 'ultimoStatus')),
            'fk_state_id' => State::findIdByAcronym(filterStrIntInput($congresspersonDtls, 'siglaUf', 'ultimoStatus')),
            'legislature_id' => filterStrIntInput($congresspersonDtls, 'idLegislatura', 'ultimoStatus'),
            'uri' => filterStrIntInput($congresspersonDtls, 'uri', 'ultimoStatus'),
            'uri_photo' => filterStrIntInput($congresspersonDtls, 'urlFoto', 'ultimoStatus'),
            'email' => filterStrIntInput($congresspersonDtls, 'email', 'ultimoStatus'),
            'situation' => filterStrIntInput($congresspersonDtls, 'situacao', 'ultimoStatus'),
            'document' => filterStrIntInput($congresspersonDtls, 'cpf'),
            'sex' => filterStrIntInput($congresspersonDtls, 'sexo'),
            'birthdate' => filterStrIntInput($congresspersonDtls, 'dataNascimento'),
        ];
    }

    public static function tableIndicatorsData(EloquentCollection $indicatorData, array $parties): array
    {

        $ret = [];
        $indicatorData->each(function ($row) use ($parties, &$ret) {
            $ret[] = [
                "id indicador" => $row->fk_indicator_id,
                "nome indicador" => $row->indicator->name,
                "id Deputado" => $row->congressperson->external_id,
                "nome deputado" => $row->congressperson->name . ' (' . $parties[$row->congressperson->fk_party_id] . ')',
                "número de classes" => $row->number_of_classes,
                "valor entre classes" => $row->value_between_classes,
                "valor do indicador para o deputado" => $row->indicator_value,
                "é outlier?" => $row->outlier,
                "classe alcançada pelo deputado" => $row->indicator_value_class,
                "ajuste de classe do indicador para 10" => $row->adjustment_factor_classes_to_10,
                "classe do deputado ajustada para 10" => $row->indicator_class_adjusted_to_10,
                "classe do deputado ajustada para 10 formatada" => $row->indicator_class_adjusted_to_10_formated,
                "score" => $row->indicator_score,
                "data do processamento" => $row->created_at->format('d/m/Y H:i:s'),
            ];
        });

        if(!empty($ret)) {
            array_unshift(
                $ret,
                array_keys($ret[0])
            );
        }

        return $ret;
    }

}

