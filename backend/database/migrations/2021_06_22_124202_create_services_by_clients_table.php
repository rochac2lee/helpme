<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesByClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('services_by_clients');

        Schema::create('services_by_clients', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id");
            $table->foreign("client_id")->references("id")->on("clients");
            $table->integer("service_id");
            $table->foreign("service_id")->references("id")->on("services");
            $table->string("title");
            $table->longText("description")->nullable();
            $table->boolean("status");
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
        Schema::dropIfExists('services_by_clients');
    }

}
