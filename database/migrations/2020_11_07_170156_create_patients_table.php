<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {

            //$table->id();
            $table->foreignId('user_id')->primary()->references('id')->on('users');
                                     // ->constrained('users')
            $table->float('height', 8, 2);

            $table->string('role_name');  $table->foreign('role_name')->references('name')->on('roles');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
