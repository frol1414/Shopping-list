<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $table = 'ref.social_network';

    const vkontakte = 1;
    const facebook = 2;
    const google = 3;
    const mailru = 4;
    const yandex = 5;
//    const youtube = 6;
//    const twitch = 7;

    protected $fillable = [
        'id',
        'title',
        'css_class',
        'sort',
        'key'
    ];
}
