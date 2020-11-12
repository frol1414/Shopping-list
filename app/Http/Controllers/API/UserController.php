<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollaborationRequest;
use App\Http\Resources\API\Errors\EntityNotFoundResource;
use App\Http\Resources\API\Errors\UserCollaborationErrorResource;
use App\Http\Resources\API\System\SuccessAddRemResource;
use App\Http\Resources\API\UserSearchResource;
use App\Models\Public1\Lists;
use App\Models\Public1\User;
use App\Models\Public1\UserM2MList;
use App\Models\Public1\UserSocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return EntityNotFoundResource|AnonymousResourceCollection
     */
    public function userSearch(Request $request)
    {
        $query_search = $request->input('query');
        $list = Lists::where('external_id', $request->input('list_id'))->first();
        $users_id = UserM2MList::where('list_id', $list->id)->get()->pluck('user_id');

        $users = User::where('id', '<>', Auth::id())
            ->whereNotIn('id', $users_id)
            ->where(function ($query) use ($query_search) {
//                $query->where('nickname', 'ilike', $query . '%')
                $query->where('name', 'ilike', $query_search . '%')
                    ->orWhere('email', 'ilike', $query_search . '%');
            })
            ->limit(10)->get();

        if ($users->isNotEmpty()) {
            return UserSearchResource::collection($users);
        } else {
//            return new UserNotFoundResource(null);
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @param CollaborationRequest $request
     * @return EntityNotFoundResource|UserCollaborationErrorResource|SuccessAddRemResource
     */
    public function collaborationAdd(CollaborationRequest $request)
    {
        $param = $request->only('list_id', 'user_id');

        $list = Lists::where('user_id', Auth::id())->where('external_id', $param['list_id'])->first();

        if ($list) {
            $is_create = UserM2MList::firstOrNew([
                'user_id' => $param['user_id'],
                'list_id' => $list->id
            ]);
            if (isset($is_create->id)) {
                return new UserCollaborationErrorResource(null);
            } else {
                $is_create->save();

                return new SuccessAddRemResource(null);
            }
        } else {
            return new EntityNotFoundResource(null);
        }
//        return new UserCollaborationErrorResource(null);
    }

    /**
     * @param CollaborationRequest $request
     * @return EntityNotFoundResource|UserCollaborationErrorResource|SuccessAddRemResource
     */
    public function collaborationDel(CollaborationRequest $request)
    {
        $param = $request->only('list_id', 'user_id');

        $list = Lists::where('user_id', Auth::id())->where('external_id', $param['list_id'])->first();

        if ($list) {
            $is_delete = UserM2MList::where('user_id', $param['user_id'])->where('list_id', $list->id)->delete();
            if ($is_delete) {
                return new SuccessAddRemResource(null);
            } else {
                return new UserCollaborationErrorResource(null);
            }
        } else {
            return new EntityNotFoundResource(null);
        }
//        return new UserCollaborationErrorResource(null);
    }

    /**
     * @param $lists
     * @param $products
     * @param null $name
     * @param null $email
     * @param null $pass
     * @param bool $is_social
     * @param null $get_info
     * @param null $provider
     * @return User
     */
    public function userCreate($lists, $products, $name = null, $email = null, $pass = null, $is_social = false, $get_info = null, $provider = null)
    {
        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => $pass ? bcrypt($pass) : Hash::make(Str::random(16))
        ]);
        $new_list = [];
        $new_product = [];
//        $lists = [['title' => 'fsdf']];
        foreach ($lists as $key => $list) {
            $new_list[$key]['external_id'] = isset($list['external_id']) ? $list['external_id'] : null;
            $new_list[$key]['title'] = $list['title'];
            $new_list[$key]['slug'] = Str::random(15);
        }
        $created_lists = $user->lists()->createMany(
            $new_list
        );
        $list_id = $created_lists->pluck('id', 'external_id');
//        $test = array_column($created_lists, 'external_id', 'id');
//        dd($test);
        if ($products) {
            foreach ($products as $key => $product) {
                $new_product[$key]['external_id'] = isset($product['external_id']) ? $product['external_id'] : null;
                $new_product[$key]['title'] = $product['title'];
                $new_product[$key]['unit'] = $product['unit'];
                $new_product[$key]['marked'] = $product['marked'];
                $new_product[$key]['product_group_id'] = $product['product_group_id'];
                $new_product[$key]['list_id'] = $list_id[$product['list_id']];
            }
            $user->product()->createMany(
                $new_product
            );
        }

        if ($is_social) {
            UserSocialNetwork::create([
                'user_id' => $user->id,
                'ref_social_network_id' => constant('SocialNetwork::' . $provider),
                'external_id' => $get_info->getId(),
                'access_token' => $get_info->token
            ]);
        }

        return $user;
    }

    /**
     * @param $social_id
     * @param $provider
     * @return User|null
     */
    public function getUserSocial($social_id, $provider)
    {
        $user = null;
        $user_social = UserSocialNetwork::where('external_id', $social_id)->where('ref_social_network_id', constant('SocialNetwork::' . $provider))->with('user')->first();
        if ($user_social) {
            $user = $user_social->user;
        }
        return $user;
    }

    /*    public function getUserDiscountCard()
        {
            $discount_card =
        }*/
}
