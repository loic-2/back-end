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
        Schema::table('taches', function (Blueprint $table) {
            $table->foreign(['id_personnel'], 'taches_ibfk_1')->references(['id_personnel'])->on('personnels')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_activite'], 'taches_ibfk_2')->references(['id_activite'])->on('activites')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign('taches_ibfk_1');
            $table->dropForeign('taches_ibfk_2');
        });
    }
};
