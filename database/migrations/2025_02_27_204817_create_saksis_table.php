<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saksis', function (Blueprint $table) {
            $table->id();
            $table->integer('pihak_id')->nullable();
            $table->timestamps();
            $table->enum('agenda', ['perdata', 'biasa']);
            $table->enum('jenis_pidana', ['perdata', 'pidana']);
            $table->string('no_perkara');
            $table->enum('pihak_menghadirkan', ['tergugat', 'penggugat', 'turut_tergugat', 'pemohon', 'termohon']);
            $table->enum('pihak', ['saksi', 'ahli', 'perorangan','badan_hukum','pengacara']);
            $table->string('nama_badan_hukum')->nullable()->default("");
            $table->string('nama')->nullable()->default("");
            $table->string('nomor_telepon');
            $table->string('tanggal');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saksis');
    }
};
