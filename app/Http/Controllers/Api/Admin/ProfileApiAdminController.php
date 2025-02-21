<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constants\ResponseConst;
use App\Events\Users\UserPasswordChangedEvent;
use App\Events\Users\UserUpdatedEvent;
use App\Http\Requests\Api\Admin\Users\Profiles\Password\UserProfilePasswordUpdateApiAdminRequest;
use App\Http\Requests\Api\Admin\Users\Profiles\UserProfileUpdateApiAdminRequest;
use App\Http\Requests\Core\BaseApiFormRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

use OpenApi\Annotations as OA;

/**
 * Class ProfileApiAdminController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class ProfileApiAdminController extends Core\BaseApiAdminController
{
    use Traits\UserHttpApiAdminTrait;

    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    /**
     * Get the User's profile information.
     * @OA\Get(
     *      tags={"Profiles"},
     *      path="/api/admin/profile",
     *      operationId="admin-profile-info",
     *      summary="Profile info",
     *      description="Get the User's profile information",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Admin.Users.Profiles.InfoOk"),
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
    public function info(BaseApiFormRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            return $this->okApiResult(UserResource::fromModel($logged)->transform());
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Update the User's profile information.
     * @OA\Post(
     *      tags={"Profiles"},
     *      path="/api/admin/profile",
     *      operationId="admin-profile-update",
     *      summary="Profile update",
     *      description="Update the User's profile information",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Admin.Users.Profiles.Update"),
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/Requests.Api.Admin.Users.Profiles.Update"),
     *          ),
     *      ),
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
     * @param UserProfileUpdateApiAdminRequest $request
     * @return JsonResponse
     */
    public function update(UserProfileUpdateApiAdminRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            $params = $request->validated();
            $update = $this->userService->handleUpdate($logged, $params);
            if (!$update) {
                return $this->errorApiResult(new \Exception(__('messages.action.error.update')));
            }

            // Events
            event(new UserUpdatedEvent($logged));

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Update the User's password.
     * @OA\Post(
     *      tags={"Profiles"},
     *      path="/api/admin/profile/password",
     *      operationId="admin-profile-password-update",
     *      summary="Profile update password",
     *      description="Update the User's password",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Admin.Users.Profiles.Password.Update"),
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/Requests.Api.Admin.Users.Profiles.Password.Update"),
     *          ),
     *      ),
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
     * @param UserProfilePasswordUpdateApiAdminRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UserProfilePasswordUpdateApiAdminRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Current password.
            $currentPassword = $request->validated('current_password');
            if (!$this->userService->itsPassword($logged, $currentPassword)) {
                return $this->unprocessableEntityApiResult(
                    ResponseConst::CODE_FAILED_VALIDATION,
                    __('validation.custom.password.incorrect'),
                    null,
                    ['current_password' => __('validation.custom.password.incorrect')]
                );
            }

            // Check New password.
            $newPassword = $request->validated('password');
            if ($this->userService->checkPasswordSameAsOld($logged, $newPassword)) {
                return $this->unprocessableEntityApiResult(
                    ResponseConst::CODE_FAILED_VALIDATION,
                    __('validation.custom.password.same_as_current'),
                    null,
                    ['password' => __('validation.custom.password.same_as_current')]
                );
            }

            // Update new password.
            $update = $this->userService->handleUpdate($logged, ['password' => $newPassword]);
            if ($update === false) {
                return $this->errorApiResult(new \Exception(__('messages.action.error.update')));
            }

            // Events
            event(new UserPasswordChangedEvent($logged));

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }
}
