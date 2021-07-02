<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_treatments', function (Blueprint $table) {

            $table->foreignId('patient_id')->references('patient_id')->on('patient_states');
            $table->date('patient_state_date');     $table->foreign('patient_state_date')->references('date')->on('patient_states');
            $table->date('treatment_date');
            $table->primary(['patient_id', 'patient_state_date', 'treatment_date'], 'patient_treatments_pk');

            $table->foreignId('diet')->references('id')->on('diets')->nullable();
            $table->foreignId('physical_activity')->references('id')->on('physical_activities')->nullable();
            $table->foreignId('medication')->references('id')->on('medications')->nullable();

            $table->string('observations')->nullable();

            $table->foreignId('doctor')->references('user_id')->on('doctors')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_treatments');
    }
}
