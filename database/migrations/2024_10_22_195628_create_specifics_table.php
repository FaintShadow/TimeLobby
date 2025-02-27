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
        Schema::create('specifics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specifiable_id');
            $table->json('specifics');
            $table->year('begins_at');
            $table->year('ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifics');
    }
};
