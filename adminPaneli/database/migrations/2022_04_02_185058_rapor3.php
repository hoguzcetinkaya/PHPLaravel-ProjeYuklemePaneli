<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rapor3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor3', function (Blueprint $table) {
            $table->id();
            $table->string("dosya")->nullable();
            $table->string("aciklama")->nullable();
            $table->enum("durum",[1,2])->default(2);//1 aktif 2 pasif
            $table->unsignedBigInteger("ogr_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->unsignedBigInteger("hoca_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->unsignedBigInteger("proje_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->timestamps();
            $table->foreign("ogr_id")->references("id")->on("ogrenciler")->onDelete("cascade");
            $table->foreign("hoca_id")->references("id")->on("hocalar")->onDelete("cascade");
            $table->foreign("proje_id")->references("id")->on("proje_onerileri")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rapor3');
    }
}
