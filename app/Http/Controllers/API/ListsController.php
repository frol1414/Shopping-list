<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListDiscountCardRequest;
use App\Http\Requests\ListsStoreRequest;
use App\Http\Requests\ListsUpdateRequest;
use App\Http\Resources\API\Errors\EntityNotFoundResource;
use App\Http\Resources\API\Errors\ListDiscountCardErrorResource;
use App\Http\Resources\API\ListsResource;
use App\Http\Resources\API\ShowListResource;
use App\Http\Resources\API\System\EntityDestroySuccessfulResource;
use App\Http\Resources\API\System\EntityUpdateSuccessfulResource;
use App\Http\Resources\API\System\SuccessAddRemResource;
use App\Models\Public1\DiscountCard;
use App\Models\Public1\ListM2MDiscountCard;
use App\Models\Public1\Lists;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListsController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $model = Auth::user()->getLists();

        return ListsResource::collection($model);
    }

    /**
     * @param $id
     * @return EntityNotFoundResource|ShowListResource
     */
    public function show($id)
    {
        $model = Lists::where('id', $id)->orWhere('external_id', $id)->with('product', 'discount_card', 'user')->first();

        if ($model) {
            /*$model = Product::whereHas('lists', function ($query) use ($id) {
                $query->where('external_id', $id)
                    ->orWhere('id', $id);
//                ->where('user_id', Auth::id());
//                ->orWhere('list_id')
            })
                ->with('lists', 'product_group')
                ->orderBy('product_group_id', 'ASC')
                ->orderby('created_at', 'DESC')
                ->get();*/

//            return ProductResource::collection($model);
            return new ShowListResource($model);
        } else {
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @param ListsStoreRequest $request
     * @return JsonResponse|ListsResource
     */
    public function store(ListsStoreRequest $request)
    {
        $model = Lists::create([
            'title' => $request->input('title'),
            'external_id' => $request->input('external_id'),
            'user_id' => Auth::id(),
            'slug' => Str::random(15)
        ]);

        return (new ListsResource($model))->response()->setStatusCode(201);
    }

    /**
     * @param ListsUpdateRequest $request
     * @param $id
     * @return EntityNotFoundResource|EntityUpdateSuccessfulResource
     */
    public function update(ListsUpdateRequest $request, $id)
    {
        $model = Lists::where(function ($query) use ($id) {
            $query->where('id', $id)
                ->orWhere('external_id', $id);
        })->where('user_id', Auth::id())->first();

        if ($model) {
            $model->update(
                $request->only(['title'])
            );

            return new EntityUpdateSuccessfulResource(null);
        } else {
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @param $id
     * @return EntityNotFoundResource|EntityDestroySuccessfulResource
     */
    public function destroy($id)
    {
        $model = Lists::where(function ($query) use ($id) {
            $query->where('id', $id)
                ->orWhere('external_id', $id);
        })->where('user_id', Auth::id())
            ->first();

        if ($model) {
            $model->delete();

            return new EntityDestroySuccessfulResource(null);
        } else {
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @param ListDiscountCardRequest $request
     * @return EntityNotFoundResource|ListDiscountCardErrorResource|SuccessAddRemResource
     */
    public function addDiscountCard(ListDiscountCardRequest $request)
    {
        $param = $request->only('list_id', 'discount_card_id');

        $list = Lists::where('user_id', Auth::id())->where('external_id', $param['list_id'])->first();

        $discount_card = DiscountCard::where('user_id', Auth::id())->where('id', $param['discount_card_id'])->exists();

        if ($list && $discount_card) {
            $is_create = ListM2MDiscountCard::firstOrNew([
                'discount_card_id' => $param['discount_card_id'],
                'list_id' => $list->id
            ]);
            if (isset($is_create->id)) {
                return new ListDiscountCardErrorResource(null);
            } else {
                $is_create->save();

                return new SuccessAddRemResource(null);
            }
        } else {
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @param ListDiscountCardRequest $request
     * @return EntityNotFoundResource|ListDiscountCardErrorResource|SuccessAddRemResource
     */
    public function delDiscountCard(ListDiscountCardRequest $request)
    {
        $param = $request->only('list_id', 'discount_card_id');

        $list = Lists::where('user_id', Auth::id())->where('external_id', $param['list_id'])->first();

        $discount_card = DiscountCard::where('user_id', Auth::id())->where('id', $param['discount_card_id'])->exists();

        if ($list && $discount_card) {
            $is_delete = ListM2MDiscountCard::where('discount_card_id', $param['discount_card_id'])->where('list_id', $list->id)->delete();
            if ($is_delete) {
                return new SuccessAddRemResource(null);
            } else {
                return new ListDiscountCardErrorResource(null);
            }
        } else {
            return new EntityNotFoundResource(null);
        }
    }


    public function edit($id)
    {
        //
    }

    public function create()
    {
        //
    }


}
