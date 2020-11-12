<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefSocialNetworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref.social_network', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title', 100);
            $table->string('key', 100)->unique()->comment('Машинное имя');
            $table->string('css_class', 50)->nullable()->comment('Сss класс');
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
        Schema::dropIfExists('ref.social_network');
    }
}
