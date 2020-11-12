<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserM2MListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_m2m_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('user_id')->comment('Ключ пользователя');
            $table->uuid('list_id')->comment('Ключ списка');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('list_id')->references('id')->on('list')
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
        Schema::dropIfExists('user_m2m_list');
    }
}
