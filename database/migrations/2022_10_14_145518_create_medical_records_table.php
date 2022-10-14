<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned()->nullable()->comment('Patient ID');
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('Doctor ID as operator on poliklinik');
            $table->string('medical_issue', 200)->comment('Filled by the doctor. Real estimate medical issue of a patient')->nullable();
            $table->string('medical_handle', 200)->nullable()->comment('Filled by the doctor. Hanlde of the doctor');
            $table->date('treated_at')->default(Carbon::now())->comment('Date start of treated');
            $table->date('treated_to')->nullable()->comment('Date finish treated');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}
