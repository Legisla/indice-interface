<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExplorerController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\Auth\CustomAdminPages;
use TCG\Voyager\Facades\Voyager;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['block.site'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/import', [HomeController::class, 'import'])->name('import');

    Route::get('/sobre-o-projeto', [HomeController::class, 'institutional'])->name('sobre-o-projeto');

    Route::get('/metodologia', [HomeController::class, 'institutional'])->name('metodologia');

    Route::get('/quem-somos', [HomeController::class, 'institutional'])->name('quem-somos');

    Route::group(['prefix' => 'contatos'], function () {

        Route::get('/', [HomeController::class, 'contacts'])->name('contatos');

        Route::post('/', [HomeController::class, 'storeContacts']);

    });

    //bloqueio-desenvolvimento
    if (setting('site.showIndex',false)):
        Route::get('/deputado/{id}', [HomeController::class, 'congressperson'])->name('deputado');

        Route::get('/crie-seu-indice', [ExplorerController::class, 'customIndex'])->name('crie-seu-indice');

        Route::post('/crie-seu-indice', [ExplorerController::class, 'processCustomIndex']);


        Route::group(['prefix' => 'explorador'], function () {

            Route::get('/', [ExplorerController::class, 'explorer'])->name('explorador');

            Route::group(['prefix' => 'filtro'], function () {

                Route::get('/{selectedState}/{axis}/', [ExplorerController::class, 'explorerFiltered'])->name('filtro');

                Route::get('/{selectedState}/{axis}/{indicatorOrStar}', [ExplorerController::class, 'explorerFiltered'])->name('filtro-indicador');

                Route::get('/{selectedState}/{axis}/{indicatorOrStar}/{star}', [ExplorerController::class, 'explorerFiltered']);

            });


            Route::get('/estado/{selectedState}', [ExplorerController::class, 'explorerByState'])->name('explorador-estado');

            Route::get('/cinco-estrelas', [ExplorerController::class, 'explorerByRate'])->name('5-star');

            Route::get('/quatro-estrelas', [ExplorerController::class, 'explorerByRate'])->name('4-star');

            Route::get('/tres-estrelas', [ExplorerController::class, 'explorerByRate'])->name('3-star');

            Route::get('/duas-estrelas', [ExplorerController::class, 'explorerByRate'])->name('2-star');

            Route::get('/uma-estrela', [ExplorerController::class, 'explorerByRate'])->name('1-star');

            Route::get('/cinco-estrelas/{state}', [ExplorerController::class, 'explorerByRateAndState'])->name('5-star-and-state');

            Route::get('/quatro-estrelas/{state}', [ExplorerController::class, 'explorerByRateAndState'])->name('4-star-and-state');

            Route::get('/tres-estrelas/{state}', [ExplorerController::class, 'explorerByRateAndState'])->name('3-star-and-state');

            Route::get('/duas-estrelas/{state}', [ExplorerController::class, 'explorerByRateAndState'])->name('2-star-and-state');

            Route::get('/uma-estrela/{state}', [ExplorerController::class, 'explorerByRateAndState'])->name('1-star-and-state');

            Route::get('/nome/', [ExplorerController::class, 'explorerByName'])->name('search-by-name');

            Route::get('/top-scores/{selectedState?}', [ExplorerController::class, 'explorerTopNScores'])->name('top-scores');

        });

    else:

        Route::get('/deputado/{id}', [HomeController::class, 'index'])->name('deputado');

        Route::get('/crie-seu-indice', [HomeController::class, 'index'])->name('crie-seu-indice');

        Route::post('/crie-seu-indice', [HomeController::class, 'index']);


        Route::group(['prefix' => 'explorador'], function () {

            Route::get('/', [HomeController::class, 'index'])->name('explorador');

            Route::group(['prefix' => 'filtro'], function () {

                Route::get('/{selectedState}/{axis}/', [HomeController::class, 'index'])->name('filtro');

                Route::get('/{selectedState}/{axis}/{indicatorOrStar}', [HomeController::class, 'index'])->name('filtro-indicador');

                Route::get('/{selectedState}/{axis}/{indicatorOrStar}/{star}', [HomeController::class, 'index']);

            });


            Route::get('/estado/{selectedState}', [HomeController::class, 'index'])->name('explorador-estado');

            Route::get('/cinco-estrelas', [HomeController::class, 'index'])->name('5-star');

            Route::get('/quatro-estrelas', [HomeController::class, 'index'])->name('4-star');

            Route::get('/tres-estrelas', [HomeController::class, 'index'])->name('3-star');

            Route::get('/duas-estrelas', [HomeController::class, 'index'])->name('2-star');

            Route::get('/uma-estrela', [HomeController::class, 'index'])->name('1-star');

            Route::get('/cinco-estrelas/{state}', [HomeController::class, 'index'])->name('5-star-and-state');

            Route::get('/quatro-estrelas/{state}', [HomeController::class, 'index'])->name('4-star-and-state');

            Route::get('/tres-estrelas/{state}', [HomeController::class, 'index'])->name('3-star-and-state');

            Route::get('/duas-estrelas/{state}', [HomeController::class, 'index'])->name('2-star-and-state');

            Route::get('/uma-estrela/{state}', [HomeController::class, 'index'])->name('1-star-and-state');

            Route::get('/nome/', [HomeController::class, 'index'])->name('search-by-name');

        });
    endif;

});

Route::group(['prefix' => 'desbloquear'], function () {
    Route::post('/', [BlockController::class, 'unblock'])->name('desbloquear');
    Route::get('/', [BlockController::class, 'unblock'])->name('desbloquear');
});


Route::group(['prefix' => 'admin'], function () {

    Voyager::routes();

    Route::group(['middleware' => 'admin.user'], function ()  {

        Route::get('all-data', [CustomAdminPages::class, 'showAllData'])->name('all-data');

        Route::get('all-data-csv', [CustomAdminPages::class, 'allDataCsv'])->name('all-data-csv');

        Route::get('indicators-data-csv', [CustomAdminPages::class, 'indicatorsDataCsv'])->name('indicators-data-csv');

        Route::get('importar', [CustomAdminPages::class, 'import'])->name('web-import');

    });
});
