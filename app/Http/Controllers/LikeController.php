<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        //en la request podemos sacar el user y utilizamos el metodo likes que enlaza los likes con el modelo user
        //y que elimine el registro de la tabla like donde el post_id sea igual al que le hemos pasado por parametro
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
