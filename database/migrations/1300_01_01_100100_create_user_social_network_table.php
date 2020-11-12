<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSocialNetworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_network', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('external_id', 200)->comment('Id пользователя в социальной сети');
            $table->uuid('user_id')->comment('Ключ пользователя');
            $table->integer('ref_social_network_id')->comment('Ключ справочника социальной сети');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('CASCADE')->onDelete('CASCADE'); //todo уточнить

            $table->foreign('ref_social_network_id')->references('id')->on('ref.social_network')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_social_network');
    }
}
