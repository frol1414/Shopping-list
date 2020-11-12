<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //создание схемы для справочников
        DB::statement('CREATE SCHEMA ref');
        //создание схемы для справочников
        DB::statement('CREATE SCHEMA log');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //удаление схемы для справочников
        DB::statement('DROP SCHEMA ref');
        //удаление схемы для справочников
        DB::statement('DROP SCHEMA log');
    }
}
