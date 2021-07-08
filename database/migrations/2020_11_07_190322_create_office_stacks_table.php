<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeStacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_stacks', function (Blueprint $table) {
            //$table->id();
            $table->foreignId('user_id')->primary()->references('id')->on('users');
                                     // ->constrained('users')
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
        Schema::dropIfExists('office_stacks');
    }
}
