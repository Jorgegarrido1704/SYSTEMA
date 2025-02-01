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
            session(['user'=> $user]);



            // If user exists, create a new login record
            $newLog = new registoLogin;
            $newLog->fecha = $today;
            $newLog->userName = $user;
            $newLog->action = "login";

            if ($newLog->save()) {
                // If login record is saved successfully, redirect to the admin page
                $buscauser=DB::select("SELECT category FROM login WHERE user='$user'");
                foreach($buscauser as $rowuser){
                    $categoria=$rowuser->category;
                }
                if($categoria=='Boss'){
                    session(['categoria'=>$categoria]);
                    return redirect('/boss');
                }else if($categoria=='Admin'){
                    session(['categoria'=>$categoria]);
                    return redirect('/admin');
                }else if($categoria=='cali'){
                    session(['categoria'=>$categoria]);
                    return redirect('/calidad');
                }else if($categoria=='ensa'){
                    session(['categoria'=>$categoria]);
                    return redirect('/general');
                }else if($categoria=='emba'){
                    session(['categoria'=>$categoria]);
                    return redirect('/general');
                }else if($categoria=='libe'){
                    session(['categoria'=>$categoria]);
                    return redirect('/general');
                 } else if($categoria=='cort'){
                    session(['categoria'=>$categoria]);
                        return redirect('/general');
                }else if($categoria=='loom'){
                    session(['categoria'=>$categoria]);
                    return redirect('/general');
                }else if($categoria=='plan'){
                    session(['categoria'=>$categoria]);
                    return redirect('/planing');
                }else if($categoria=='inge'){
                    session(['categoria'=>$categoria]);
                    return redirect('/ing');
                }else if($categoria=='alma'){
                    session(['categoria'=>$categoria]);
                    return redirect('/almacen');
                }else if($categoria=='BCali'){
                    session(['categoria'=>$categoria]);
                    return redirect('/BossCali');
                }else if($categoria=='inv'){
                    session(['categoria'=>$categoria]);
                    return redirect('/inventario');
                }else if($categoria=='junta'){
                    session(['categoria'=>$categoria]);
                    return redirect('/juntas');
                }else if($categoria=='SupAdmin'){
                    session(['categoria'=>$categoria]);
                    return redirect('/SupAdmin');
                }else if($categoria=='invent'){
                    session(['categoria'=>$categoria]);
                    return redirect('/globalInventario');
                }else if($categoria=='nurse'){
                    session(['categoria'=>$categoria]);
                    return redirect('/salud');
                }
                else {

                // If unable to save login record, redirect back with an error message
                return redirect()->back()->with("error", "Failed to save login information");
            }
        } else {
            // If user does not exist with provided credentials, redirect back with an error message
            return redirect()->back()->with("error", "Invalid username or password");
        }
        }else {
            // If user does not exist with provided credentials, redirect back with an error message
            return redirect()->back()->with("error", "Invalid username or password");}
    }
    public function logout()
{
    // Get current date and time
    $today = date('d-m-Y H:i');

    $user = session('user');
    if($user==NULL){
        $user="Error";
    }

    // Create a new record for the logout action
    $newLog = new registoLogin;
    $newLog->fecha = $today;
    $newLog->userName = $user;
    $newLog->action = "logout";

    if ($newLog->save()) {
        session()->forget('user');
        // Redirect the user after logout
        return redirect('/');
    } else {
        // If unable to save login record, redirect back with an error message
        return redirect()->back()->with("error", "Failed to save logout information");
    }
}

}
