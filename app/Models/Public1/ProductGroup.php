<?php

namespace App\Models\Public1;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use UsesUuid;

    protected $table = 'product_group';

    protected $fillable = [
        'external_id', 'product_group_id', 'title', 'unit', 'marked', 'list_id', 'user_id'
    ];

    protected $hidden = [
    ];

}
