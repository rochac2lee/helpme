<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputsSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputs_subcategories', function (Blueprint $table) {
            $table->id();
            $table->integer("input_category_id")->unsigned()->nullable();
            $table->foreign('input_category_id')->references('id')->on('inputs_categories');
            $table->string("subcategory")->nullable();
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
        Schema::dropIfExists('inputs_subcategories');
    }
}
