<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurrences', function (Blueprint $table) {
            $table->id();
            $table->integer("input_id")->unsigned()->nullable();
            $table->foreign('input_id')->references('id')->on('inputs');
            $table->integer("output_id")->unsigned()->nullable();
            $table->foreign('output_id')->references('id')->on('outputs');
            $table->float('portion');
            $table->date('due_date');
            $table->string('payment_slip')->nullable();
            $table->string('payment_voucher')->nullable();
            $table->boolean('payment_status');
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
        Schema::dropIfExists('recurrences');
    }
}
