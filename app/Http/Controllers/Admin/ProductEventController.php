<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\DuplicateEntryException;
use App\Exceptions\InvalidEventQuantityRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddProductEventRequest;
use App\Http\Requests\Admin\DeleteProductEventRequest;
use App\Http\Requests\Admin\GetAllProductEventRequest;
use App\Http\Requests\Admin\GetProductEventRequest;
use App\Http\Requests\Admin\EditProductEventRequest;
use App\Http\Resources\ProductEventResource;
use App\Http\Resources\ProductEventResourceCollection;
use App\Models\Product;
use App\Models\ProductEvent;
use Illuminate\Http\Request;

class ProductEventController extends Controller
{
    public function getAllProducts(GetAllProductEventRequest $request)
    {
        $data = ProductEvent::whereEventId($request->event_id)->paginate();

        return new ProductEventResourceCollection($data);
    }

    public function getProduct(GetProductEventRequest $request)
    {
        $data = ProductEvent::find($request->id);

        return new ProductEventResource($data);
    }

    public function addNewProduct(AddProductEventRequest $request)
    {

        /*
         * - The product_event_qty request must be equal to or higher than 10% of the current product qty.
         * - It's to prevent negative inventory quantity.
         * - Also to make administator re-confirm availability stocks with suppliers or warehouse admin before submiting to product_event_qty.
         */

        $product = Product::find($request->product_id);
        if ($product->isValidEventStock($request)) {
            if (!$this->isDuplicateEntry($request)) {
                $data = new ProductEvent();
                $data->fill($request->all());
                $data->save();

                return new ProductEventResource($data);
            } else {
                throw new DuplicateEntryException();
            }
        } else {
            throw new InvalidEventQuantityRequestException();
        }
    }

    public function editProduct(EditProductEventRequest $request)
    {

        /*
         * - The product_event_qty request must be equal to or higher than 10% of the current product qty.
         * - It's to prevent negative inventory quantity.
         * - Also to make administator re-confirm availability stocks with suppliers or warehouse admin before submiting to product_event_qty.
         */

        $data = ProductEvent::find($request->id);
        $product = Product::find($data->product_id);
        if ($product->isValidEventStock($request)) {
            $data->update(['product_event_qty' => $request->product_event_qty, 'event_price' => $request->event_price]);
            $data->save();

            return new ProductEventResource($data);
        } else {
            throw new InvalidEventQuantityRequestException();
        }
    }

    public function deleteProduct(DeleteProductEventRequest $request)
    {
        ProductEvent::find($request->id)->delete();

        return response()->json(['message' => 'Product Event deleted succesfully.'], self::SUCCESS_STATUS);
    }

    private function isDuplicateEntry($data)
    {
        /*
         * Prevent duplicate data by checking is it exists
         */

        $isExists = ProductEvent::whereEventId($data->event_id)->whereProductId($data->product_id)->exists();
        if ($isExists) {
            return true;
        }

        return false;
    }
}
