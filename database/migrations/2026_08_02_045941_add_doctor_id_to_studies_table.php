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
        Schema::table('studies', function (Blueprint $table) {
            // Agrega doctor_id como clave foránea después de patient_id
            $table->foreignId('doctor_id')
                  ->nullable()
                  ->after('patient_id')
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('studies', function (Blueprint $table) {
            Schema::table('studies', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropColumn('doctor_id');
        });
        });
    }
};
