<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Core\BaseApiFormRequest;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

/**
 * Class HomeApiAdminController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class HomeApiAdminController extends Core\BaseApiAdminController
{
    /**
     * HomeApiAdminController Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Hello-World Admin Api.
     * @OA\Get(
     *      tags={"Home"},
     *      path="/api/admin/",
     *      operationId="admin-helloworld",
     *      summary="Helloworld",
     *      description="Admin-CMS Helloworld Api",
     *      security={{}},
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Core.Ok"),
     *      @OA\Response(response=400,ref="#/components/responses/Responses.Api.Core.BadRequest"),
     *      @OA\Response(response=401,ref="#/components/responses/Responses.Api.Core.Unauthorized"),
     *      @OA\Response(response=403,ref="#/components/responses/Responses.Api.Core.Forbidden"),
     *      @OA\Response(response=404,ref="#/components/responses/Responses.Api.Core.NotFound"),
     *      @OA\Response(response=405,ref="#/components/responses/Responses.Api.Core.MethodNotAllowed"),
     *      @OA\Response(response=422,ref="#/components/responses/Responses.Api.Core.UnprocessableEntity"),
     *      @OA\Response(response=500,ref="#/components/responses/Responses.Api.Core.Error"),
     * )
     *
     * @param BaseApiFormRequest $request
     * @return JsonResponse
     */
    public function index(BaseApiFormRequest $request): JsonResponse
    {
        return $this->okApiResult(__('Hello, World!'));
    }
}
