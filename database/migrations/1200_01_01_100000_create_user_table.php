<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50)->comment('Имя');
            $table->string('email', 254)->nullable()->unique()->comment('E-mail');
            $table->bigInteger('phone')->nullable()->comment('Телефон');
            $table->timestamp('email_verified_at')->nullable()->comment('Дата подтверждения e-mail');
            $table->string('password')->comment('Пароль в хешированном виде');
            $table->string('image', 100)->nullable()->comment('Имя картинки');
            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
}
