<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id")->unsigned()->nullable();
            $table->foreign("client_id")->references("id")->on("clients");
            $table->string("type");
            $table->string("name");
            $table->string("phone");
            $table->string("email");
            $table->string("plan");
            $table->string("additional_users")->nullable();
            $table->string("additional_whats")->nullable();
            $table->boolean("status");
            $table->boolean("has_campaigns")->default(false);
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
        Schema::dropIfExists('requests');
    }
}
