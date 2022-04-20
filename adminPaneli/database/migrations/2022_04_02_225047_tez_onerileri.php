<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TezOnerileri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tezonerileri', function (Blueprint $table) {
            $table->id();
            $table->string("baslik")->nullable();
            $table->string("seflink")->nullable();
            $table->string("konu")->nullable();
            $table->string("dosya1")->nullable();
            $table->string("dosya2")->nullable();
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
        Schema::dropIfExists('tezonerileri');
    }
}
