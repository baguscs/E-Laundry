<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('nama');
            $table->string('alamat');
            $table->string('telpon');
            $table->string('img_ktp')->nullable();
            $table->string('img');
            $table->string('ijazah')->nullable();
            $table->string('sekolah');
            $table->string('kelamin');
            $table->string('status');
            $table->string('kode')->nullable();
            $table->string('email')->unique();
            $table->string('akses')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
}
