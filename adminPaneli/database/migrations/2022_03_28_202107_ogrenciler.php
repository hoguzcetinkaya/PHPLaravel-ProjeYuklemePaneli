<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bolum;
use App\Models\Fakulte;
use App\Models\Hocalar;

class Ogrenciler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ogrenciler', function (Blueprint $table) {
            $table->id();
            $table->string("ogr_no");
            $table->string("adSoyad");
            $table->string("seflink")->nullable();
            $table->string("email");
            $table->string("sifre")->nullable();
            $table->string("telefon");
            $table->string("sinif");
            $table->string("resim",255)->nullable();
            $table->enum('durum',[1,2])->default(1); //1 AKTIF 2 PASIF
            $table->unsignedBigInteger("hoca_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->unsignedBigInteger("fakulte_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->unsignedBigInteger("bolum_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->timestamps();
            $table->foreign("hoca_id")->references("id")->on("hocalar")->onDelete("cascade");
            $table->foreign("fakulte_id")->references("id")->on("fakulte")->onDelete("cascade");
            $table->foreign("bolum_id")->references("id")->on("bolum")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ogrenciler');
    }
}
