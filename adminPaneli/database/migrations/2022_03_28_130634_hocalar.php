<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Hocalar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocalar', function (Blueprint $table) {
            $table->id();
            $table->string("adsoyad");
            $table->string("seflink");
            $table->string("sifre")->nullable();
            $table->string("unvan");
            $table->string("email");
            $table->enum('durum',[1,2])->default(1); //1 AKTIF 2 PASIF
            $table->integer("sayac")->default(0);
            $table->unsignedBigInteger("fakulte_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->unsignedBigInteger("bolum_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->timestamps();
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
        Schema::dropIfExists('hocalar');
    }
}
