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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('organizer_id');

            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description');

            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('timezone')->default('Europe/Budapest');
            $table->boolean('allDay')->default(false);

            $table->enum('status', ['posted', 'cancelled'])->default('posted');

            $table->string('backgroundColor')->nullable();
            $table->string('backgroundColorDark')->nullable();


            $table->fullText(['title', 'description']);

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->restrictOnDelete();

            $table->foreign('organizer_id')
                ->references('id')
                ->on('organizers')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
