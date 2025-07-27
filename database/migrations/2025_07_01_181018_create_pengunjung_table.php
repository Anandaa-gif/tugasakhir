<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengunjungTable extends Migration
{
    public function up()
    {
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['siswa', 'guru', 'tamu']);
            $table->string('kelas')->nullable();
            $table->string('tujuan');
            $table->date('waktu_kunjung');
            $table->text('alamat')->nullable(); // Tambahan alamat
            $table->text('kesan_pesan')->nullable(); // Untuk tamu
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengunjung');
    }
}
