<?php

namespace App\Services;

use App\Enums\Configs;
use App\Helpers\Format;
use App\Models\Party;
use App\Models\Axis;
use App\Models\CongresspersonAxis;
use App\Models\CongresspersonIndicator;
use App\Models\Congressperson;
use App\Models\Importation;
use App\Models\ImportationCongresspersonIndicator;
use App\Models\Indicator;
use App\Models\SiteConfig;
use App\Models\State;
use App\Traits\GeneratesCsv;
use Illuminate\Database\Eloquent\Collection as ElloquentCollection;
use Illuminate\Support\Facades\DB;
use Exception;

class ScoreService
{
    use GeneratesCsv;

    public function __construct(private ImportService $importService)
    {
    }

    public function process()
    {
        $indicators = Indicator::all();
        $this->importService->report('calculating indicator scores for each congressperson');
        $this->importService->iterateProgressBar(
            $indicators, function ($indicator) {
            $this->calculateIndicatorScore($indicator->id);
        });

        $this->importService->report('calculating main rate for each congressperson');
        $this->calculateCongresspeopleMainRate();

        $this->importService->report('calculating axis scores for each congressperson');
        $this->calculateAxisScores();

        $this->importService->report('calculating general averages');
        $this->calculateGeneralAverages();
    }

    /**
     * @param int $indicatorId
     * @return void
     */
    public function calculateIndicatorScore(int $indicatorId): void
    {
        $indicatorData = CongresspersonIndicator::findByIndicator($indicatorId);

        if (!$allValues = $this->extractAllValues($indicatorData)) {
            return;
        }

        if (in_array($indicatorId, config('source.indicators.remove_outliers'))) {
            CongresspersonIndicator::resetOutliers();
            $allValues = $this->removeOutliers($indicatorData, $allValues);
        }

        list($numIntervals, $intervalsValue) = $this->calculateIntervals($allValues);

        $rows = [];

        $indicatorData->each(function ($indicatorByCongressPerson) use ($numIntervals, $intervalsValue, &$rows) {

            if ($intervalsValue == 0) {
                throw new Exception('Scoreservice: intervalsValue is zero!');
            }

            $class = $indicatorByCongressPerson->value ?
                floor($indicatorByCongressPerson->value / $intervalsValue) + 1 :
                0;

            $classbyTen = number_format(((10 / $numIntervals) * $class), 1, '.', '');

            $score = $this->checkRevert(min($classbyTen, 10),$indicatorByCongressPerson->fk_indicator_id);

            $indicatorByCongressPerson->score = $score;

            $logData = [
                'fk_indicator_id' => $indicatorByCongressPerson->fk_indicator_id,
                'fk_congressperson_id' =>  $indicatorByCongressPerson->fk_congressperson_id,
                #'fk_importation_id' => $this->importService->importation->id,
                'number_of_classes' => $numIntervals,
                'value_between_classes' => (float)$intervalsValue,
                'indicator_value' => (float)$indicatorByCongressPerson->value,
                'outlier' => $indicatorByCongressPerson->outlier,
                'indicator_value_class' => (float)$class,
                'adjustment_factor_classes_to_10' => (float)(10 / $numIntervals),
                'indicator_class_adjusted_to_10' => (float)((10 / $numIntervals) * $class),
                'indicator_class_adjusted_to_10_formated' => (float)$classbyTen,
                'indicator_score' => $score,
            ];

            ImportationCongresspersonIndicator::create($logData);

            $rows[] = $logData;

            $indicatorByCongressPerson->save();
        });

        $this->saveCsv(
            $rows,
            'indicators/processing_score_indicators_',#. $this->importService->importation->id,
            true
        );
    }


    public function checkRevert($score, $indicatorId)
    {
        if (!Indicator::shouldRevert($indicatorId)) {
            return $score;
        }

        return 10 - $score;
    }

    public function calculateCongresspeopleMainRate()
    {
        $this->importService->iterateProgressBar(
            Congressperson::getAllCurrent(),
            function ($congressperson) {

                $indicators = CongresspersonIndicator::where('fk_congressperson_id', $congressperson->id)->get();

                $score = 0;
                $qtty = 0;
                $indicators->each(function ($indicator) use (&$score, &$qtty) {
                    $qtty++;
                    $score += $indicator->score;
                });

                $rateNonAdjusted = 0;
                if ($qtty) {
                    $rateNonAdjusted = round(($score / $qtty) * 10, 3);
                }

                $congressperson->rate_non_adjusted = $rateNonAdjusted;
                $congressperson->save();
            });

        $maxNonAdjustedRate = Congressperson::max('rate_non_adjusted');
        $adjustment = 100 / $maxNonAdjustedRate;

        $this->importService->report('biggest rate ' . $maxNonAdjustedRate . ' adjustment: ' . $adjustment);

        $this->importService->report('adjusting congresspeople main rate');
        $this->importService->iterateProgressBar(
            Congressperson::getAllCurrent(),
            function ($congressperson) use ($adjustment) {
                $congressperson->rate = floor($congressperson->rate_non_adjusted * $adjustment);
                $congressperson->save();
            });

    }

    private function calculateIntervals(array $values)
    {
        $min = INF;
        $max = $qtty = 0;
        array_map(function ($value) use (&$min, &$max, &$qtty) {

            if ($value < $min) {
                $min = $value;
            }

            if ($value > $max) {
                $max = $value;
            }

            $qtty++;
        }, $values);

        if ($qtty == 0 || $max == 0) {
            return;
        }

        $numIntervals = round(1 + (3.3 * log10($qtty)), 0, PHP_ROUND_HALF_UP);

        return [
            $numIntervals,
            ($max - $min) / $numIntervals
        ];
    }


    public function calculateAxisScores()
    {
        $this->importService->iterateProgressBar(
            Congressperson::getAllCurrent(),
            function ($congressperson) {

                Axis::all()->each(function ($axis) use ($congressperson) {

                    $scores = CongresspersonIndicator::findByAxisIdAndCongressperson($axis->id, $congressperson->id);
                    dump($scores);
                    
                    CongresspersonAxis::saveOrCreate(
                        $congressperson->id,
                        $axis->id,
                        $scores ? (array_sum($scores) / count($scores)) : 0
                    );
                });
            });
    }


    private function calculateCongressPersonRate()
    {
        $this->importService->iterateProgressBar(
            Congressperson::getAllCurrent(),
            function ($congressperson) {

                $total = 0;
                $qtty = 0;
                CongresspersonAxis::findByCongrespersonId($congressperson->id)->each(function ($axis) use (&$qtty, &$total) {
                    $total += $axis->score;
                    $qtty++;
                });

                $congressperson->rate = $total / $qtty;
                $congressperson->save();
            });
    }


    public function calculateGeneralAverages()
    {
        State::all()->each(function ($state) {

            Axis::all()->each(function ($axis) use ($state) {
                $sum = $total = 0;
                CongresspersonAxis::findByStateId($state->id, $axis->id)->each(function ($congresspersonAxis) use (&$sum, &$total) {
                    $sum += $congresspersonAxis->score;
                    $total++;
                });
                if ($total) {
                    DB::table('states')->where('id', $state->id)->update(['avg_' . $axis->id => $sum / $total]);
                }
            });

            Indicator::all()->each(function ($indicator) use ($state) {
                $sum = $total = 0;
                CongresspersonIndicator::findByStateIdAndIndicator($state->id, $indicator->id)->each(function ($congresspersonIndicator) use (&$sum, &$total) {
                    $sum += $congresspersonIndicator->score;
                    $total++;
                });
                if ($total) {
                    DB::table('states')->where('id', $state->id)->update(['iavg_' . $indicator->id => $sum / $total]);
                }
            });
        });


        Axis::all()->each(function ($axis) {

            $sum = $total = 0;
            CongresspersonAxis::findByAxisId($axis->id)->each(function ($congresspersonAxis) use (&$sum, &$total) {
                $sum += $congresspersonAxis->score;
                $total++;
            });

            SiteConfig::setConfigByKey(
                Configs::tryFrom('nat_avg_' . $axis->id),
                number_format($sum / $total, 1, '.', '')
            );
        });

        Indicator::all()->each(function ($indicator) {
            $sum = $total = 0;
            CongresspersonIndicator::findByIndicator($indicator->id)->each(
                function ($congresspersonIndicator) use (&$sum, &$total) {
                    $sum += $congresspersonIndicator->score;
                    $total++;
                });
            SiteConfig::setConfigByKey(
                Configs::tryFrom('nat_iavg_' . $indicator->id),
                $total ? number_format($sum / $total, 1, '.', '') : 0
            );
        });

    }

    public function getAllData(bool $csv = false): array
    {
        return Format::tableAllData(
            Congressperson::getAllCurrentWithStatesAndParties(),
            Axis::all(),
            Indicator::all(),
            $csv
        );
    }

    public function getIndicatorsData(bool $csv = false): array
    {
        return Format::tableIndicatorsData(
            ImportationCongresspersonIndicator::getCurrentLastValidImporationData(),
            Party::list(),
            $csv
        );
    }

    public function removeOutliers(ElloquentCollection $indicatorData, array $dataset, int $magnitude = 1): ?array
    {
        if (!$dataset) {
            return $dataset;
        }

        $count = count($dataset);
        $mean = array_sum($dataset) / $count;
        $deviation = sqrt(
                array_sum(
                    array_map(
                        fn($x, $mean) => pow($x - $mean, 2),
                        $dataset,
                        array_fill(0, $count, $mean))
                ) / $count
            ) * $magnitude;

        $ret = [];

        $indicatorData->each(function ($item) use (&$ret, $mean, $deviation) {
            if (!$item->value) {
                return;
            }
            if ($item->value <= $mean + $deviation && $item->value >= $mean - $deviation) {
                $ret[] = $item->value;
            } else {
                $item->markAsOutlier();
            }
        });

        return $ret;
    }

    private function extractAllValues(ElloquentCollection $indicatorData): array
    {
        $allValues = [];
        $indicatorData->each(function ($item) use (&$allValues) {
            if (!$item->value) {
                return;
            }
            $allValues[] = $item->value;
        });

        return $allValues;
    }

}
