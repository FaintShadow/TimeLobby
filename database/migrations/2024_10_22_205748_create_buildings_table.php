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
        Schema::create('buildings', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->foreignId('institute_id')->constrained()->cascadeOnDelete();
            $table->integer('maxCapacity')->default(30);
            $table->foreignId('building_id')->nullable()->constrained()->cascadeOnDelete();

            $table->unique(['name', 'institute_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};


