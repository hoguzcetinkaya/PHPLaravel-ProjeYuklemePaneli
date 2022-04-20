<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Fakulte;

class Bolum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolum', function (Blueprint $table) {
            $table->id();
            $table->string("bolumAdi");
            $table->string("bolumSeflink");
            $table->unsignedBigInteger("fakulte_id")->nullable();// FOREIGN KEY TANIMLAMA unsignedBigInteger
            //tanımlanan foreign key'i fakulte tablosundaki id kısmıyla eşitliyoruz bağlıyoruz
            //onDelete("cascade") kodu ise kategoriler tablosundaki o id'ye sahip değer silinirse foreign key ile bağlı olan tabloda silinsin demektir
            $table->timestamps();
            $table->foreign("fakulte_id")->references("id")->on("fakulte")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolum');
    }
}
