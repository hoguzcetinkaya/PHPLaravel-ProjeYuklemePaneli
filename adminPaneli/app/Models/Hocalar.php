<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hocalar extends Model
{
    use HasFactory;
    protected $table="hocalar";
    protected $fillable=["adsoyad","seflink","sifre","unvan","email","durum","sayac","fakulte_id","bolum_id","created_at","updated_at"];
}

