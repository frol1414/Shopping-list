<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_card', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->comment('Название карты(магазина)');
            $table->string('barcode', 30)->comment('Номер карты');
            $table->uuid('user_id')->comment('Ключ пользователя');
            $table->string('color', 7)->nullable()->comment('Цвет карты');
            $table->integer('ref_brand_id')->nullable()->comment('Ключ бренда');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign('ref_brand_id')->references('id')->on('ref.discount_card_brand')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_card');
    }
}
