<?php

namespace App\Http\Controllers\Admin\Core;

use App\Constants\AuthConst;
use App\Http\Controllers\Core\BaseController;
use App\Http\Responses\Traits\WebResult;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseAdminController
 *
 * @package App\Http\Controllers\Admin\Core
 */
abstract class BaseAdminController extends BaseController
{
    use WebResult;

    /**
     * BaseAdminController Constructor
     */
    public function __construct()
    {
        parent::__construct();

        Auth::setDefaultDriver(AuthConst::GUARD_ADMIN);        
    }
}
