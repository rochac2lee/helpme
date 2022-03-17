<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputsSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs_subcategories', function (Blueprint $table) {
            $table->id();
            $table->integer("output_category_id")->unsigned()->nullable();
            $table->foreign('output_category_id')->references('id')->on('outputs_categories');
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
        Schema::dropIfExists('outputs_subcategories');
    }
}
