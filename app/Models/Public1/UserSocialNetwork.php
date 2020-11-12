<?php

namespace App\Models\Public1;

use App\Models\Ref\SocialNetwork;
use Illuminate\Database\Eloquent\Model;

class UserSocialNetwork extends Model
{
    protected $table = 'user_social_network';

    protected $fillable = [
        'user_id',
        'ref_social_network_id',
        'external_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ref_social_network()
    {
        return $this->belongsTo(SocialNetwork::class);
    }
}
