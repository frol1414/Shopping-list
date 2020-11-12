<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCardStoreRequest;
use App\Http\Resources\API\DiscountCardBrandResource;
use App\Http\Resources\API\DiscountCardResource;
use App\Http\Resources\API\Errors\EntityNotFoundResource;
use App\Http\Resources\API\System\EntityDestroySuccessfulResource;
use App\Models\Public1\DiscountCard;
use App\Models\Ref\DiscountCardBrand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class DiscountCardController extends Controller
{
    public function index()
    {
        $model = DiscountCard::where('user_id', Auth::id())->with('ref_brand')->get();

        return DiscountCardResource::collection($model);
    }

    /**
     * @param DiscountCardStoreRequest $request
     * @return JsonResponse|object
     */
    public function store(DiscountCardStoreRequest $request)
    {
        $model = DiscountCard::create([
            'title' => $request->input('title'),
            'barcode' => $request->input('barcode'),
            'user_id' => Auth::id(),
            'color' => $request->input('color'),
            'ref_brand_id' => $request->input('brand_id')
        ]);

        $model->load('ref_brand');

        return (new DiscountCardResource($model))->response()->setStatusCode(201);
    }

    public function update(Request $request, $id)
    {

    }

    /**
     * @param $id
     * @return EntityNotFoundResource|EntityDestroySuccessfulResource
     */
    public function destroy($id)
    {
        $model = DiscountCard::where('id', $id)->where('user_id', Auth::id())->first();

        if ($model) {
            $model->delete();

            return new EntityDestroySuccessfulResource(null);
        } else {
            return new EntityNotFoundResource(null);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getDiscountCardBrands()
    {
        $model = DiscountCardBrand::all();

        return DiscountCardBrandResource::collection($model);
    }


    public function show($id)
    {
        //
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
