<?php

namespace App\Exceptions;

use Exception;

class InvalidEventQuantityRequestException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(['message' => "Invalid product_event_qty request, the qty must be equal to or higher than 10% of the current product qty."], 404);
    }
}
