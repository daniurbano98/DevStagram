<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request) 
    {
        // dd('Post...');
//con esto le añadimos un helper que aunque introduzcamos espacion o acenton cundo lo insertemos en la bbdd lo va a juntar con guiones
        $request->request->add(['username' => Str::slug($request->username)]); 
//validamos en funcion de las restricciones que deseemos
        $this->validate($request, [
            'name' => 'required | max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);
//creamos el user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password) //proteger la contraseña
        ]);

        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);


        return redirect()->route('posts.index',  ['user' => auth()->user()->username]);
    }
}
