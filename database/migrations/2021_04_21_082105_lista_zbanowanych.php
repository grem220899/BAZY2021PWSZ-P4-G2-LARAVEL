<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListaZbanowanych extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ban_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date_ban');
            $table->timestamp('date_uban')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_ban_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ban_list');
    }
}
