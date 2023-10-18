<?php

namespace App\Http\Controllers;

use App\Models\Axis;
use App\Models\Congressperson;
use App\Helpers\Format;
use App\Models\Indicator;
use App\Models\State;
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

        if ($stars = $request->get('stars')) {
            $fixStars = true;
        } else {
            $stars = 5;
            $fixStars = false;
        }

        $keepOn = true;
        while ($keepOn) {
            $congresspeople = $congresspeopleUnfiltered->filter(function ($congressperson) use ($stars, $fixStars) {
                return (float)$congressperson->mainScore > ($stars - 1) * 2
                    && (
                        (float)$congressperson->mainScore <= $stars * 2 ||
                        ((int)$stars === 5)
                    );
            });

            if ($congresspeople->count() || $fixStars || $stars === 1) {
                $keepOn = false;
            } else {
                $stars--;
            }
        }

        $axes = Axis::all()->each(function ($axis) {
            $axis->indicators = Indicator::where('fk_axis_id', $axis->id)->get();
        });

        $selectedState = $stateId ? State::find($stateId)->name : null;;

        return view(
            'customIndexResult',
            compact(
                'congresspeople',
                'stars',
                'selectedState',
                'stateId',
                'indicators',
                'axes',
            )
        );
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

        $title = 'Deputados de ' . $stars . ' estrela' . ($stars > 1 ? 's' : '');

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
    public function explorerTopNScores(?string $selectedState = null, ?string $selectedAxis = null)
    {
        $limit = 3; // Definimos o número N como 3
        $axis = Format::findAttributeBySlug($selectedAxis);
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
        $congresspeople = Congressperson::getTopNScores($limit, $fkStateId, $axis);
        
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
        
        if ($fkStateId !== null) {
            $title .= ' no estado ' . $state->name;
        }

        return view('explorer', compact('title', 'congresspeople'));
    }


    /**
     * @return View
     */
    public function explorerParty(?string $selectedParty = null)
    {
        $limit = 3; // Definimos o número N como 3

        $title = 'Deputados de ' . $selectedParty;

        $congresspeople = Congressperson::getByParty($selectedParty, $limit);

        return view('explorer', compact('title', 'congresspeople'));
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
