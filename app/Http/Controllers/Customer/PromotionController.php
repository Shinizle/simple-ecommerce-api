<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\GetAllEventsRequest;
use App\Http\Requests\Customer\GetAllProductEventsRequest;
use App\Http\Requests\Customer\GetDetailEventRequest;
use App\Http\Requests\Customer\GetDetailProductEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventResourceCollection;
use App\Http\Resources\ProductEventResource;
use App\Http\Resources\ProductEventResourceCollection;
use App\Models\Event;
use App\Models\ProductEvent;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function getAllEvents(GetAllEventsRequest $request)
    {
        $data = Event::paginate();

        return new EventResourceCollection($data);
    }

    public function getDetailEvent(GetDetailEventRequest $request)
    {
        $data = Event::find($request->id);

        return new EventResource($data);
    }

    public function getAllProductEvents(GetAllProductEventsRequest $request)
    {
        $data = ProductEvent::whereEventId($request->event_id)->paginate();

        return new ProductEventResourceCollection($data);
    }

    public function getDetailProductEvent(GetDetailProductEventRequest $request)
    {
        $data = ProductEvent::find($request->id);

        return new ProductEventResource($data);
    }
}
