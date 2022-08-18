<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisicion extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function articulos(){
        return  $this->hasMany('App\Models\Articulo');
    }
}
