<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSablon extends Model
{
    use HasFactory;
    protected $table = 'jenis_sablons';

    protected $fillable = ['nama_sablon', 'harga'];
}
