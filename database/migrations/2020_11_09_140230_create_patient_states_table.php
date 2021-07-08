<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_states', function (Blueprint $table) {
            //$table->id();
            $table->foreignId('patient_id')->references('user_id')->on('patients');
            $table->date('date');
            $table->primary(['patient_id', 'date']);
            //$table->timestamps();

            $table->float('weight', 8, 2);
            $table->float('IMC', 8, 2);
            $table->float('muscle_mass', 8, 2);
            $table->float('fat_mass', 8, 2);
            $table->float('blood_pressure', 8, 2)->nullable();
            $table->float('cholesterol', 8, 2)->nullable();

            $table->boolean('checked')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_states');
    }
}
