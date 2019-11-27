<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableTickets extends Migration
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
            $table->string('tipoPregunta')->nullable();
            $table->string('tipoProblema')->nullable();
            $table->string('tipoHerramienta')->nullable();

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
            $table->dropColumn('tipoPregunta');
            $table->dropColumn('tipoProblema');
            $table->dropColumn('tipoHerramienta');


        });
    }
}
