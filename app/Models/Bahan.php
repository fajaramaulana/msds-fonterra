<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $fillable = ['id_jasa', 'nama_bahan', 'description', 'image', 'status'];
}
