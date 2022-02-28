<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddNewEventRequest;
use App\Http\Requests\Admin\DeleteEventRequest;
use App\Http\Requests\Admin\EditEventRequest;
use App\Http\Requests\Admin\GetEventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventResourceCollection;
use App\Models\Event;
use Illuminate\Http\Request;

/*
* CRUD Controller for Event APIs
*/

class EventController extends Controller
{
    public function getAllEvents()
    {
        $data = Event::paginate();

        return new EventResourceCollection($data);
    }

    public function getEvent(GetEventRequest $request)
    {
        $data = Event::find($request->id);

        return new EventResource($data);
    }

    public function addNewEvent(AddNewEventRequest $request)
    {
        $data = new Event();
        $data->fill($request->all());
        $data->save();

        return new EventResource($data);
    }

    public function editEvent(EditEventRequest $request)
    {
        $data = Event::find($request->id);
        $data->fill($request->all());
        $data->save();

        return new EventResource($data);
    }

    public function deleteEvent(DeleteEventRequest $request)
    {
        /*
         * Check event is in periode, if event is held now it's can't be deleted.
         */

        $event = Event::find($request->id);
        if ($event->isInPeriode()) {
            return response()->json(['message' => 'Failed to delete, event is in periode.'], self::ERROR_STATUS);
        } else {
            $event->delete();

            return response()->json(['message' => 'Event deleted succesfully.'], self::SUCCESS_STATUS);
        }
    }
}
