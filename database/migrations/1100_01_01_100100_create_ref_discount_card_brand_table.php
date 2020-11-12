<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefDiscountCardBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref.discount_card_brand', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title')->comment('Название бренда');
//            $table->string('logo')->comment('Логотип бренда');
//            $table->string('card_image')->nullable()->comment('Картинка для карты');
            $table->string('type_barcode')->comment('Тип кодирования штриха');
            $table->string('key')->unique()->comment('Машинное имя');
            $table->integer('sort')->default(0)->comment('Сортировка');
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
        Schema::dropIfExists('ref.discount_card_brand');
    }
}
