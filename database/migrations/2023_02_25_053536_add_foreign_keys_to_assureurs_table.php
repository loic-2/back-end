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
        Schema::table('assureurs', function (Blueprint $table) {
            $table->foreign(['id_personne'], 'assureurs_ibfk_1')->references(['id_personne'])->on('personnes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assureurs', function (Blueprint $table) {
            $table->dropForeign('assureurs_ibfk_1');
        });
    }
};
