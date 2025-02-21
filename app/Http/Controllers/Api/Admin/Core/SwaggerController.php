<?php

namespace App\Http\Controllers\Api\Admin\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Admin-CMS API Documentation",
 *     version="1.0.0",
 * )
 * @OA\Server(url=L5_SWAGGER_CONST_HOST, description="This Server")
 * @OA\Tag(name="Home", description="Home/Demo API Endpoints")
 * @OA\Tag(name="Auth", description="Authentication API Endpoints")
 * @OA\Tag(name="Profiles", description="User profile API Endpoints")
 * @OA\Tag(name="Users", description="User management API Endpoints")
 */
final class SwaggerController
{
    /**
     * Swagger Admin-CMS Global comments
     * We need to provide the information about the whole project,
     * and for that, we create a separate file
     * – an empty Controller which would not even be used anywhere
     * – app/Http/Controllers/Api/Admin/Core/SwaggerController.php
     */
}
