<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        // el attach se utiliza cuando hay una tabla pivote
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    public function destroy(User $user)
    {
        //el datach se utiliza para borrar en una tabla pivote
        $user->followers()->detach(auth()->user()->id);

        return back();
    }
}
