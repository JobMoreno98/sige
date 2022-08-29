<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class re_baja_item_baja extends Model
{
    use HasFactory;

    protected $table = 're_baja_item_baja';

    //relacion uno a muchos
    public function item_baja(){
        return $this->belongsTo('App\Models\item_baja');
    }

    public function baja(){
        return $this->belongsTo('App\Models\Baja');
    }

}
