<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constants\RepositoryConst;
use App\Constants\ResponseConst;
use App\Enums\StatusFlag;
use App\Events\Users\UserCreatedEvent;
use App\Events\Users\UserDeletedEvent;
use App\Events\Users\UserPasswordChangedEvent;
use App\Events\Users\UserStatusChangedEvent;
use App\Events\Users\UserUpdatedEvent;
use App\Events\Users\UserVerifiedByEmailEvent;
use App\Http\Requests\Api\Admin\Users\UserCreateApiAdminRequest;
use App\Http\Requests\Api\Admin\Users\UserPaginateApiAdminRequest;
use App\Http\Requests\Api\Admin\Users\UserPasswordChangeApiAdminRequest;
use App\Http\Requests\Api\Admin\Users\UserUpdateApiAdminRequest;
use App\Http\Requests\Core\BaseApiFormRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

use OpenApi\Annotations as OA;

/**
 * Class UserApiAdminController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class UserApiAdminController extends Core\BaseApiAdminController
{
    use Traits\UserHttpApiAdminTrait;

    /**
     * @var UserService <p>UserService instance.</p>
     */
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * ==================== USER MANAGEMENT API ====================
     */

    /**
     * Get pagination of User list.
     * @OA\Get(
     *      tags={"Users"},
     *      path="/api/admin/user",
     *      operationId="admin-user-paginate",
     *      summary="User pagination",
     *      description="Get pagination of User list",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InQuery"),
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Email.InQuery"),
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Gender.InQuery"),
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Status.InQuery"),
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Core.Paginate.Page.InQuery"),
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Core.Paginate.PerPage.InQuery"),
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.SortField.InQuery"),
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Core.Sorts.SortType.InQuery"),
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Admin.Users.PaginateOk"),
     *      @OA\Response(response=400,ref="#/components/responses/Responses.Api.Core.BadRequest"),
     *      @OA\Response(response=401,ref="#/components/responses/Responses.Api.Core.Unauthorized"),
     *      @OA\Response(response=403,ref="#/components/responses/Responses.Api.Core.Forbidden"),
     *      @OA\Response(response=404,ref="#/components/responses/Responses.Api.Core.NotFound"),
     *      @OA\Response(response=405,ref="#/components/responses/Responses.Api.Core.MethodNotAllowed"),
     *      @OA\Response(response=422,ref="#/components/responses/Responses.Api.Core.UnprocessableEntity"),
     *      @OA\Response(response=500,ref="#/components/responses/Responses.Api.Core.Error"),
     * )
     *
     * @param UserPaginateApiAdminRequest $request
     * @return JsonResponse
     */
    public function paginate(UserPaginateApiAdminRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $params = (array)$request->validated();
            $users = $this->userService->getPagination($params);
            return $this->okApiResult(UserResource::collection($users)->transform());
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Create new User.
     * @OA\Post(
     *      tags={"Users"},
     *      path="/api/admin/user",
     *      operationId="admin-user-create",
     *      summary="Create new User",
     *      description="Create new User",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Admin.Users.Create"),
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/Requests.Api.Admin.Users.Create"),
     *          ),
     *      ),
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Admin.Users.CreateOk"),
     *      @OA\Response(response=400,ref="#/components/responses/Responses.Api.Core.BadRequest"),
     *      @OA\Response(response=401,ref="#/components/responses/Responses.Api.Core.Unauthorized"),
     *      @OA\Response(response=403,ref="#/components/responses/Responses.Api.Core.Forbidden"),
     *      @OA\Response(response=404,ref="#/components/responses/Responses.Api.Core.NotFound"),
     *      @OA\Response(response=405,ref="#/components/responses/Responses.Api.Core.MethodNotAllowed"),
     *      @OA\Response(response=422,ref="#/components/responses/Responses.Api.Core.UnprocessableEntity"),
     *      @OA\Response(response=500,ref="#/components/responses/Responses.Api.Core.Error"),
     * )
     *
     * @param UserCreateApiAdminRequest $request
     * @return JsonResponse
     */
    public function create(UserCreateApiAdminRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $params = (array)$request->validated();

            $usernameCheck = $this->userService->getByUsername($params['username'], RepositoryConst::COLUMNS_DEFAULT, [], null);
            if ($usernameCheck) {
                $message = __('messages.auth.error.username_exist', ['attribute' => $params['username']]);
                return $this->unprocessableEntityApiResult(ResponseConst::CODE_DATA_EXIST, $message, null, ['username' => $message]);
            }
            $emailCheck = $this->userService->getByEmail($params['email'], RepositoryConst::COLUMNS_DEFAULT, [], null);
            if ($emailCheck) {
                $message = __('messages.auth.error.email_exist', ['attribute' => $params['email']]);
                return $this->unprocessableEntityApiResult(ResponseConst::CODE_DATA_EXIST, $message, null, ['email' => $message]);
            }
            $phoneCheck = $this->userService->getByPhone($params['phone'], RepositoryConst::COLUMNS_DEFAULT, [], null);
            if ($phoneCheck) {
                $message = __('messages.auth.error.phone_exist', ['attribute' => $params['phone']]);
                return $this->unprocessableEntityApiResult(ResponseConst::CODE_DATA_EXIST, $message, null, ['phone' => $message]);
            }

            $user = $this->userService->handleCreateNew($params);

            // Events
            event(new UserCreatedEvent($user));

            return $this->okApiResult(UserResource::fromModel($user)->transform());
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Get User information.
     * @OA\Get(
     *      tags={"Users"},
     *      path="/api/admin/user/{userId}",
     *      operationId="admin-user-read",
     *      summary="Get User info",
     *      description="Get User information",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Admin.Users.ReadOk"),
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
    public function read(BaseApiFormRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            return $this->okApiResult(UserResource::fromModel($user)->transform());
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Update user information.
     * @OA\Put(
     *      tags={"Users"},
     *      path="/api/admin/user/{userId}",
     *      operationId="admin-user-update",
     *      summary="Update user info",
     *      description="Update user information",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Admin.Users.Update"),
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
     * @param UserUpdateApiAdminRequest $request
     * @return JsonResponse
     */
    public function update(UserUpdateApiAdminRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            // Check User and Logged are one.
            if ($logged->id == $user->id) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.user.error.edit_himself'));
            }

            $userOld = clone $user;
            $params = (array)$request->validated();
            $update = $this->userService->handleUpdate($user, $params);
            if (!$update) {
                return $this->errorApiResult(new \Exception(__('messages.action.error.update')));
            }
            $user->refresh();

            // Events
            event(new UserUpdatedEvent($user));
            if ($userOld->status != $user->status) {
                event(new UserStatusChangedEvent($user, $userOld->status, $user->status));
            }

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Delete User.
     * @OA\Delete(
     *      tags={"Users"},
     *      path="/api/admin/user/{userId}",
     *      operationId="admin-user-delete",
     *      summary="Delete User",
     *      description="Delete User",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
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
    public function delete(BaseApiFormRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            // Check User and Logged are one.
            if ($logged->id == $user->id) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.user.error.delete_himself'));
            }

            if ($user->isDeleted()) {
                return $this->okApiResult();
            }

            $delete = $this->userService->deleteByObj($user);
            if (!$delete) {
                return $this->errorApiResult(new \Exception(__('messages.action.error.delete')));
            }

            // Events
            event(new UserDeletedEvent($user));

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Verify User account.
     * (Verify for Email)
     * @OA\Post(
     *      tags={"Users"},
     *      path="/api/admin/user/verify/{userId}",
     *      operationId="admin-user-verify",
     *      summary="Verify User account",
     *      description="Verify User account",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
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
    public function verify(BaseApiFormRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            // Check User and Logged are one.
            if ($logged->id == $user->id) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.user.error.edit_himself'));
            }

            if ($user->isEmailVerified()) {
                return $this->okApiResult();
            }

            $update = $this->userService->handleUpdate($user, ['email_verified_at' => carbon()->format(DATE_TIME_FORMAT)]);
            if (!$update) {
                return $this->errorApiResult(new \Exception(__('messages.user.error.verify')));
            }

            // Events
            event(new UserVerifiedByEmailEvent($user));

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * ==================== USER STATUS API ====================
     */

    /**
     * Quick lock User.
     * @OA\Post(
     *      tags={"Users"},
     *      path="/api/admin/user/lock/{userId}",
     *      operationId="admin-user-lock",
     *      summary="Quick lock User",
     *      description="Quick lock User",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
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
    public function lock(BaseApiFormRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            // Check User and Logged are one.
            if ($logged->id == $user->id) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.user.error.edit_status_himself'));
            }

            if (!$user->isActive()) {
                return $this->okApiResult();
            }

            $oldUser = clone $user;
            $change = $this->userService->handleUpdate($user, ['status' => StatusFlag::INACTIVE]);
            if (!$change) {
                return $this->errorApiResult(new \Exception(__('messages.user.error.quick_lock')));
            }
            $user->refresh();

            // Events
            event(new UserStatusChangedEvent($user, $oldUser->status, $user->status));

            return $this->okApiResult();
        }
        catch (\Exception $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Quick unlock User.
     * @OA\Post(
     *      tags={"Users"},
     *      path="/api/admin/user/unlock/{userId}",
     *      operationId="admin-user-unlock",
     *      summary="Quick unlock User",
     *      description="Quick unlock User",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
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
    public function unlock(BaseApiFormRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            // Check User and Logged are one.
            if ($logged->id == $user->id) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.user.error.edit_status_himself'));
            }

            if ($user->isActive()) {
                return $this->okApiResult();
            }

            $oldUser = clone $user;
            $change = $this->userService->handleUpdate($user, ['status' => StatusFlag::ACTIVE]);
            if (!$change) {
                return $this->errorApiResult(new \Exception(__('messages.user.error.quick_unlock')));
            }
            $user->refresh();

            // Events
            event(new UserStatusChangedEvent($user, $oldUser->status, $user->status));

            return $this->okApiResult();
        }
        catch (\Exception $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * ==================== USER PASSWORD API ====================
     */

    /**
     * Change User's password.
     * @OA\Post(
     *      tags={"Users"},
     *      path="/api/admin/user/password/{userId}",
     *      operationId="admin-user-change-password",
     *      summary="Change User's password",
     *      description="Change User's password",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/Parameters.Api.Share.Users.Id.InPath.Required"),
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Admin.Users.PasswordChange"),
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/Requests.Api.Admin.Users.PasswordChange"),
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
     * @param UserPasswordChangeApiAdminRequest $request
     * @return JsonResponse
     */
    public function changePassword(UserPasswordChangeApiAdminRequest $request): JsonResponse
    {
        try {
            /** @var User $logged */
            $logged = $request->user();

            $checkInvalid = $this->checkUserInvalid($logged);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Check Logged is not admin.
            if (!$logged->isAdmin()) {
                return $this->forbiddenApiResult(ResponseConst::CODE_FORBIDDEN, __('messages.error.forbidden'));
            }

            $userId = $request->route('userId');
            $user = $this->userService->getById($userId);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.error.data_not_found'));
            }

            // Check Logged by my_password.
            $adminPassword = $request->validated('my_password');
            if (!$this->userService->itsPassword($logged, $adminPassword)) {
                return $this->unprocessableEntityApiResult(
                    ResponseConst::CODE_FAILED_VALIDATION,
                    __('validation.custom.password.incorrect'),
                    null,
                    ['my_password' => __('validation.custom.password.incorrect')]
                );
            }

            $newUserPassword = $request->validated('password');
            $update = $this->userService->handleUpdate($user, ['password' => $newUserPassword]);
            if (!$update) {
                return $this->errorApiResult(new \Exception(__('messages.action.error.update')));
            }

            // Events
            event(new UserPasswordChangedEvent($user));

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

}