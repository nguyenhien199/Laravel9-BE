<?php

namespace App\Http\Controllers\Front\Core;

use App\Constants\AuthConst;
use App\Http\Controllers\Core\BaseController;
use App\Http\Responses\Traits\WebResult;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseFrontController
 *
 * @package App\Http\Controllers\Front\Core
 */
abstract class BaseFrontController extends BaseController
{
    use WebResult;

    /**
     * BaseFrontController Constructor
     */
    public function __construct()
    {
        parent::__construct();

        Auth::setDefaultDriver(AuthConst::GUARD_FRONT);        
    }
}
