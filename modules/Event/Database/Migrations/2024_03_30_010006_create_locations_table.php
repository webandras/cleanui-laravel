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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('address');
            $table->string('city');

            $table->double('latitude', 20, 14)->nullable();
            $table->double('longitude', 20, 14)->nullable();

            $table->softDeletesDatetime();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
