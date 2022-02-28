<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ErrorSQLException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    private $e;
    public function report()
    {
        //
    }

    public function __construct($e = null)
    {
        $this->e = $e;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(['message' => "SQL Error: " . @$this->e->getMessage()], 404);
    }
}
