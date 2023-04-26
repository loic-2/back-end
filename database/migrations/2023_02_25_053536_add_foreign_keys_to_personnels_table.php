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
        Schema::table('personnels', function (Blueprint $table) {
            $table->foreign(['id_assureur'], 'personnels_ibfk_1')->references(['id_assureur'])->on('assureurs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_personne'], 'personnels_ibfk_2')->references(['id_personne'])->on('personnes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personnels', function (Blueprint $table) {
            $table->dropForeign('personnels_ibfk_1');
            $table->dropForeign('personnels_ibfk_2');
        });
    }
};
