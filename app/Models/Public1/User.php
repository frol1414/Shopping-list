<?php

namespace App\Models\Public1;

use App\Traits\UsesUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use UsesUuid, Notifiable;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function lists()
    {
        return $this->hasMany(Lists::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function getLists()
    {
        return Lists::whereHas('user', function ($query){
            $query->where('user.id', $this->id);
        })->orWhere('user_id', $this->id)->orderBy('created_at', 'ASC')->get();
    }

    public function getProducts()
    {
        return Product::whereIn('list_id', $this->getLists()->pluck('id'))->get();
//        dd($this->lists->flatten());
//        return $this->lists->flatten(1);
//        return $this->hasMany(Product::class, 'user_id', 'id');
//        return $this->hasMany(Lists::class, 'user_id', 'id')->with('product');
//        dd($middle->getResults());
//        return $middle->getResults()->product;
    }
}
