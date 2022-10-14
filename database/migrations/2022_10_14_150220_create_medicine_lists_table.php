<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medical_record_id')->unsigned()->nullable();
            $table->bigInteger('stock_id')->unsigned()->nullable();
            $table->integer('quantity')->unsigned()->default(0)->comment('Quantity for medicine stock need to be give to patien');
            $table->boolean('confirmed')->nullable()->default(false)->comment('If confirmed is true, then stock will be decreased based on quantity here');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('set null');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_lists');
    }
}
