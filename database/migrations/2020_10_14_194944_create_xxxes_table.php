<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXxxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xxxes', function (Blueprint $table) {
            $table->id();                 // ID serial automático en la table de la BD
            $table->timestamps();         // Crea 2 columnas created_at y updated_at en la tabla de la BD de tipo TimeStamp. El valor lo añade automáticamente, no es necesario enviarlo desde el frontend ni asignarlo en el método del Controlador el backend.
            $table->string('title');
            $table->string('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xxxes');
    }
}
