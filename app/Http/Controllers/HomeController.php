<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

   public function __construct()
   {
      $this->middleware('auth');
   }
   public function __invoke()
   { 
         //con el metodo pluck sacamos el campo que nos interesa
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20); //sacamos todos los posts que contengan los ids pasados por parametro
        //con el wherein lo podemos pasar un array de valores, como en este caso hacemos

        return view('home',[
         'posts' => $posts
        ]);
   }
}
