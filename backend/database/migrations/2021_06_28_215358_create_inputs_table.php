<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputs', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id")->nullable();
            $table->foreign("client_id")->references("id")->on("clients");
            $table->integer("service_id")->nullable();
            $table->foreign("service_id")->references("id")->on("services");
            $table->string("description");
            $table->integer("recurrence");
            $table->integer("recurrence_lenght")->nullable();
            $table->integer("recurrence_type")->nullable();
            $table->float("amount");
            $table->float("portion_amount")->nullable();
            $table->date("due_date");
            $table->boolean("payment_status");
            $table->integer("cat_input_id")->nullable();
            $table->integer("subcat_input_id")->nullable();
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
        Schema::dropIfExists('inputs');
    }
}
