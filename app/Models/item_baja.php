<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item_baja extends Model
{
    use HasFactory;

    protected $table ='item_baja';

    //relacion uno a muchos
    public function re(){
        return $this->HasOne('App\Models\re_baja_item_baja');
    }
}
