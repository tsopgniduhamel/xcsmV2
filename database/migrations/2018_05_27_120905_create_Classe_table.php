<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Classe', function(Blueprint $table){
            
            $table->integer('departement_id')->unsigned();
            $table->integer('niveau_id')->unsigned();
            $table->string('code');
            $table->primary('code');
            $table->foreign('departement_id')
                  ->references('id')
                  ->on('Departements')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->foreign('niveau_id')
                  ->references('id')
                  ->on('Niveau')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
                
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Classe', function(Blueprint $table) {
            $table->dropForeign('Classe_departement_id_foreign');
            $table->dropForeign('Classe_niveau_id_foreign');
        });
        Schema::dropIfExists('Classe');
    }
}
