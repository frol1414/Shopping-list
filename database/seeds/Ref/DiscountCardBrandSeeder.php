<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountCardBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref.discount_card_brand')->insert([
            [
                'id' => 1,
                'title' => 'Пятерочка',
//                'logo' => '',
                'type_barcode' => 'EAN-13',
                'key' => 'pyaterochka',
                'sort' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'title' => 'Лента',
                'type_barcode' => 'CODE128',
                'key' => 'lenta',
                'sort' => 100,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'title' => 'Перекресток',
                'type_barcode' => 'EAN-13',
                'key' => 'perekrestok',
                'sort' => 200,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'title' => 'Ikea Family',
                'type_barcode' => 'CODE39',
                'key' => 'ikea_family',
                'sort' => 300,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'title' => 'Красное & Белое',
                'type_barcode' => 'EAN-13',
                'key' => 'krasnoe_beloe',
                'sort' => 400,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'title' => 'ОКЕЙ',
                'type_barcode' => 'EAN-13',
                'key' => 'ok',
                'sort' => 500,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
