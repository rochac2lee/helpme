<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanIdTableServicesByClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_by_clients', function (Blueprint $table) {
            $table->integer("plan_id")->unsigned()->nullable();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->integer("aditionals_users")->nullable()->default(0);
            $table->string("api")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_by_clients', function (Blueprint $table) {
            $table->dropColumn('plan_id');
            $table->dropColumn('aditionals_users');
            $table->dropColumn('api');
        });
    }
}
