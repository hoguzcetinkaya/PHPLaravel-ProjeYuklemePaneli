<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakulte extends Model
{
    use HasFactory;
    protected $table="fakulte";
    protected $fillable=["fakulteAdi","fakulteSeflink","created_at","updated_at"];
}
