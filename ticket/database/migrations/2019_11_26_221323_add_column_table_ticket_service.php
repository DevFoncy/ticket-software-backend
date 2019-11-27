<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableTicketService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('comment')->nullable();
            $table->string('time_solution')->nullable();
            $table->string('answer')->nullable();
            $table->string('is_open')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('comment');
            $table->string('time_solution');
            $table->string('answer');
            $table->string('is_open');
        });
    }
}
