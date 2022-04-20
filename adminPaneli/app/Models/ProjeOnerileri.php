<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjeOnerileri extends Model
{
    use HasFactory;
    protected $table="projeonerileri";
    protected $fillable=["baslik","seflink","konu","yontem","anahtar","hocaAciklama","durum","ogr_id","hoca_id","created_at","updated_at"];
}
