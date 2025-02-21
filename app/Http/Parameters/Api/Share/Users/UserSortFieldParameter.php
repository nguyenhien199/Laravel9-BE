<?php

namespace App\Http\Parameters\Api\Share\Users;

use OpenApi\Annotations as OA;

/**
 * Parameter: The Sort field (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.SortField.InQuery.Required",
 *      ref="#/components/parameters/Parameters.Api.Core.Sorts.SortField.InQuery.Required",
 *      name="sort",
 *      description="Sort field in list [`id`, `email`, `firstname`]. <br/>Note: uppercase and lowercase allowed",
 * )
 * --------------------------------------------------
 * Parameter: The Sort field (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.SortField.InQuery",
 *      ref="#/components/parameters/Parameters.Api.Core.Sorts.SortField.InQuery",
 *      name="sort",
 *      description="Sort field in list [`id`, `email`, `firstname`]. <br/>If not, default is `id`. <br/>Note: uppercase and lowercase allowed",
 * )
 */
final class UserSortFieldParameter { }
