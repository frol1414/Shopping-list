<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('external_id')->unique()->nullable()->comment('Внешний id');
            $table->string('title',50)->comment('Название списка');
            $table->string('slug',15)->unique()->comment('Slug списка, для ссылки');
            $table->uuid('user_id')->comment('Ключ пользователя');
//            $table->boolean('active')->default(true)->comment('Не удален ли список');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('list');
    }
}
