<?php

namespace App\Http\Controllers\Api\Front\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Front-App API Documentation",
 *     version="1.0.0",
 * )
 * @OA\Server(url=L5_SWAGGER_CONST_HOST, description="This Server")
 * @OA\Tag(name="Home", description="Home/Demo API Endpoints")
 * @OA\Tag(name="Auth", description="Authentication API Endpoints")
 * @OA\Tag(name="Profiles", description="User profile API Endpoints")
 */
final class SwaggerController
{
    /**
     * Swagger Front-App Global comments
     * We need to provide the information about the whole project,
     * and for that, we create a separate file
     * – an empty Controller which would not even be used anywhere
     * – app/Http/Controllers/Api/Front/Core/SwaggerController.php
     */
}
