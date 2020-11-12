<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductDestroyRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\API\Errors\EntityNotFoundResource;
use App\Http\Resources\API\ProductResource;
use App\Http\Resources\API\System\EntityDestroySuccessfulResource;
use App\Http\Resources\API\System\EntityUpdateSuccessfulResource;
use App\Models\Public1\Lists;
use App\Models\Public1\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * @param ProductStoreRequest $request
     * @return EntityNotFoundResource|JsonResponse|object
     */
    public function store(ProductStoreRequest $request)
    {
        $list_id = $request->input('list_id');
        $list = Lists::where('id', $list_id)->orWhere('external_id', $list_id)->first();

        if ($list) {
            $model = Product::create([
                'external_id' => $request->input('external_id'),
                'title' => $request->input('title'),
                'list_id' => $list->id,
                'user_id' => Auth::id(),
                'product_group_id' => $request->input('product_group_id'),
                'unit' => $request->input('unit')
            ]);

            /*$list->product()->attach([
                $model->id
            ]);*/

            return (new ProductResource($model))->response()->setStatusCode(201);
        } else {
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @param ProductUpdateRequest $request
     * @param $id
     * @return EntityNotFoundResource|EntityUpdateSuccessfulResource
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $model = Product::where('id', $id)->orWhere('external_id', $id)->first();

        if ($model) {
            $model->update(
                $request->only(['title', 'unit', 'marked'])
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
        $model = Product::where('id', $id)->orWhere('external_id', $id)->first();

        if ($model) {
            $model->delete();

            return new EntityDestroySuccessfulResource(null);
        } else {
            return new EntityNotFoundResource(null);
        }
    }


    /**
     * @param ProductDestroyRequest $request
     * @return EntityNotFoundResource|EntityDestroySuccessfulResource
     */
    public function destroyMany(ProductDestroyRequest $request)
    {
        $product_external_id = array_column($request->all(), 'external_id');

        Product::whereIn('external_id', $product_external_id)->delete();

//        if ($model) {
        return new EntityDestroySuccessfulResource(null);
//        } else {
//            return new EntityNotFoundResource(null);
//        }

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
