<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned()->nullable();
            $table->bigInteger('poliklinik_id')->unsigned()->nullable();
            $table->integer('queue_no')->unsigned()->default(0)->comment('Increment for each poliklinik id');
            $table->string('medical_issue', 200)->nullable()->comment('medical issue report by patient');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
            $table->foreign('poliklinik_id')->references('id')->on('polikliniks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
}
