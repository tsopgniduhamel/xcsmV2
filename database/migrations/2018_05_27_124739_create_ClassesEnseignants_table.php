<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesEnseignantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ClassesEnseignants', function(Blueprint $table){
            
            $table->increments('id');
            $table->string('Classe_code');
            $table->integer('Enseignant_id')->unsigned();            
            $table->foreign('Classe_code')
                  ->references('code')
                  ->on('Classe')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->foreign('Enseignant_id')
                  ->references('id')
                  ->on('users')
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
            $table->dropForeign('Classe_Classe_id_foreign');
            $table->dropForeign('Classe_Enseignant_id_foreign');
        });
        Schema::dropIfExists('CreateClassesEnseignants');
    }
}
