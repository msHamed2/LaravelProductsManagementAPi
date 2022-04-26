<?php

namespace App\Http\Controllers;

use App\Enums\FilesPaths;
use App\Models\products;
use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:sanctum')->except(['index','show']);
        $this->middleware('can:canUpdate')->only('update');
        $this->middleware('can:canDelete')->only('destroy');
        $this->middleware('can:canStore')->only('store');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProductsRequest $request)
    {
        $data = $request->validated();
        $data = Products::query()->applyAllFilters($data);
        return $this->getJsonResponse('success', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ProductsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductsRequest $request)
    {
        $data = $request->validated();
        $createdData = null;
        try {
            DB::beginTransaction();

            $data['image'] = FileController::store($data['image'], FilesPaths::Attachments->value);


            $createdData = Products::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->getJsonResponse('Error', $exception->getMessage(), false, 400);
        }
        return $this->getJsonResponse('success', $createdData);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\products $products
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        $data['where_id'] = $id;
        $products = Products::query()->where('id', $id)->firstOrFail();
        return $this->getJsonResponse('success', $products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\products $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ProductsRequest $request
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductsRequest $request,  $id)
    {
        $newData = $request->validated();
        $products=Products::query()->where('id',$id)->firstOrFail();

        $imageSaved = false;
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                if (Storage::exists(FilesPaths::Attachments->value . $products['image'])) {
                    Storage::delete(FilesPaths::Attachments->value . $products['image']);
                }
                $newData['image'] = FileController::store($request->image, FilesPaths::Attachments->value);
                $imageSaved = true;
            }
            $products->update($newData);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($imageSaved) {
                Storage::delete(FilesPaths::Attachments->value . $newData['image']);

            }
            return $this->getJsonResponse('error', $exception->getMessage(), false, 400);
        }
        return $this->getJsonResponse('success',$products, true, 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\products $products
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(products $products)
    {
        Products::destroy($products);
        return $this->getJsonResponse('success', []);
    }
}
