<?php

namespace App\Http\Controllers;

use App\Models\Axis;
use App\Models\Congressperson;
use App\Helpers\Format;
use App\Models\Indicator;
use App\Models\State;
use App\Models\Party;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ExplorerController extends Controller
{


    /**
     * @return View
     */
    public function customIndex()
    {
        $axes = Axis::all()->each(function ($axis) {
            $axis->indicators = Indicator::where('fk_axis_id', $axis->id)->get();
        });

        return view('customIndex', compact('axes'));
    }

    /**
     * @param Request $request
     * @return view|RedirectResponse
     */
    public function processCustomIndex(Request $request)
    {
        $stateId = $request->get('uf');
        $indicators = $request->get('indicators');

        if (!$indicators) {
            return redirect()->route('crie-seu-indice');
        }

        $qtt = count(array_filter($indicators, function ($value) {
            return $value != "0";
        }));

        $congresspeopleUnfiltered = Congressperson::findByIndicatorWeightedScore(
            $indicators,
            $qtt,
            $stateId
        );

        // Calcular outliers e limites de intervalo
        $scores = $congresspeopleUnfiltered->pluck('mainScore')->all();
        sort($scores);
        $Q1 = self::percentile($scores, 25);
        $Q3 = self::percentile($scores, 75);
        $IQR = $Q3 - $Q1;
        $lower_limit = $Q1 - 1.5 * $IQR;
        $upper_limit = $Q3 + 1.5 * $IQR;

        $filtered_scores = array_filter($scores, function($score) use ($lower_limit, $upper_limit) {
            return $score >= $lower_limit && $score <= $upper_limit;
        });

        $max_score = max($filtered_scores);
        $interval = $max_score / 5;

        // Nova lógica para filtrar parlamentares
        $congresspeople = $congresspeopleUnfiltered->filter(function ($congressperson) use ($interval) {
            $score = (float) $congressperson->mainScore;
            $stars = 0;

            if ($score <= $interval) {
                $stars = 1;
            } elseif ($score <= 2 * $interval) {
                $stars = 2;
            } elseif ($score <= 3 * $interval) {
                $stars = 3;
            } elseif ($score <= 4 * $interval) {
                $stars = 4;
            } else {
                $stars = 5;
            }

            $congressperson->stars = $stars;
            return true;
        });

        // Resto do seu código
        $axes = Axis::all()->each(function ($axis) {
            $axis->indicators = Indicator::where('fk_axis_id', $axis->id)->get();
        });

        $selectedState = $stateId ? State::find($stateId)->name : null;

        return view(
            'customIndexResult',
            compact(
                'congresspeople',
                'selectedState',
                'stateId',
                'indicators',
                'axes',
            )
        );
}

    // Função auxiliar para calcular percentil
    public static function percentile($array, $percentile)
    {
        sort($array);
        $index = ($percentile / 100) * count($array);
        if (floor($index) == $index) {
            $result = ($array[$index - 1] + $array[$index]) / 2;
        } else {
            $result = $array[floor($index)];
        }
        return $result;
    }
    /**
     * @return View
     */
    public function explorer()
    {
        $title = 'Deputados';
        $congresspeople = Congressperson::getAll();

        return view('explorer', compact('title', 'congresspeople'));
    }

    /**
     * @param string $selectedState
     * @return View| RedirectResponse
     */
    public function explorerByState(string $selectedState)
    {
        $selectedState = strtoupper($selectedState);
        $state = State::findByAcronym($selectedState);

        if (!$state) {
            return redirect()->route('explorador');
        }

        $title = 'Deputados de ' . $state->name;
        $congresspeople = Congressperson::getByState($state->id);

        return view('explorer', compact('state', 'title', 'congresspeople', 'selectedState'));
    }

    /**
     * @return View
     */
    public function explorerByRate()
    {
        $stars = (int)Route::current()->getName();

        $title = 'Deputados ' . $stars . ' estrela' . ($stars > 1 ? 's' : '');

        $congresspeople = Congressperson::getByRate($stars);

        return view('explorer', compact('title', 'congresspeople', 'stars'));
    }

    /**
     * @param string $selectedState
     * @return View| RedirectResponse
     */
    public function explorerByRateAndState(string $selectedState)
    {
        $selectedState = strtoupper($selectedState);
        $state = State::findByAcronym($selectedState);
        $stars = (int)Route::current()->getName();

        if (!$state) {
            return redirect()->route('explorador');
        }

        $title = 'Deputados ' . $state->name . ' ' . $stars . '<br> estrela' . ($stars > 1 ? 's' : '');
        $congresspeople = Congressperson::getByRateAndState($state->id, $stars);

        return view('explorer', compact(
            'state',
            'title',
            'congresspeople',
            'stars',
            'selectedState',
        ));
    }

    /**
     * @param Request $request
     * @return View| RedirectResponse
     */
    public function explorerByName(Request $request)
    {
        $name = $request->get('name');

        if (!$name) {
            return redirect()->route('explorador');
        }

        $title = 'Buscando por "' . $name . '"';
        $congresspeople = Congressperson::getByName($name);

        return view('explorer', compact('title', 'congresspeople', 'name'));
    }
    /**
     * @param string|null $selectedState
     * @return View
     */
    public function explorerTopnAxis(?string $selectedAxis = null)
    {
        $limit = 3; // Definimos o número N como 3
        $axis = Format::findAttributeBySlug($selectedAxis);
        // Convertendo o estado selecionado para ID, se fornecido
        
        // Buscando os top 3 congressistas por score
        $congresspeople = Congressperson::getTopNScores($limit, null, $axis);
        
        // Definindo títulos para os eixos
        $axisTitles = [
            1 => 'Produção Legislativa',
            2 => 'Fiscalização',
            3 => 'Mobilização',
            4 => 'Alinhamento Partidário'
        ];
        
        if ($axis) {
            $axisTitle = 'no eixo ' . $axisTitles[$axis]; // Escolhe o título baseado no ID do eixo, ou 'Score' se o id não for encontrado
        }
        else {
            $axisTitle = 'por Score';
        }
        
        $title = 'Deputados destaques ' . $axisTitle;
        
        $sort = true;

        return view('explorer', compact('title', 'congresspeople', 'sort'));
    }


    /**
     * @param string|null $selectedState
     * @return View
     */
    public function explorerTopnUF(?string $selectedState = null)
    {
        $limit = 3; // Definimos o número N como 3
        // Convertendo o estado selecionado para ID, se fornecido
        $fkStateId = null;
        if ($selectedState !== null) {
            $selectedState = strtoupper($selectedState);
            $state = State::findByAcronym($selectedState);
            if ($state) {
                $fkStateId = $state->id;
            }
        }

        // Buscando os top 3 congressistas por score
        $congresspeople = Congressperson::getTopNScores($limit, $fkStateId, null);
        
        
        
        $title = 'Deputados destaques em ' . $state->name;

        $sort = true;

        return view('explorer', compact('title', 'congresspeople', 'sort'));
    }

    /**
     * @return View
     */
    public function explorerTopnParty(?string $selectedParty = null)
    {
        $limit = 3; // Definimos o número N como 3
        $fkPartyId = null;
        if ($selectedParty !== null) {
            $selectedParty = strtoupper($selectedParty);
            $party = Party::findByAcronym($selectedParty);
            if ($party) {
                $fkPartyId = $party->id;
            }
        }
        $congresspeople = Congressperson::getTopNScores($limit,null,null,$fkPartyId);

        $title = 'Deputados destaques do ' . $party->name;

        $sort = true;

        return view('explorer', compact('title', 'congresspeople', 'sort'));
    }

    /**
     * @param string      $state
     * @param string      $axis
     * @param string|null $indOrStar
     * @param string|null $stars
     * @return View
     */
    public function explorerFiltered(
        string      $state,
        string      $axis,
        string      $indOrStar = null,
        string|null $stars = null
    )
    {
        $starFixed = true;
        if ($stars) {
            $stars = Format::translateStars($stars);
            $indicator = Format::findAttributeBySlug($indOrStar);
        } else if (Format::translateStars($indOrStar)) {
            $stars = Format::translateStars($indOrStar);
            $indicator = null;
        } else {
            $indicator = $indOrStar ? Format::findAttributeBySlug($indOrStar) : null;
            $starFixed = false;
            $stars = 5;
        }

        $idState = State::findIdByAcronym($state);
        $uri = '/' . $axis . '/' . ($indicator ? $indOrStar . '/' : '');

        $congresspeople = collect([]);

        $axis = Format::findAttributeBySlug($axis);
        $axisData = Axis::find($axis);
        $attributeName = $axisData->name;

        if ($indicator) {

            $indicatorData = Indicator::find($indicator);
            $attributeName .= '<br>' . $indicatorData->name;


            while ($congresspeople->isEmpty()) {

                $congresspeople = Congressperson::findByIndicatorScoreRange($indicator, $stars, $idState);
                if ($starFixed || !$congresspeople->isEmpty()) {
                    break;
                }
                $stars--;
                if ($stars < 1) {
                    break;
                }
            }
        } else {

            while ($congresspeople->isEmpty()) {
                $congresspeople = Congressperson::findByAxisScoreRange($axis, $stars, $idState);

                if ($starFixed || !$congresspeople->isEmpty()) {
                    break;
                }
                $stars--;

                if ($stars < 1) {
                    break;
                }
            }
        }

        $congresspeople->map(function ($congressperson) {
            $congressperson->rate = $congressperson->score * 10;
            return $congressperson;
        });


        $title = $attributeName;
        $stateData = State::findByAcronym($state);
        $selectedState = null;
        if ($stateData) {
            $title .= '<br>' . $stateData->name;
            $selectedState = $stateData->acronym;
        } else {
            $title .= '<br> Brasil';
        }
        $filterActive = true;

        return view(
            'explorer',
            compact('title', 'congresspeople', 'stars', 'selectedState', 'filterActive', 'uri')
        );

    }
}
