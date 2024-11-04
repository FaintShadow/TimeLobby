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
        Schema::create('institute_year', function (Blueprint $table) {
            $table->foreignId('institute_id')->constrained();
            $table->foreignId('year_id')->constrained();
        });

        Schema::create('institute_group', function (Blueprint $table) {
            $table->foreignId('institute_id')->constrained();
            $table->foreignId('group_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_year');
        Schema::dropIfExists('institute_group');
    }
};