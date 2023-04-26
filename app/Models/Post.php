<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {   //Un post pertenece a un usuaio (1:1)
        return $this->belongsTo(User::class)->select(['name','username']); //seleccionas los atributos que te interesa
                 //Traduccion: "pertenece a"
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        //Le pasamos el user logueado al metodo y comprobamos en la tabla de likes con el metodo 'contains'
        //si la columna user_id tiene el id del user pasado por parametro
        return $this->likes->contains('user_id', $user->id);
    }
}
