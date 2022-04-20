<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjeOnerileri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projeOnerileri', function (Blueprint $table) {
            $table->id();
            $table->string("baslik")->nullable();
            $table->string("seflink")->nullable();
            $table->string("konu")->nullable();
            $table->string("yontem")->nullable();
            $table->string("anahtar")->nullable();
            $table->string("hocaAciklama")->nullable();
            $table->enum("durum",[1,2])->default(1);
            $table->unsignedBigInteger("ogr_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->unsignedBigInteger("hoca_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            $table->timestamps();
            $table->foreign("ogr_id")->references("id")->on("ogrenciler")->onDelete("cascade");
            $table->foreign("hoca_id")->references("id")->on("hocalar")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projeOnerileri');
    }
}
