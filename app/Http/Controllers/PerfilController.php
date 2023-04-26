<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
       
        $request->request->add(['username' => Str::slug($request->username)]); 
        
        $this->validate($request, [                                   //con esto permitimos que pueda guardar sin cmabiar su nombre
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3',
            'max:20','not_in:twitter,editar-perfil'],
        ]);

        $password = $request->input('password');
        $newPassword = $request->input('new-password');


        if($password != '' && $newPassword == '' || $password == '' && $newPassword != ''){
            return back()->with('mensaje', 'Por favor, introduce los dos campos de contraseña');
        }elseif($password != '' && $password != '' ){
            if (Hash::check($password, auth()->user()->password)) {
                $usuario = User::find(auth()->user()->id);
                $usuario->password = Hash::make($newPassword);
                $usuario->save();
            } else {
                return back()->with('mensaje', 'Contraseña incorrecta. Por favor, vuelve a intentarlo');
            }
        }

        if($request->imagen){
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid().".".$imagen->extension(); // con el str::uuid genera id unicos
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);
            $imagenPath = public_path('perfiles').'/'.$nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios

        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';
        $usuario->save();

        //Redireccionar usuario

        return redirect()->route('posts.index',$usuario->username);
    }
}
