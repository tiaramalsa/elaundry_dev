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
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->foreignId('kurir_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropForeign(['kurir_id']);
            $table->dropColumn('kurir_id');
        });
    }

};
