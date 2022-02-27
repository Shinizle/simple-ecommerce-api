<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const SUCCESS_STATUS = 200;
    const ERROR_STATUS = 401;
    const ERROR_VALIDATION = 400;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
