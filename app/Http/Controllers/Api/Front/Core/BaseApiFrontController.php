<?php

namespace App\Http\Controllers\Api\Front\Core;

use App\Constants\AuthConst;
use App\Http\Controllers\Core\BaseController;
use App\Http\Responses\Traits\ApiResult;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseApiFrontController
 *
 * @package App\Http\Controllers\Api\Front\Core
 */
abstract class BaseApiFrontController extends BaseController
{
    use ApiResult;

    /**
     * BaseApiFrontController Constructor
     */
    public function __construct()
    {
        parent::__construct();

        Auth::setDefaultDriver(AuthConst::GUARD_API_FRONT);        
    }
}
