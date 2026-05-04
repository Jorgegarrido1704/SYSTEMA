<?php

namespace App\Http\Controllers;

use App\Mail\accionesCorrectivas\aceptacionAcciones;
use App\Mail\accionesCorrectivas\cincoPorques;
use App\Mail\accionesCorrectivas\contencion;
use App\Mail\accionesCorrectivas\eliminacionCausas;
use App\Mail\accionesCorrectivas\medicionEficacia;
use App\Mail\accionesCorrectivas\planAccion;
use App\Mail\accionesCorrectivasRecordatorio;
use App\Models\accionesCorrectivas;
use App\Models\accionesCorrectivas\monitoreosAcciones;
use App\Models\eliminacionAccionCorrectiva;
use App\Models\personalBergsModel;
use App\Models\registoLogin;
use App\Models\sub_acciones_model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AccionesCorrectivasController extends Controller
{
    //
    public function index()
    {
        $cat = session('categoria');
        $value = session('user');
        $diasRestantes = [];
        $responsable = personalBergsModel::select('employeeName')->where('user', $value)->first();
        if ($value == 'Admin' or $value == 'Martin A') {
            $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->orderBy('id_acciones_correctivas', 'ASC')->get();

        } else {
            $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->where('resposableAccion', $responsable->employeeName)->orderBy('id_acciones_correctivas', 'ASC')->get();
        }
        foreach ($accionesActivas as $accion) {
            if (strpos($accion->status, 'etapa 1') !== false) {
                $diaFinal = Carbon::parse($accion->fechaAccion)->addWeekDays(3);
                $accion->faltanDias = $diaFinal->diffInDays(Carbon::now());
            }
            $accion->resposableAccion = explode('/', $accion->resposableAccion)[1] ?? $accion->resposableAccion;
        }
        $personal = personalBergsModel::select('employeeName')->where('email', '!=', null)->where('status', '!=', 'Baja')->get();

        return view('accionesCorrectiva.index', [
            'cat' => $cat,
            'value' => $value,
            'accionesActivas' => $accionesActivas,
            'diasRestantes' => $diasRestantes,
            'personal' => $personal,

        ]);
    }

    public function create(Request $request)
    {
        $value = session('user');
        if (empty($value)) {
            return redirect('/');
        }
        $request->validate([
            'fechaAccion' => 'required|date',
            'Afecta' => 'required|string|max:50',
            'origenAccion' => 'required|string|max:50',
            'resposableAccion' => 'required|string|max:80',
            'descripcionAccion' => 'required|string|max:1500',

        ]);
        $afecta = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('Afecta'));
        $origenAcciones = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('origenAccion'));
        $resposableAccion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('resposableAccion'));
        $descripcionAccion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('descripcionAccion'));
        if ($origenAcciones == 'otro') {
            $origenAccion = $origenAcciones.'-'.$request->input('origenAccionotro');
        } else {
            $origenAccion = $origenAcciones;
        }
        $cantidadAccionesHoy = accionesCorrectivas::whereYear('fechaAccion', $request->input('fechaAccion'))->count();
        $cantidadAccionesHoy = $cantidadAccionesHoy + 1;
        if ($cantidadAccionesHoy == 0) {
            $cantidadAccionesHoy = '001';
        } elseif ($cantidadAccionesHoy < 10) {
            $cantidadAccionesHoy = '00'.$cantidadAccionesHoy;
        } elseif ($cantidadAccionesHoy < 100) {
            $cantidadAccionesHoy = '0'.$cantidadAccionesHoy;
        } // dd($cantidadAccionesHoy);
        $accion = new accionesCorrectivas;
        $accion->folioAccion = 'AC-'.carbon::parse($request->input('fechaAccion'))->format('Y').'-'.$cantidadAccionesHoy;
        $accion->fechaAccion = $request->input('fechaAccion');
        $accion->Afecta = $afecta;
        $accion->origenAccion = $origenAccion;
        $accion->resposableAccion = $resposableAccion;
        $accion->descripcionAccion = $descripcionAccion;
        $accion->ultimoEmail = Carbon::now()->format('Y-m-d');
        $accion->save();
        $email = personalBergsModel::select('email')->where('employeeName', $resposableAccion)->first();
        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($email && $email->email) {
            $mailaddresses[] = $email->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => $value, 'action' => 'Creacion Accion Correctiva ID: '.$accion->folioAccion]);
        Mail::to($mailaddresses)->send(new accionesCorrectivasRecordatorio($accion, 'Acciones Correctivas Recordatorio'));

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva creada exitosamente.');
    }

    public function show($id)
    {
        $cat = session('categoria');
        $value = session('user');
        $problema = 'Alta rotación de empleados';
        $categorias = [];
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $registroPorquest = accionesCorrectivas::where('folioAccion', $id)->first();
        if (! empty($registroPorquest->porques)) {
            $categorias = explode(' | ', $registroPorquest->porques);
        } elseif (! empty($registroPorquest->Ishikawa)) {
            $categorias = json_decode($registroPorquest->Ishikawa, true);

        }

        $acciones = sub_acciones_model::where('folioAccion', $id)->get();

        $personal = personalBergsModel::select('employeeName')->where('email', '!=', null)->where('status', '!=', 'Baja')->get();
        $seguimientosSubAcciones = monitoreosAcciones::where('folioAccion', $registroPorquest->folioAccion)
            ->orderBy('idSubAccion', 'ASC')
            ->orderBy('id', 'ASC')->get();

        return view('accionesCorrectiva.show', [
            'acciones' => $acciones,
            'cat' => $cat,
            'value' => $value,
            'problema' => $problema,
            'categorias' => $categorias,
            'registroPorquest' => $registroPorquest,
            'seguimientosSubAcciones' => $seguimientosSubAcciones,
            'personal' => $personal,

        ]);
    }

    public function guardarPorques(Request $request, $id)
    {
        $request->validate([
            'porque1' => 'required|string|max:1000',
            'conclusion' => 'required|string|max:1000',

        ]);
        $porque1 = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('porque1'));
        $conclusion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('conclusion'));
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $registroPorquest = $porque1;
        $acciones = accionesCorrectivas::where('folioAccion', $id)->first();
        $acciones->porque1 = $registroPorquest;
        $acciones->conclusion = $conclusion;

        for ($i = 2; $i <= 5; $i++) {
            $key = 'porque'.$i;
            if ($request->filled($key)) {
                $registroPorquest .= ' | '.preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input($key));
                $acciones->{'porque'.$i} = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input($key));
            }
        }
        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        } else {
            $sistemic = false;
        }

        $accion = accionesCorrectivas::where('folioAccion', $id)->update([
            'porques' => $registroPorquest,
            'conclusiones' => $conclusion,
            'IsSistemicProblem' => $sistemic,
            'status' => 'etapa 1 - 5porques',
        ]);
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($mailto && $mailto->email) {
            $mailaddresses[] = $mailto->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Registro de 5 porques para la accion correctiva ID: '.$id]);
        Mail::to($mailaddresses)->send(new cincoPorques($acciones, 'Registro de 5 porques para la accion correctiva'));

        return redirect()->route('accionesCorrectivas.show', $id)->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function guardarIshikawa(Request $request)
    {
        $request->validate([
            'problema1' => 'required|string|max:500',
            'motivo1' => 'required|string|max:500',
            'conclusion' => 'required|string|max:500',
            'accion_id' => 'required|integer',
        ]);
        $registroPorquest = [
            'porque1' => $request->input('porque1'),
        ];
        $datosIshikawa = [
            $request->input('problema1') => $request->input('motivo1'),
        ];

        for ($i = 2; $i <= 5; $i++) {

            if ($request->filled('problema'.$i)) {
                $datosIshikawa[$request->input('problema'.$i)] = $request->input('motivo'.$i);
            }
        }

        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        } else {
            $sistemic = false;
        }
        $accion = accionesCorrectivas::where($request->input('accion_id'))->update([
            'Ishikawa' => $datosIshikawa,
            'conclusiones' => $request->input('conclusion'),
            'IsSistemicProblem' => $sistemic,
            'status' => 'etapa 2 - Causa Raiz',
        ]);
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Registro de causa raiz para la accion correctiva ID: '.$request->input('accion_id')]);

        return redirect()->route('accionesCorrectivas.show', $accion->folioAccion)->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function guardarAccion(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:15',
            'accion' => 'required|string|max:500',
            'reponsableAccion' => 'required|string|max:500',
            'fechaInicioAccion' => 'required|date',
            'fechaFinAccion' => 'required|date',
            'verificadorAccion' => 'required|string|max:500',
        ]);
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('id'));
        $accionIngesada = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('accion'));
        $responsableAccion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('reponsableAccion'));
        $verificadorAccion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('verificadorAccion'));
        sub_acciones_model::create([
            'folioAccion' => $id,
            'descripcionSubAccion' => $accionIngesada,
            'resposableSubAccion' => $responsableAccion,
            'fechaInicioSubAccion' => $request->input('fechaInicioAccion'),
            'fechaFinSubAccion' => $request->input('fechaFinAccion'),
            'auditorSubAccion' => $verificadorAccion,

        ]);
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Registro de sub accion para la accion correctiva ID: '.$id]);

        return redirect()->route('accionesCorrectivas.show', $request->input('id'))->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $accion = accionesCorrectivas::findOrFail($id);
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Eliminacion de accion correctiva ID: '.$accion->folioAccion]);
        $accion->delete();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva eliminada exitosamente.');
    }

    public function guardarSeguimiento(Request $request, $id, $folio)
    {
        $request->validate([
            'seguimiento' => 'required|string|max:500',
            'validador' => 'required|string|max:500',
        ]);

        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $folio = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $folio);
        $segimiento = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('seguimiento'));
        $validador = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('validador'));
        monitoreosAcciones::create([
            'folioAccion' => $folio,
            'idSubAccion' => $id,
            'descripcionSeguimiento' => $segimiento,
            'AprobadorSeguimiento' => $validador,
        ]);
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Registro de seguimiento para la accion correctiva ID: '.$folio]);

        return redirect()->route('accionesCorrectivas.show', $folio)->with('success', 'Acción correctiva actualizada exitosamente.');

    }

    public function guardarContencion(Request $request, $id)
    {
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $request->validate([
            'descripcionContencion' => 'required|string|max:1500',
            'fechaCompromiso' => 'required|date',
        ]);
        $descripcionContencion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('descripcionContencion'));

        $accion = accionesCorrectivas::where('folioAccion', $id)->update([
            'descripcionContencion' => $descripcionContencion,
            'fechaCompromiso' => $request->input('fechaCompromiso'),
            'status' => 'etapa 1 - Contención',
            'ultimoEmail' => Carbon::now()->format('Y-m-d'),
        ]);
        $acciones = accionesCorrectivas::where('folioAccion', $id)->first();
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($mailto && $mailto->email) {
            $mailaddresses[] = $mailto->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Registro de contencion para la accion correctiva ID: '.$id]);
        $mail = Mail::to($mailaddresses)->send(new contencion($acciones, 'Acciones Correctivas Contencion'));

        return redirect()->route('accionesCorrectivas.show', $id)->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function eliminarCausaRaiz(Request $request, $id)
    {
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $request->validate([
            'donde' => 'required|string|max:20',
        ]);
        $donde = $request->input('donde');
        $motivo = '';
        if ($donde == 'causaRaiz') {
            $modificar = [
                'porques' => null,
                'Ishikawa' => null,
                'conclusiones' => null,
                'status' => 'etapa 1 - causa raiz',
            ];
            $motivo = $request->input('porques');

        } elseif ($donde == 'contencion') {
            $modificar = [
                'descripcionContencion' => null,
                'fechaCompromiso' => null,
                'status' => 'etapa 1 - inicio',
            ];
            $motivo = $request->input('porqueCausaRaiz');
        } elseif ($donde == 'eficacia') {
            $modificar = [
                'status' => 'etapa 2 - Verficacion de eficiencia aplicada',
                'accion' => null,
                'fechaInicioAccion' => null,

            ];
            $motivo = $request->input('porqueEficacia');
        }

        $accion = accionesCorrectivas::where('folioAccion', $id)->update($modificar);
        eliminacionAccionCorrectiva::create([
            'folioAccion' => $id,
            'campoEliminado' => $donde,
            'motivoEliminacion' => $motivo,
        ]);

        // Mail eliminacion
        $acciones = accionesCorrectivas::where('folioAccion', $id)->first();
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
        $acciones->campoEliminado = $donde;
        $acciones->motivoEliminacion = $motivo;
        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($mailto && $mailto->email) {
            $mailaddresses[] = $mailto->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Eliminacion de causa raiz para la accion correctiva ID: '.$id]);

        $mail = Mail::to($mailaddresses)->send(new eliminacionCausas($acciones, 'Eliminacion de causa raiz'));

        return redirect()->route('accionesCorrectivas.show', $id)->with('success', 'Causa raiz eliminada exitosamente.');
    }

    public function eliminarPlandeAccion(Request $request, $id, $folio)
    {
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $folio = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $folio);

        $request->validate([
            'motivoeliminacion' => 'required|string|max:1500',
        ]);
        $motivoEliminacion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('motivoeliminacion'));
        sub_acciones_model::where('id', $id)->delete();
        monitoreosAcciones::where('idSubAccion', $id)->delete();

        eliminacionAccionCorrectiva::create([
            'folioAccion' => $folio,
            'campoEliminado' => 'plan de accion',
            'motivoEliminacion' => $motivoEliminacion,
        ]);
        // Mail eliminacion
        $acciones = accionesCorrectivas::where('folioAccion', $folio)->first();
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
        $acciones->campoEliminado = 'plan de accion con ID '.$id;
        $acciones->motivoEliminacion = $motivoEliminacion;
        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($mailto && $mailto->email) {
            $mailaddresses[] = $mailto->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Eliminacion de plan de accion para la accion correctiva ID: '.$folio]);
        $mail = Mail::to($mailaddresses)->send(new eliminacionCausas($acciones, 'Eliminacion de plan de accion'));

        return redirect()->route('accionesCorrectivas.show', $folio)->with('success', 'Plan de acción eliminado exitosamente.');
    }

    public function aceptarAcciones(Request $request, $validador, $folio)
    {
        $folio = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $folio);
        $validador = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $validador);

        $acciones = accionesCorrectivas::where('folioAccion', $folio)->update([
            'status' => 'etapa 2 - Verficacion de eficiencia aplicada',
            'verificadorAccion' => $validador,
        ]);

        // Mail eliminacion
        $acciones = accionesCorrectivas::where('folioAccion', $folio)->first();
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();

        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($mailto && $mailto->email) {
            $mailaddresses[] = $mailto->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Aceptacion de acciones para la accion correctiva ID: '.$folio]);
        $mail = Mail::to($mailaddresses)->send(new aceptacionAcciones($acciones, 'Aceptación de acciones correctivas'));

        return redirect()->route('accionesCorrectivas.show', $folio)->with('success', 'Acción aceptada exitosamente.');
    }

    public function medicionesAcciones(Request $request, $folioEficacia)
    {
        $request->validate([
            'accion' => 'required|string|max:1500',
            'fechaInicioAccion' => 'required|date',
        ]);
        $accionIngesada = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('accion'));
        $accion = accionesCorrectivas::where('folioAccion', $folioEficacia)->update([
            'accion' => $accionIngesada,
            'fechaInicioAccion' => $request->input('fechaInicioAccion'),
            'status' => 'etapa 3 - Aceptación de eficacia',
        ]);
        // Mail eliminacion
        $acciones = accionesCorrectivas::where('folioAccion', $folioEficacia)->first();
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();

        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];

        if ($mailto && $mailto->email) {
            $mailaddresses[] = $mailto->email;
        }
        registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Registro de medición de eficacia para la accion correctiva ID: '.$folioEficacia]);
        $mail = Mail::to($mailaddresses)->send(new medicionEficacia($acciones, 'Registro de medición de eficacia para acción correctiva'));

        return redirect()->route('accionesCorrectivas.show', $folioEficacia)->with('success', 'Registro de medición de eficacia exitoso.');
    }

    public function statusSubAccion(Request $request, $id, $folio)
    {
        $id = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $id);
        $folio = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $folio);
        $request->validate([
            'statusSubAccion' => 'required|string|max:6',
        ]);
        $statusSubAccion = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('statusSubAccion'));
        sub_acciones_model::where('id', $id)->update([
            'statusSubAccion' => $statusSubAccion,
        ]);
        if ($statusSubAccion == 'Closed') {
            $subAcciones = sub_acciones_model::where('id', $id)->first();
            $acciones = accionesCorrectivas::where('folioAccion', $folio)->first();
            $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();

            $mailaddresses = [
                'jgarrido@mx.bergstrominc.com',
                'maleman@mx.bergstrominc.com',
            ];

            if ($mailto && $mailto->email) {
                $mailaddresses[] = $mailto->email;
            }
            registoLogin::create(['fecha' => carbon::now()->format('d-m-Y H:i'), 'userName' => session('user'), 'action' => 'Aceptacion de planes de accion para la accion correctiva ID: '.$folio]);
            Mail::to($mailaddresses)->send(new planAccion($subAcciones, 'Aceptación de planes de accion'));
        }

        return redirect()->route('accionesCorrectivas.show', $folio)->with('success', 'Estatus de sub acción actualizado exitosamente.');
    }
}
