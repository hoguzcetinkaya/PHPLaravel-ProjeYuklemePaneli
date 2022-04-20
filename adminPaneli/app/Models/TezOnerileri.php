<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TezOnerileri extends Model
{
    use HasFactory;
    protected $table="tezonerileri";
    protected $fillable=["baslik","seflink","konu","dosya1","dosya2","durum","ogr_id","hoca_id","created_at","updated_at"];
}
