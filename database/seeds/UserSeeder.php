<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'id' => Str::uuid(),
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => \Illuminate\Support\Facades\Hash::make('12345'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
