<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class DiscountCardBrand extends Model
{
    protected $table = 'ref.discount_card_brand';

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
