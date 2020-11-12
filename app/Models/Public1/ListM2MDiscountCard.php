<?php

namespace App\Models\Public1;

use Illuminate\Database\Eloquent\Model;

class ListM2MDiscountCard extends Model
{
    protected $table = 'list_m2m_discount_card';

    protected $fillable = [
        'list_id', 'discount_card_id'
    ];
}
