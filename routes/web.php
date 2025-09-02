<?php

use App\Http\Controllers\BossCaliController;
use App\Http\Controllers\bossController;
use App\Http\Controllers\caliController;
use App\Http\Controllers\generalController;
use App\Http\Controllers\globalInventario;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\juntasController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\planingController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\PpapIngController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\getPnDetailsController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AdminSupControlloer;
use App\Http\Controllers\rrhhController;
use App\Http\Controllers\SaludController;
use App\Http\Controllers\AccionesCorrectivasController;
use App\Http\Controllers\mailsController;

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
    Route::get('registro/po', 'po')->name('po');
    Route::resource('po', PoController::class);
    Route::get('registro/code', 'code')->name('code');
    Route::get('registro/label', 'label')->name('label');
    Route::get('/registro/implabel', 'implabel')->name('implabel');
});

//    Route::post('getPnDetails', [getPnDetailsController::class, 'getPnDetails'])->name('getPnDetails');
Route::post('getPnDetails', [getPnDetailsController::class, 'getPnDetails'])->name('getPnDetails');

Route::controller(generalController::class)->group(function () {
    Route::get('/general', generalController::class);
    Route::post('/codigo', [generalController::class, 'codigo'])->name('codigo');
    Route::post('/Bom', [generalController::class, 'Bom'])->name('Bom');
    Route::post('/desviation', [generalController::class, 'desviation'])->name('desviation');
    Route::post('/maintananceGen', [generalController::class, 'maintananceGen'])->name('maintananceGen');
    Route::post('/assistence', [generalController::class, 'assistence'])->name('assistence');
    Route::post('/material', [generalController::class, 'material'])->name('material');
    Route::get('/timesHarn', [generalController::class, 'pause'])->name('pause');
    Route::get('/finishWork', [generalController::class, 'finishWork'])->name('finishWork');
    Route::get('/KitsReq', [generalController::class, 'KitsReq'])->name('KitsReq');
    Route::post('/regfull', [generalController::class, 'regfull'])->name('regfull');
    Route::post('/problemas_general', [generalController::class, 'problemas_general'])->name('problemas_general');
});

Route::controller(PpapIngController::class)->group(function () {
    Route::get('/ing', PpapIngController::class);
    Route::get('/autorizar', [PpapIngController::class, 'store'])->name('autorizar');
    Route::get('/action', [PpapIngController::class, 'action'])->name('action');
    Route::get('/tareas', [PpapIngController::class, 'tareas'])->name('tareas');
    Route::get('/RegPPAP', [PpapIngController::class, 'REgPPAP'])->name('RegPPAP');
    Route::get('/cronoReg', [PpapIngController::class, 'cronoReg'])->name('cronoReg');
    Route::get('/modifull', [PpapIngController::class, 'modifull'])->name('modifull');
    Route::get('/excel_ing', [PpapIngController::class, 'excel_ing'])->name('excel_ing');
    Route::get('/problemas', [PpapIngController::class, 'problemas'])->name('problemas');
    Route::get('/problemasFin', [PpapIngController::class, 'problemasFin'])->name('problemasFin');
    Route::get('/workSchedule', [PpapIngController::class, 'workState'])->name('workState');
    Route::get('/workStateJason', [PpapIngController::class, 'workStateJason'])->name('workStateJason');
    Route::get('/saveWorkschedule', [PpapIngController::class, 'saveWorkschedule'])->name('saveWorkschedule');
    Route::get('/editDelite', [PpapIngController::class, 'editDelite'])->name('editDelite');
});

Route::controller(AlmacenController::class)->group(function () {
    Route::get('/almacen', AlmacenController::class);
    Route::GET('/almacenparcial', [AlmacenController::class, 'registroKit'])->name('registroKit');
    //  Route::get('/saveparcial',[AlmacenController::class,'store'])->name('saveparcial');
    Route::get('/BomAlm', [AlmacenController::class, 'BomAlm'])->name('BomAlm');
    Route::get('/entradas', [AlmacenController::class, 'entradas'])->name('entradas');
    Route::get('/concentrado', [AlmacenController::class, 'concentrado'])->name('concentrado');
    Route::get('/desviationAlm', [AlmacenController::class, 'desviationAlm'])->name('desviationAlm');
    Route::post('/qtyItem', [AlmacenController::class, 'qtyItem'])->name('qtyItem');
    Route::post('/ChargeAlm', [AlmacenController::class, 'ChargeAlm'])->name('ChargeAlm');
});

Route::controller(bossController::class)->group(function () {
    Route::get('/boss', bossController::class);
    Route::get('pending/pending', 'pending')->name('pending');
});

Route::controller(caliController::class)->group(function () {
    Route::get('/calidad', caliController::class)->name('calidad');
    Route::get('/baja', [caliController::class, 'baja'])->name('baja');
    Route::post('/saveData', [caliController::class, 'saveData'])->name('saveData');
    Route::post('/buscarcodigo', [caliController::class, 'buscarcodigo'])->name('buscarcodigo');
    Route::post('/codigoCalidad', [caliController::class, 'codigoCalidad'])->name('codigoCalidad');
    Route::get('/calidadfetchdatacali', [caliController::class, 'fetchDatacali'])->name('fetchdatacali');
    Route::post('/mantCali', [caliController::class, 'mantCali'])->name('maintanance');
    Route::post('/assiscali', [caliController::class, 'assiscali'])->name('ascali');
    Route::post('/matCali', [caliController::class, 'matCali'])->name('matCali');
    Route::get('/timesDead', [caliController::class, 'timesDead'])->name('timesDead');
    Route::get('/accepted', [caliController::class, 'accepted'])->name('accepted');
    Route::get('/excel_calidad', [caliController::class, 'excel_calidad'])->name('excel_calidad');
    Route::get('/fallasCalidad', [caliController::class, 'fallasCalidad'])->name('fallasCalidad');
});
Route::controller(BossCaliController::class)->group(function () {
    Route::get('/BossCali', BossCaliController::class);
    Route::get('/reference', [BossCaliController::class, 'reference'])->name('reference');
});

Route::controller(InventarioController::class)->group(function () {
    Route::get('/inventario', InventarioController::class);
    Route::post('/datos', [InventarioController::class, 'savedataAlm'])->name('savedataAlm');
    Route::get('/kits', [InventarioController::class, 'kits'])->name('kits');
    Route::post('/trabajoKits', [InventarioController::class, 'trabajoKits'])->name('trabajoKits');
});
Route::controller(planingController::class)->group(function () {

    Route::get('/planing', [planingController::class, 'planning'])->name('planning');
    Route::get('/pos', [planingController::class, 'pos'])->name('pos');
    Route::get('/codeBarPlan', [planingController::class, 'codeBarPlan'])->name('codeBarPlan');
});

Route::controller(AdminSupControlloer::class)->group(function () {
    Route::get('/SupAdmin', [AdminSupControlloer::class, 'index_admin'])->name('SupAdmin');
    Route::get('/datosOrdenes', [AdminSupControlloer::class, 'datosOrdenes'])->name('datosOrdenes');
    Route::get('/altaDatos', [AdminSupControlloer::class, 'altaDatos'])->name('altaDatos');
    Route::get('/workSchedule/VSM', [AdminSupControlloer::class, 'vsm_schedule'])->name('vsm_schedule');
    Route::get('/workSchedule/timeLine', [AdminSupControlloer::class, 'timeLine'])->name('timeLine');
    Route::get('/registrosGenerales', [AdminSupControlloer::class, 'registrosGenerales'])->name('registrosGenerales');
});

Route::controller(globalInventario::class)->group(function () {
    Route::get('/globalInventario', [globalInventario::class, 'index_inventario'])->name('index_inventario');
    Route::get('/globalInventario/itmes', [globalInventario::class, 'indItems'])->name('indItems');
    Route::get('/globalInventario/WO', [globalInventario::class, 'WOitems'])->name('WOitems');
});


Route::controller(juntasController::class)->group(function () {
    Route::get('/juntas',   [juntasController::class, 'index_junta'])->name('index_junta');
    Route::get('juntas/calidad',   [juntasController::class, 'calidad_junta'])->name('calidad_junta');
    Route::get('juntas/lista/{id}',   [juntasController::class, 'litas_junta'])->name('litas_junta');
    Route::get('juntas/reg',   [juntasController::class, 'litas_reg'])->name('litas_reg');
    Route::get('juntas/mostrarWO',   [juntasController::class, 'mostrarWOJ'])->name('mostrarWOJ');
    Route::get('juntas/ing',   [juntasController::class, 'ing_junta'])->name('ing_junta');
    Route::get('juntas/cutAndTerm',   [juntasController::class, 'cutAndTerm'])->name('cutAndTerm');
    Route::get('juntas/asemblyLoom',   [juntasController::class, 'assemblyLoom'])->name('assemblyLoom');
    Route::get('juntas/seguimientos',   [juntasController::class, 'seguimientos'])->name('seguimientos');
    Route::get('juntas/conSeguimientos',   [juntasController::class, 'conSeguimientos'])->name('conSeguimientos');
    Route::get('juntas/seguimiento/{id}',   [juntasController::class, 'seguimiento'])->name('seguimiento');
    Route::get('/registroComment', [juntasController::class, 'registroComment'])->name('registroComment');
    Route::get('/rhDashBoard', [juntasController::class, 'rhDashBoard'])->name('rhDashBoard');
    Route::get('/vacations', [juntasController::class, 'vacations'])->name('vacations');
    Route::get('/vacations/addVacation', [juntasController::class, 'addVacation'])->name('addVacation');
    Route::get('/rrhh/DatosRh', [juntasController::class, 'DatosRh'])->name('DatosRh');
});

Route::controller(SaludController::class)->group(function () {
    Route::get('/salud', [SaludController::class, 'index_salud'])->name('salud');
    Route::post('/salud/visita_enfermeria', [SaludController::class, 'visita_enfermeria'])->name('visita_enfermeria');
});

Route::controller(rrhhController::class)->group(function () {
    Route::get('/RRHH', [rrhhController::class, 'rrhhDashBoard'])->name('rrhhDashBoard');
    Route::get('/rrhh/rrhhDashBoard', [rrhhController::class, 'updateAsistencia'])->name('updateAsistencia');
   // Route::post('/rrhh/visita_enfermeria', [rrhhController::class, 'visita_enfermeria'])->name('visita_enfermeria');
    Route::post('/rrhh/addpersonal', [rrhhController::class, 'addperson'])->name('addperson');
    Route::post('/rrhh/modificarEmpleado', [rrhhController::class, 'modificarEmpleado'])->name('modificarEmpleado');
    Route::post('/rrhh/editarEmepleado', [rrhhController::class, 'editarEmepleado'])->name('editarEmepleado');
    Route::POST('/rrhh/reporte', [rrhhController::class, 'reporteSemanlInicidencias'])->name('reporteSemanlInicidencias');

});
Route::controller(AccionesCorrectivasController::class)->group(function () {
    Route::get('/acciones-correctivas', [AccionesCorrectivasController::class, 'index'])->name('accionesCorrectivas.index');
    Route::post('/acciones-correctivas/create', [AccionesCorrectivasController::class, 'create'])->name('accionesCorrectivas.create');
    Route::get('/acciones-correctivas/{id}', [AccionesCorrectivasController::class, 'show'])->name('accionesCorrectivas.show');
    Route::post('/acciones-correctivas/guardarPorques', [AccionesCorrectivasController::class, 'guardarPorques'])->name('accionesCorrectivas.guardarPorques');
    Route::post('/acciones-correctivas/guardarIshikawa', [AccionesCorrectivasController::class, 'guardarIshikawa'])->name('accionesCorrectivas.guardarIshikawa');
    Route::post('/acciones-correctivas/guardarAccion', [AccionesCorrectivasController::class, 'guardarAccion'])->name('accionesCorrectivas.guardarAccion');
    Route::POST('/acciones-correctivas/guardarSeguimiento', [AccionesCorrectivasController::class, 'guardarSeguimiento'])->name('accionesCorrectivas.guardarSeguimiento');
});

Route::controller(mailsController::class)->group(function () {
  //  Route::get('/mails', [mailsController::class, 'accionesCorrectivas'])->name('mails.accionesCorrectivas');
  Route::get('/Pendigs', [mailsController::class, 'index'])->name('Pendings.index')->middleware('signed');
  Route::post('/Pendigs/update', [mailsController::class, 'update'])->name('Pendings.update');
  Route::post('/desviation/update', [mailsController::class, 'desviationUpdate'])->name('desviation.update');
  Route::get('/desviation/denied', [mailsController::class, 'desviationDenied'])->name('desviation.denied');
  Route::post('/vacaciones/update', [mailsController::class, 'vacacionesUpdate'])->name('vacaciones.update');

});
