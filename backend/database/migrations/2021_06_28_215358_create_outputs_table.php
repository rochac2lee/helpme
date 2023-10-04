<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
            $table->increments("id");
            $table->string("description");
            $table->string("recurrence");
            $table->string("recurrence_lenght")->nullable();
            $table->string("recurrence_type")->nullable();
            $table->float("amount");
            $table->float("portion_amount")->nullable();
            $table->date("due_date");
            $table->boolean("payment_status");
            $table->integer("cat_output_id")->nullable();
            $table->integer("subcat_output_id")->nullable();
            $table->integer("account_id");
            $table->longText("observation")->nullable();
            $table->dateTime("receipt_date")->nullable();
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
        Schema::dropIfExists('outputs');
    }
}
