<?php

namespace Database\Seeders;

use App\Enums\Configs;
use App\Models\Axis;
use App\Models\Congressperson;
use App\Models\Indicator;
use App\Models\SiteConfig;
use App\Models\State;
use App\Models\CongresspersonAxis;
use App\Models\CongresspersonIndicator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeederScores extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
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
            CongresspersonIndicator::findByIndicator($indicator->id)->each(function ($congresspersonIndicator) use (&$sum, &$total) {
                $sum += $congresspersonIndicator->score;
                $total++;
            });
            SiteConfig::setConfigByKey(
                Configs::tryFrom('nat_iavg_' . $indicator->id),
                number_format($sum / $total, 1, '.', '')
            );
        });

    }
}
