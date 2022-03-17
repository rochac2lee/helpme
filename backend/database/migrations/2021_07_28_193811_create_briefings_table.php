<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBriefingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('briefings', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id")->nullable();
            $table->foreign("client_id")->references("id")->on("clients");
            $table->string("type")->nullable();
            $table->string("name")->nullable();
            $table->string("cnpj")->nullable();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("socials")->nullable();
            $table->string("adress")->nullable();
            $table->string("projectDeadline")->nullable();
            $table->integer("hasLogo")->nullable();
            $table->longText("comments")->nullable();
            $table->string("hasIntegration")->nullable();

            /** Campos do briefing do app */
            $table->string("companyServices")->nullable();
            $table->string("appFunctions")->nullable();
            $table->string("appRefer")->nullable();

            /** Campos do briefing do site */
            $table->string("home")->nullable();
            $table->string("about")->nullable();
            $table->string("contact")->nullable();
            $table->string("services")->nullable();
            $table->string("competitors")->nullable();
            $table->string("colors")->nullable();
            $table->string("colorsDont")->nullable();
            $table->string("appearance")->nullable();
            $table->string("siteRefer")->nullable();
            $table->string("copywriting")->nullable();

            /** Campos do briefing do sistema */
            $table->longText("companyDescription")->nullable();
            $table->string("whySystem")->nullable();
            $table->string("hasSystem")->nullable();
            $table->string("currentSystemFunction")->nullable();

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
        Schema::dropIfExists('briefings');
    }
}
