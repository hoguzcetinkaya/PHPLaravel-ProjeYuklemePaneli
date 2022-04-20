<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kullanicilar extends Authenticatable
{
    use HasFactory;
    protected $table="kullanicilar";
    protected $fillable=["adSoyad","seflink","email","password","durum","gorev","created_at","updated_at"];
}
