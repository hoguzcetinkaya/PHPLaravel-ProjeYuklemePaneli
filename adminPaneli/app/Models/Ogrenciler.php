<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ogrenciler extends Model
{
    use HasFactory;
    protected $table="ogrenciler";
    protected $fillable=["ogr_no","adSoyad","seflink","email","sifre","telefon","sinif","resim","durum","hoca_id","fakulte_id","bolum_id","created_at","updated_at"];
}
