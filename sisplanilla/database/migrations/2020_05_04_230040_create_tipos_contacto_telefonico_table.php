<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposContactoTelefonicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_contacto_telefonico', function (Blueprint $table) {
            $table->increments('id_tipo_contacto_telefonico');
            $table->string('titulo',10);
            $table->timestamps();
        });
        DB::table('tipos_contacto_telefonico')->insert(array('id_tipo_contacto_telefonico'=>'1', 'titulo'=>'Hogar'));
        DB::table('tipos_contacto_telefonico')->insert(array('id_tipo_contacto_telefonico'=>'2', 'titulo'=>'Movil'));
        DB::table('tipos_contacto_telefonico')->insert(array('id_tipo_contacto_telefonico'=>'3', 'titulo'=>'Negocio'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_contacto_telefonico');
    }
}
