<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Core\BaseWebFormRequest;
use Illuminate\Http\Response;

/**
 * Class HomeFrontController
 *
 * @package App\Http\Controllers\Front
 */
class HomeFrontController extends Core\BaseFrontController
{
    /**
     * HomeFrontController Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Front Index view page.
     *
     * @param BaseWebFormRequest $request
     * @return Response
     */
    public function index(BaseWebFormRequest $request): Response
    {
        return $this->viewResult('front.home.index');
    }
}
