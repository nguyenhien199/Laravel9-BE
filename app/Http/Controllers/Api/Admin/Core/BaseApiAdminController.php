<?php

namespace App\Http\Controllers\Api\Admin\Core;

use App\Constants\AuthConst;
use App\Http\Controllers\Core\BaseController;
use App\Http\Responses\Traits\ApiResult;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseApiAdminController
 *
 * @package App\Http\Controllers\Api\Admin\Core
 */
abstract class BaseApiAdminController extends BaseController
{
    use ApiResult;

    /**
     * BaseApiAdminController Constructor
     */
    public function __construct()
    {
        parent::__construct();

        Auth::setDefaultDriver(AuthConst::GUARD_API_ADMIN);        
    }
}
