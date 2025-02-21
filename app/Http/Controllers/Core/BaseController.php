<?php

namespace App\Http\Controllers\Core;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

/**
 * Class BaseController
 *
 * @package App\Http\Controllers\Core
 */
abstract class BaseController extends IlluminateController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * BaseController Constructor
     */
    public function __construct()
    {
        //
    }
}
