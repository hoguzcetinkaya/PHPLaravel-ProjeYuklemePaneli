<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bolum extends Model
{
    use HasFactory;
    protected $table="bolum";
    protected $fillable=["bolumAdi","bolumSeflink","fakulte_id","created_at","updated_at"];
}
