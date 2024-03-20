<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            //$table->string('title');

            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();

            /*$table->string('address')->nullable();*/

            $table->string( 'description' )
                ->nullable();

            $table->enum( 'status', [ 'pending', 'opened', 'completed', 'closed' ] )
                ->default( 'opened' );

            $table->boolean('is_recurring')
                ->default(0);

            $table->json('rrule')
                ->nullable();

            $table->string('duration')
                ->nullable();

            $table->string( 'backgroundColor', 20 )
                ->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
