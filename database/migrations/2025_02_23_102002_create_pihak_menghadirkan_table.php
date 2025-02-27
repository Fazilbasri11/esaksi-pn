<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('pihak_menghadirkan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_perdata', ['gugatan', 'gugatan_sederhana', 'permohonan']);
            $table->enum('pihak', ['tergugat', 'penggugat', 'turut_tergugat', 'pemohon', 'termohon']);
            $table->string('nama');
            $table->string('no_telp');
            $table->string('no_perkara')->nullable()->default("");
            $table->integer('index')->nullable(); // Tambahkan setelah kolom 'no'
            $table->integer('jumlah_saksi')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pihak_menghadirkan');
    }
};
