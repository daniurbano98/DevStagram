<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!auth()->attempt($request->only('email','password'),$request->remember)){
            //con back puedes volver a la pagina anterior
            //con with puedes guardar datos en una especie de variable de sesion y poder mostarlo por tu vista
            return back()->with('mensaje', 'Credenciales incorrectas. Por favor, vuelve a intentarlo');
            //"Vuelve a la pagina anterior con este mensaje->credenciales incorrectas"
        }

        return redirect()->route('posts.index', ['user' => auth()->user()->username]);
    }
}
