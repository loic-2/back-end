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
        Schema::table('clients', function (Blueprint $table) {
            $table->foreign(['id_assureur'], 'clients_ibfk_1')->references(['id_assureur'])->on('assureurs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_personne'], 'clients_ibfk_2')->references(['id_personne'])->on('personnes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_ibfk_1');
            $table->dropForeign('clients_ibfk_2');
        });
    }
};
