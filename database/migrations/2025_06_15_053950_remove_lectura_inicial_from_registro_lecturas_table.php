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
        Schema::table('registro_lecturas', function (Blueprint $table) {
            $table->dropColumn('lectura_inicial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_lecturas', function (Blueprint $table) {
            $table->string('lectura_inicial')->nullable();
        });
    }
};
