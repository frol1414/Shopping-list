<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('external_id')->unique()->nullable()->comment('Внешний id');
            $table->string('title', 100)->comment('Название продукта');
            $table->string('unit', 10)->nullable()->comment('Единица измерения, задваеммая пользователем в свободном виде');
            $table->boolean('marked')->default(false)->comment('Отмечен ли товар');
            $table->uuid('user_id')->nullable()->comment('Ключ пользователя');
            $table->uuid('list_id')->comment('Ключ списка');
            $table->uuid('product_group_id')->nullable()->comment('Ключ группы продуктов');
            $table->integer('sort')->nullable()->comment('Для сортировки');
//            $table->boolean('active')->default(true)->comment('Не удален ли товар');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('user')
                ->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign('list_id')->references('id')->on('list')
                ->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign('product_group_id')->references('id')->on('product_group')
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
        Schema::dropIfExists('product');
    }
}
