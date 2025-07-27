<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('namalengkap');  
            $table->string('nomor_anggota');
            $table->enum('jenis', ['Siswa', 'Guru', 'Karyawan']);
            $table->string('kelas')->nullable(); 
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota');
    }
};
