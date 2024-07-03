<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('order')->default(0);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('excerpt', 512)->nullable();
            $table->enum('status', ['draft', 'under-review', 'published'])->default('draft');

            $table->timestamps();

            $table->fullText(['title', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
