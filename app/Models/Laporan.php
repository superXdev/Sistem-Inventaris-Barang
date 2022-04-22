<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'orang', 'jumlah', 'root_id', 'berat', 'harga', 'jenis'];
}
