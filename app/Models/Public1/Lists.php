<?php

namespace App\Models\Public1;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lists extends Model
{
    use UsesUuid, SoftDeletes;

    protected $table = 'list';

    protected $fillable = [
        'external_id', 'title', 'user_id', 'slug'
    ];

    protected $hidden = [
        'user_id', 'deleted_at'
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'list_id', 'id')->orderBy('product_group_id', 'ASC')->orderBy('created_at', 'DESC');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_m2m_list', 'list_id', 'user_id');
    }

    public function discount_card()
    {
        return $this->belongsToMany(DiscountCard::class, 'list_m2m_discount_card', 'list_id', 'discount_card_id');
    }
}
