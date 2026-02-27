<?php

namespace App\Http\Controllers;

use App\Mail\accionesCorrectivas\contencion;
use App\Mail\accionesCorrectivasRecordatorio;
use App\Models\accionesCorrectivas;
use App\Models\accionesCorrectivas\monitoreosAcciones;
use App\Models\personalBergsModel;
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
        $personal = personalBergsModel::select('employeeLider')->groupBy('employeeLider')->get();

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
        $request->validate([
            'fechaAccion' => 'required|date',
            'Afecta' => 'required|string|max:50',
            'origenAccion' => 'required|string|max:50',
            'resposableAccion' => 'required|string|max:80',
            'descripcionAccion' => 'required|string|max:500',

        ]);

        if ($request->input('origenAccion') == 'otro') {
            $origenAccion = $request->input('origenAccion').'-'.$request->input('origenAccionotro');
        } else {
            $origenAccion = $request->input('origenAccion');
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
        $accion->Afecta = $request->input('Afecta');
        $accion->origenAccion = $origenAccion;
        $accion->resposableAccion = $request->input('resposableAccion');
        $accion->descripcionAccion = $request->input('descripcionAccion');
        $accion->ultimoEmail = Carbon::now()->format('Y-m-d');
        $accion->save();
        $email = personalBergsModel::select('email')->where('employeeName', $request->input('resposableAccion'))->first();
        $mailaddresses = [
            'jgarrido@mx.bergstrominc.com',
            'maleman@mx.bergstrominc.com',
        ];
        /*
                if ($email && $email->email) {
                    $mailaddresses[] = $email->email;
                }
        */
        Mail::to($mailaddresses)->send(new accionesCorrectivasRecordatorio($accion, 'Acciones Correctivas Recordatorio'));

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva creada exitosamente.');
    }

    public function show($id)
    {
        $cat = session('categoria');
        $value = session('user');
        $problema = 'Alta rotación de empleados';
        $categorias = [];
        $registroPorquest = accionesCorrectivas::where('folioAccion', $id)->first();
        if (! empty($registroPorquest->porques)) {
            $categorias = explode(' | ', $registroPorquest->porques);
        } elseif (! empty($registroPorquest->Ishikawa)) {
            $categorias = json_decode($registroPorquest->Ishikawa, true);

        }

        $acciones = sub_acciones_model::where('folioAccion', $id)->get();

        $personal = personalBergsModel::select('employeeLider')->groupBy('employeeLider')->get();
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
            'porque1' => 'required|string|max:500',
            'conclusion' => 'required|string|max:500',

        ]);

        $registroPorquest = $request->input('porque1');

        for ($i = 2; $i <= 5; $i++) {
            $key = 'porque'.$i;
            if ($request->filled($key)) {
                $registroPorquest .= ' | '.$request->input($key);
            }
        }
        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        } else {
            $sistemic = false;
        }

        $accion = accionesCorrectivas::where('folioAccion', $id)->update([
            'porques' => $registroPorquest,
            'conclusiones' => $request->input('conclusion'),
            'IsSistemicProblem' => $sistemic,
            'status' => 'etapa 2 - Causa Raiz',
        ]);

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
        $accion = accionesCorrectivas::findOrFail($request->input('accion_id'));
        $accion->Ishikawa = $datosIshikawa;
        $accion->conclusiones = $request->input('conclusion');
        $accion->IsSistemicProblem = $sistemic;
        $accion->status = 'etapa 2 - Causa Raiz';
        $accion->save();

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
        sub_acciones_model::create([
            'folioAccion' => $request->input('id'),
            'descripcionSubAccion' => $request->input('accion'),
            'resposableSubAccion' => $request->input('reponsableAccion'),
            'fechaInicioSubAccion' => $request->input('fechaInicioAccion'),
            'fechaFinSubAccion' => $request->input('fechaFinAccion'),
            'auditorSubAccion' => $request->input('verificadorAccion'),

        ]);

        return redirect()->route('accionesCorrectivas.show', $request->input('id'))->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $accion = accionesCorrectivas::findOrFail($id);
        $accion->delete();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva eliminada exitosamente.');
    }

    public function guardarSeguimiento(Request $request, $id, $folio)
    {
        /* $request->validate([
             'accion_id' => 'required|integer',
             'seguimiento' => 'required|string|max:500',
             'validador' => 'required|string|max:500',
         ]);*/

        monitoreosAcciones::create([
            'folioAccion' => $folio,
            'idSubAccion' => $id,
            'descripcionSeguimiento' => $request->input('seguimiento'),
            'AprobadorSeguimiento' => $request->input('validador'),
        ]);

        return redirect()->route('accionesCorrectivas.show', $folio)->with('success', 'Acción correctiva actualizada exitosamente.');

    }

    public function guardarContencion(Request $request, $id)
    {
        $request->validate([

            'descripcionContencion' => 'required|string|max:500',
            'fechaCompromiso' => 'required|date',
        ]);

        $accion = accionesCorrectivas::where('folioAccion', $id)->update([
            'descripcionContencion' => $request->input('descripcionContencion'),
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

        $mail = Mail::to($mailaddresses)->send(new contencion('Acciones Correctivas Contencion', $acciones));

        return redirect()->route('accionesCorrectivas.show', $id)->with('success', 'Acción correctiva actualizada exitosamente.');
    }
}
