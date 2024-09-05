<?php

use App\Http\Controllers\BossCaliController;
use App\Http\Controllers\bossController;
use App\Http\Controllers\caliController;
use App\Http\Controllers\generalController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\planingController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\PpapIngController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\getPnDetailsController;
use App\Http\Controllers\AlmacenController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', loginController::class);
Route::post('/admin', [loginController::class, 'store'])->name('store');
Route::get('/adminlogout', [loginController::class, 'logout'])->name('logout');
Route::get('login', [loginController::class, 'index'])->name('login');

Route::get('/admin', HomeController::class);
Route::get('/adminfetchdata', [HomeController::class, 'fetchData'])->name('fetchdata');
/*
Route::get('registro', [RegistroController::class,'index' ]);
Route::get('registro/barcode', [RegistroController::class,'barcode' ]);
Route::get('registro/impBarcode', [RegistroController::class,'impBarcode' ]);
Route::get('registro/impEtiquetas', [RegistroController::class,'impEtiquetas' ]);
*/

Route::controller(PoController::class)->group(function () {
    Route::get('registro/po','po')->name('po');
    Route::resource('po', PoController::class);
    Route::get('registro/code','code')->name('code');
    Route::get('registro/label','label')->name('label');
    Route::get('/registro/implabel','implabel')->name('implabel');

    });

//    Route::post('getPnDetails', [getPnDetailsController::class, 'getPnDetails'])->name('getPnDetails');
    Route::post('getPnDetails', [getPnDetailsController::class, 'getPnDetails'])->name('getPnDetails');

Route::controller(generalController::class)->group(function(){
    Route::get('/general',generalController::class);
    Route::post('/codigo', [generalController::class, 'codigo'])->name('codigo');
    Route::post('/Bom',[generalController::class,'Bom'])->name('Bom');
    Route::post('/desviation', [generalController::class, 'desviation'])->name('desviation');
    Route::post('/maintananceGen',[generalController::class, 'maintananceGen'])->name('maintananceGen');
    Route::post('/assistence', [generalController::class, 'assistence'])->name('assistence');
    Route::post('/material',[generalController::class,'material'])->name('material');
    Route::get('/timesHarn',[generalController::class,'pause'])->name('pause');
    Route::get('/finishWork',[generalController::class,'finishWork'])->name('finishWork');
    Route::get('/KitsReq',[generalController::class,'KitsReq'])->name('KitsReq');
    Route::post('/regfull',[generalController::class,'regfull'])->name('regfull');
});

Route::controller( PpapIngController::class)->group(function (){
    Route::get('/ing',PpapIngController::class);
    Route::get('/autorizar',[PpapIngController::class,'store'])->name('autorizar');
    Route::get('/action',[PpapIngController::class,'action'])->name('action');
    Route::get('/tareas',[PpapIngController::class,'tareas'])->name('tareas');
    Route::get('/RegPPAP',[PpapIngController::class,'REgPPAP'])->name('RegPPAP');
    Route::get('/cronoReg',[PpapIngController::class,'cronoReg'])->name('cronoReg');
    Route::get('/modifull',[PpapIngController::class,'modifull'])->name('modifull');
    Route::get('/excel_ing',[PpapIngController::class,'excel_ing'])->name('excel_ing');

});

Route::controller(AlmacenController::class)->group(function (){
    Route::get('/almacen',AlmacenController::class);
    Route::get('/almacenparcial',[AlmacenController::class,'store'])->name('parcial');
    Route::get('/saveparcial',[AlmacenController::class,'store'])->name('saveparcial');
    Route::get('/BomAlm',[AlmacenController::class,'BomAlm'])->name('BomAlm');
    Route::get('/entradas',[AlmacenController::class,'entradas'])->name('entradas');
    Route::get('/concentrado',[AlmacenController::class,'concentrado'])->name('concentrado');

});

Route::controller(bossController::class)->group(function(){
    Route::get('/boss',bossController::class);
    Route::get('pending/pending','pending')->name('pending');
});

Route::controller(caliController::class)->group(function(){
        Route::get('/calidad',caliController::class)->name('calidad');
        Route::get('/baja','baja')->name('baja');
        Route::get('/saveData',[caliController::class,'saveData'])->name('saveData');
        Route::post('/buscarcodigo', [caliController::class, 'buscarcodigo'])->name('buscarcodigo');
        Route::post('/codigoCalidad',[caliController::class,'codigoCalidad'])->name('codigoCalidad');
        Route::get('/calidadfetchdatacali', [caliController::class, 'fetchDatacali'])->name('fetchdatacali');
        Route::post('/mantCali',[caliController::class, 'mantCali'])->name('maintanance');
    Route::post('/assiscali', [caliController::class, 'assiscali'])->name('ascali');
    Route::post('/matCali',[caliController::class,'matCali'])->name('matCali');
    Route::get('/timesDead',[caliController::class,'timesDead'])->name('timesDead');
    });
Route::controller(BossCaliController::class)->group(function(){
    Route::get('/BossCali',BossCaliController::class);
    Route::get('/reference',[BossCaliController::class,'reference'])->name('reference');
});

Route::controller(InventarioController::class)->group(function(){
    Route::get('/inventario',InventarioController::class);
    Route::post('/datos',[InventarioController::class,'savedataAlm'])->name('savedataAlm');
    Route::get('/kits',[InventarioController::class,'kits'])->name('kits');
    Route::post('/trabajoKits',[InventarioController::class,'trabajoKits'])->name('trabajoKits');
});
Route::controller(planingController::class)->group(function(){

    Route::get('/planing',[planingController::class,'planning'])->name('planning');
    Route::get('/pos',[planingController::class,'pos'])->name('pos');
    Route::get('/codeBarPlan',[planingController::class,'codeBarPlan'])->name('codeBarPlan');
});
