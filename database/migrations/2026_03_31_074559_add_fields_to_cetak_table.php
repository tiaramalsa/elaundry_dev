<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cetak', function (Blueprint $table) {
            $table->enum('tipe_kertas', ['53mm','80mm'])->default('80mm');
            $table->integer('custom_width')->nullable();
            $table->boolean('show_logo')->default(false);
            $table->boolean('show_maps')->default(true);
        });
    }

    public function down()
    {
        Schema::table('cetak', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_kertas',
                'custom_width',
                'show_logo',
                'show_maps'
            ]);
        });
    }
};