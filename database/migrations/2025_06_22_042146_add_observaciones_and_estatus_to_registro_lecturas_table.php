<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registro_lecturas', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('imagen_lectura');
            $table->unsignedTinyInteger('estatus_registro')->default(0)->after('observaciones');
        });
    }

    public function down(): void
    {
        Schema::table('registro_lecturas', function (Blueprint $table) {
            if (Schema::hasColumn('registro_lecturas', 'observaciones')) {
                $table->dropColumn('observaciones');
            }
            if (Schema::hasColumn('registro_lecturas', 'estatus_registro')) {
                $table->dropColumn('estatus_registro');
            }
        });
    }
};