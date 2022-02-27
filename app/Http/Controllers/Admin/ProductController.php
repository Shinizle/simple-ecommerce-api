<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddNewProductRequest;
use App\Http\Requests\Admin\DeleteProductRequest;
use App\Http\Requests\Admin\EditProductRequest;
use App\Http\Requests\Admin\GetProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

/*
 * CRUD Controller for Product APIs
 */

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $data = Product::paginate();

        return new ProductResourceCollection($data);
    }

    public function getProduct(GetProductRequest $request)
    {
        $data = Product::find($request->id);

        return new ProductResource($data);
    }

    public function addNewProduct(AddNewProductRequest $request)
    {
        $data = new Product();
        $data->fill($request->all());
        $data->save();

        return new ProductResource($data);
    }

    public function editProduct(EditProductRequest $request)
    {
        $data = Product::find($request->id);
        $data->fill($request->all());
        $data->save();

        return new ProductResource($data);
    }

    public function deleteProduct(DeleteProductRequest $request)
    {
        Product::find($request->id)->delete();

        return response()->json(['message' => 'Product deleted succesfully.'], self::SUCCESS_STATUS);
    }
}
