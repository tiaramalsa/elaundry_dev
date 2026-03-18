<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kurirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Data kerja
            $table->string('id_kurir')->unique();
            $table->enum('status', ['aktif','tidak_aktif'])->default('aktif');
            $table->date('bergabung_sejak')->nullable();
            $table->string('plat_nomor')->nullable();
            $table->string('jenis_kendaraan')->nullable();

            // Foto profile
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurirs');
    }
};
