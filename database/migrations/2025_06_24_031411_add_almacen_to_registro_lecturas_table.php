<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('registro_lecturas', 'almacen')) {
            Schema::table('registro_lecturas', function (Blueprint $table) {
                $table->string('almacen')->nullable()->after('cliente');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('registro_lecturas', 'almacen')) {
            Schema::table('registro_lecturas', function (Blueprint $table) {
                $table->dropColumn('almacen');
            });
        }
    }
};
