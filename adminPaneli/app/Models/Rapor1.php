<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor1 extends Model
{
    use HasFactory;
    protected $table="rapor1";
    protected $fillable=["dosya","aciklama","durum","ogr_id","hoca_id","proje_id","created_id","updated_id"];
}
