<?php

namespace App\Models\Public1;

use Illuminate\Database\Eloquent\Model;

class UserM2MList extends Model
{
    protected $table = 'user_m2m_list';

    protected $fillable = [
        'user_id', 'list_id'
    ];
}
