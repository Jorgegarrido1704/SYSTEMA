<?php

namespace App\Http\Controllers;

use App\Models\login;
use Illuminate\Http\Request;
use App\Models\registoLogin;
use Illuminate\Support\Facades\Auth;
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
            $newLog->action = "login";

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
                } else if ($categoria == 'Admin') {
                    return redirect('/admin');
                } else if ($categoria == 'cali') {
                    return redirect('/calidad');
                } else if ($categoria == 'ensa') {
                    return redirect('/general');
                } else if ($categoria == 'emba') {
                    return redirect('/general');
                } else if ($categoria == 'libe') {
                    return redirect('/general');
                } else if ($categoria == 'cort') {
                    return redirect('/general');
                } else if ($categoria == 'loom') {
                    return redirect('/general');
                } else if ($categoria == 'plan') {
                    return redirect('/planing');
                } else if ($categoria == 'inge') {
                    return redirect('/ing');
                } else if ($categoria == 'alma') {
                    return redirect('/almacen');
                } else if ($categoria == 'BCali') {
                    return redirect('/BossCali');
                } else if ($categoria == 'inventario') {
                    return redirect('/inventarios');
                } else if ($categoria == 'junta') {
                    return redirect('/juntas');
                } else if ($categoria == 'SupAdmin') {
                    return redirect('/SupAdmin');
                } else if ($categoria == 'invent') {
                    return redirect('/globalInventario');
                } else if ($categoria == 'nurse') {
                    return redirect('/salud');
                } else if ($categoria == 'RRHH') {
                    return redirect('/rhDashBoard');
                } else {

                    // If unable to save login record, redirect back with an error message
                    return redirect()->back()->with("error", "Failed to save login information");
                }
            } else {
                // If user does not exist with provided credentials, redirect back with an error message
                return redirect()->back()->with("error", "Invalid username or password");
            }
        } else {
            // If user does not exist with provided credentials, redirect back with an error message
            return redirect()->back()->with("error", "Invalid username or password");
        }
    }
    public function logout()
    {
        // Get current date and time
        $today = date('d-m-Y H:i');

        $user = session('user');
        if ($user == NULL) {
            $user = "Error";
        }

        // Create a new record for the logout action
        $newLog = new registoLogin;
        $newLog->fecha = $today;
        $newLog->userName = $user;
        $newLog->action = "logout";

        if ($newLog->save()) {
            session()->forget('user');
            session()->forget('categoria');
            session()->forget('email');
            // Redirect the user after logout
            return redirect('/');
        } else {
            // If unable to save login record, redirect back with an error message
            return redirect()->back()->with("error", "Failed to save logout information");
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
            $newLog->action = "login by email link - ".$user;

          return  redirect()->to('/Pendigs');
        } else {
            // If user does not exist with provided credentials, redirect back with an error message
            return redirect('/login')->with("error", "Invalid username or password");
        }
    }
}
