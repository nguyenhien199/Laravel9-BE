<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Core\BaseWebFormRequest;
use Illuminate\Http\Response;

/**
 * Class HomeAdminController
 *
 * @package App\Http\Controllers\Admin
 */
class HomeAdminController extends Core\BaseAdminController
{
    /**
     * HomeAdminController Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Admin-CMS Index view page.
     *
     * @param BaseWebFormRequest $request
     * @return Response
     */
    public function index(BaseWebFormRequest $request): Response
    {
        return $this->viewResult('admin.home.index');
    }

    /**
     * Admin-CMS Dashboard view page.
     *
     * @param BaseWebFormRequest $request
     * @return Response
     */
    public function dashboard(BaseWebFormRequest $request): Response
    {
        return $this->viewResult('admin.home.dashboard');
    }

    /**
     * Admin-CMS OPCache Dashboard view page.
     *
     * @param BaseWebFormRequest $request
     * @return Response
     */
    public function opcache(BaseWebFormRequest $request): Response
    {
        return $this->viewResult('admin.home.opcache');
    }

}
