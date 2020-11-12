<?php

namespace App\Models\Public1;

use App\Models\Ref\DiscountCardBrand;
use Illuminate\Database\Eloquent\Model;

class DiscountCard extends Model
{
    protected $table = 'discount_card';

    protected $fillable = [
        'title',
        'barcode',
        'user_id',
        'color',
        'ref_brand_id'
    ];

    public function ref_brand()
    {
        return $this->belongsTo(DiscountCardBrand::class);
    }
}
