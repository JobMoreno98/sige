<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulos_requisiones extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'articulos_requisiciones';
}
