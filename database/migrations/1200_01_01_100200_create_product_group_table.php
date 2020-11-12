<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_group', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('external_id')->unique()->nullable()->comment('Внешний id');
            $table->string('color', 7)->comment('Цвет группы');
            $table->uuid('user_id')->nullable()->comment('Ключ пользователя');
            $table->integer('sort')->nullable()->comment('Сортировка');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')
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
        Schema::dropIfExists('product_group');
    }
}
