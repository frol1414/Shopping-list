<?php

namespace App\Models\Public1;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use UsesUuid, SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'external_id', 'product_group_id', 'title', 'unit', 'marked', 'list_id', 'user_id'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function lists()
    {
        return $this->hasOne(Lists::class, 'id', 'list_id');
    }

    public function product_group()
    {
        return $this->hasOne(ProductGroup::class, 'id', 'product_group_id');
    }
}
