<?php

namespace App\Http\Controllers;

use App\Models\login;
use App\Models\registoLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        //
        return view('login');
    }

    public function index()
    {
        return view('login');
    }

    public function create()
    {
        //

    }

    public function store(Request $request)
    {
        // Get current date and time
        $today = date('d-m-Y H:i');

        // Get user input
        $user = $request->input('user');
        $pass = $request->input('password');

        // Check if user exists with the provided credentials
        $userExists = login::where('user', $user)
            ->where('clave', $pass)
            ->exists();

        if ($userExists) {
            session(['user' => $user]);

            // If user exists, create a new login record
            $newLog = new registoLogin;
            $newLog->fecha = $today;
            $newLog->userName = $user;
            $newLog->action = 'login';

            if ($newLog->save()) {
                // If login record is saved successfully, redirect to the admin page
                $buscauser = DB::select("SELECT category,user_email FROM login WHERE user='$user'");
                foreach ($buscauser as $rowuser) {
                    $categoria = $rowuser->category;
                    $email = $rowuser->user_email;
                }
                session((['categoria' => $categoria]));
                session((['email' => $email]));
                if ($categoria == 'Boss') {
                    return redirect('/boss');
                } elseif ($categoria == 'Admin') {
                    return redirect('/admin');
                } elseif ($categoria == 'cali') {
                    return redirect('/calidad');
                } elseif ($categoria == 'ensa' || $categoria == 'emba' || $categoria == 'libe' || $categoria == 'cort' || $categoria == 'loom') {
                    return redirect('/general');
                } elseif ($categoria == 'plan') {
                    return redirect('/planing');
                } elseif ($categoria == 'inge') {
                    return redirect('/ing');
                } elseif ($categoria == 'alma') {
                    return redirect('/almacen');
                } elseif ($categoria == 'BCali') {
                    return redirect('/BossCali');
                } elseif ($categoria == 'invreg1' || $categoria == 'invreg2' || $categoria == 'auditor' || $categoria == 'invwo1' || $categoria == 'invwo2') {
                    return redirect('/inventarios');
                } elseif ($categoria == 'pisos') {
                    return redirect('/pisoWork');
                } elseif ($categoria == 'Pendings') {
                    return redirect('/Pendigs');
                } elseif ($categoria == 'produ') {
                    return redirect('/produccion');
                } elseif ($categoria == 'mante') {
                    return redirect('/mantainence');
                } elseif ($categoria == 'segur') {
                    return redirect('/seguridad');
                } elseif ($categoria == 'cajero') {
                    return redirect('/caja');
                } elseif ($categoria == 'ventas') {
                    return redirect('/ventas');
                } elseif ($categoria == 'compra') {
                    return redirect('/compras');
                } elseif ($categoria == 'diseño') {
                    return redirect('/diseno');
                } elseif ($categoria == 'empresarial') {
                    return redirect('/empresarial');
                } elseif ($categoria == 'sistemas') {
                    return redirect('/sistemas');
                } elseif ($categoria == 'factura') {
                    return redirect('/facturacion');
                } elseif ($categoria == 'logis') {
                    return redirect('/logistica');
                } elseif ($categoria == 'exporta') {
                    return redirect('/exportacion');
                } elseif ($categoria == 'importa') {
                    return redirect('/importacion');
                } elseif ($categoria == 'diseno') {
                    return redirect('/diseno');
                } elseif ($categoria == 'calibra') {
                    return redirect('/calibracion');
                } elseif ($categoria == 'prose') {
                    return redirect('/procesos');
                } elseif ($categoria == 'recep') {
                    return redirect('/recepcion');
                } elseif ($categoria == 'provee') {
                    return redirect('/proveedores');
                } elseif ($categoria == 'junta') {
                    return redirect('/juntas');
                } elseif ($categoria == 'SupAdmin') {
                    return redirect('/SupAdmin');
                } elseif ($categoria == 'invent') {
                    return redirect('/globalInventario');
                } elseif ($categoria == 'nurse') {
                    return redirect('/salud');
                } elseif ($categoria == 'RRHH') {
                    return redirect('/rhDashBoard');
                } elseif ($categoria == 'herramentales') {
                    return redirect('/herramentales');
                } else {

                    // If unable to save login record, redirect back with an error message
                    return redirect()->back()->with('error', 'Failed to save login information');
                }
            } else {
                // If user does not exist with provided credentials, redirect back with an error message
                return redirect()->back()->with('error', 'Invalid username or password');
            }
        } else {
            // If user does not exist with provided credentials, redirect back with an error message
            return redirect()->back()->with('error', 'Invalid username or password');
        }
    }

    public function logout()
    {
        // Get current date and time
        $today = date('d-m-Y H:i');

        $user = session('user');
        if ($user == null) {
            $user = 'Error';
        }

        // Create a new record for the logout action
        $newLog = new registoLogin;
        $newLog->fecha = $today;
        $newLog->userName = $user;
        $newLog->action = 'logout';

        if ($newLog->save()) {
            session()->forget('user');
            session()->forget('categoria');
            session()->forget('email');

            // Redirect the user after logout
            return redirect('/');
        } else {
            // If unable to save login record, redirect back with an error message
            return redirect()->back()->with('error', 'Failed to save logout information');
        }
    }

    public function loginWithoutSession(Request $request)
    {
        // Get current date and time
        $today = date('d-m-Y H:i');

        // Get user input
        $user = $request->input('user');

        // Check if user exists with the provided credentials
        $userExists = login::where('user', $user)
            ->exists();

        if ($userExists) {
            session(['user' => $user]);

            // If user exists, create a new login record
            $newLog = new registoLogin;
            $newLog->fecha = $today;
            $newLog->userName = $user;
            $newLog->action = 'login by email link - '.$user;

            return redirect()->to('/Pendigs');
        } else {
            // If user does not exist with provided credentials, redirect back with an error message
            return redirect('/login')->with('error', 'Invalid username or password');
        }
    }
}
