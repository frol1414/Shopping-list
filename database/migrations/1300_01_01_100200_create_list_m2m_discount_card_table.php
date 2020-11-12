<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListM2MDiscountCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_m2m_discount_card', function (Blueprint $table) {
            $table->id();
            $table->uuid('list_id')->comment('Ключ списка');
            $table->bigInteger('discount_card_id')->comment('Ключ дисконтной карты пользователя');
            $table->timestamps();

            $table->foreign('list_id')->references('id')->on('list')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('discount_card_id')->references('id')->on('discount_card')
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
        Schema::dropIfExists('list_m2m_discount_card');
    }
}
