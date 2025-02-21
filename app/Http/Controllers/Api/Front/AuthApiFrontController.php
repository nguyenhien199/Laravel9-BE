<?php

namespace App\Http\Controllers\Api\Front;

use App\Constants\AuthConst;
use App\Constants\RepositoryConst;
use App\Constants\ResponseConst;
use App\Events\Users\UserLoggedInEvent;
use App\Events\Users\UserLoggedOutEvent;
use App\Events\Users\UserRegisteredEvent;
use App\Events\Users\UserTokenRefreshedEvent;
use App\Exceptions\GeneralException;
use App\Http\Requests\Api\Front\Auth\LoginApiFrontRequest;
use App\Http\Requests\Api\Front\Auth\RegisterApiFrontRequest;
use App\Http\Requests\Core\BaseApiFormRequest;
use App\Http\Resources\Api\Front\UserResource;
use App\Http\Resources\Api\Share\Auth\LoginResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;
use Universe\JWTAuth\Services\JWTService;

use OpenApi\Annotations as OA;

/**
 * Class AuthApiFrontController
 *
 * @package App\Http\Controllers\Api\Front
 */
class AuthApiFrontController extends Core\BaseApiFrontController
{
    use Traits\UserHttpApiFrontTrait;

    /**
     * @var UserService <p>UserService instance.</p>
     */
    protected UserService $userService;

    /**
     * @var JWTService <p>JWTService instance.</p>
     */
    protected JWTService $JWTService;

    /**
     * @param UserService $userService
     * @param JWTService $JWTService
     */
    public function __construct(
        UserService $userService,
        JWTService $JWTService
    ) {
        parent::__construct();

        $this->userService = $userService;
        $this->JWTService = $JWTService;
    }

    /**
     * Register new User.
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/front/register",
     *      operationId="front-auth-register",
     *      summary="Register new User",
     *      description="Register new User",
     *      security={{}},
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Front.Auth.Register"),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/Requests.Api.Front.Auth.Register"),
     *          ),
     *      ),
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Front.Auth.RegisterOk"),
     *      @OA\Response(response=400,ref="#/components/responses/Responses.Api.Core.BadRequest"),
     *      @OA\Response(response=401,ref="#/components/responses/Responses.Api.Core.Unauthorized"),
     *      @OA\Response(response=403,ref="#/components/responses/Responses.Api.Core.Forbidden"),
     *      @OA\Response(response=404,ref="#/components/responses/Responses.Api.Core.NotFound"),
     *      @OA\Response(response=405,ref="#/components/responses/Responses.Api.Core.MethodNotAllowed"),
     *      @OA\Response(response=422,ref="#/components/responses/Responses.Api.Core.UnprocessableEntity"),
     *      @OA\Response(response=500,ref="#/components/responses/Responses.Api.Core.Error"),
     * )
     *
     * @param RegisterApiFrontRequest $request
     * @return JsonResponse
     */
    public function register(RegisterApiFrontRequest $request): JsonResponse
    {
        try {
            $params = $request->validated();
            $usernameCheck = $this->userService->getByUsername($params['username'], RepositoryConst::COLUMNS_DEFAULT, [], null);
            if ($usernameCheck) {
                return $this->unprocessableEntityApiResult(ResponseConst::CODE_DATA_EXIST, __('messages.auth.error.username_exist', ['attribute' => $params['username']]));
            }
            $emailCheck = $this->userService->getByEmail($params['email'], RepositoryConst::COLUMNS_DEFAULT, [], null);
            if ($emailCheck) {
                return $this->unprocessableEntityApiResult(ResponseConst::CODE_DATA_EXIST, __('messages.auth.error.email_exist', ['attribute' => $params['email']]));
            }
            $phoneCheck = $this->userService->getByPhone($params['phone'], RepositoryConst::COLUMNS_DEFAULT, [], null);
            if ($phoneCheck) {
                return $this->unprocessableEntityApiResult(ResponseConst::CODE_DATA_EXIST, __('messages.auth.error.phone_exist', ['attribute' => $params['phone']]));
            }

            $user = $this->userService->handleCreateNew($params);

            // Events
            event(new UserRegisteredEvent($user));

            return $this->okApiResult(UserResource::fromModel($user)->transform());
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Login with email/password.
     * (Using JWT Auth)
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/front/login",
     *      operationId="front-auth-login",
     *      summary="Login",
     *      description="Login with email/password",
     *      security={{}},
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Requests.Api.Front.Auth.Login"),
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/Requests.Api.Front.Auth.Login"),
     *          ),
     *      ),
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Share.Auth.LoginOk"),
     *      @OA\Response(response=400,ref="#/components/responses/Responses.Api.Core.BadRequest"),
     *      @OA\Response(response=401,ref="#/components/responses/Responses.Api.Core.Unauthorized"),
     *      @OA\Response(response=403,ref="#/components/responses/Responses.Api.Core.Forbidden"),
     *      @OA\Response(response=404,ref="#/components/responses/Responses.Api.Core.NotFound"),
     *      @OA\Response(response=405,ref="#/components/responses/Responses.Api.Core.MethodNotAllowed"),
     *      @OA\Response(response=422,ref="#/components/responses/Responses.Api.Core.UnprocessableEntity"),
     *      @OA\Response(response=500,ref="#/components/responses/Responses.Api.Core.Error"),
     * )
     *
     * @param LoginApiFrontRequest $request
     * @return JsonResponse
     */
    public function login(LoginApiFrontRequest $request): JsonResponse
    {
        try {
            $username = $request->validated('username');
            $password = $request->validated('password');
            $remember = (bool)$request->validated('remember', 0);

            // Check user info
            $user = $this->userService->getByUsername($username, RepositoryConst::COLUMNS_DEFAULT, [], null);
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.not_found'));
            }

            if (!$this->userService->itsPassword($user, $password)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.password'));
            }

            $checkInvalid = $this->checkUserInvalid($user);
            if (!empty($checkInvalid)) {
                return $checkInvalid;
            }

            // Authentication for API used: JWTAuth
            [$token, $expiration] = $this->JWTService->login($user, auth()->getDefaultDriver(), JWTService::AREA_FRONT, $remember);
            if (empty($token)) {
                return $this->errorApiResult(new GeneralException(__('messages.auth.error.failed')));
            }

            // Events
            event(new UserLoggedInEvent($user));

            return $this->okApiResult(LoginResource::from([
                'access_token' => $token,
                'token_type' => AuthConst::TOKEN_TYPE,
                'expires_in' => $expiration,
            ])->transform());
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Logout.
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/front/logout",
     *      operationId="front-auth-logout",
     *      summary="Logout",
     *      description="Logout",
     *      security={{"BearerAuth":{}}},
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
    public function logout(BaseApiFormRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (empty($user)) {
                return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.not_found'));
            }

            // Authentication for API used: JWTAuth
            auth()->logout();

            // Events
            event(new UserLoggedOutEvent($user));

            return $this->okApiResult();
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Refresh new token.
     * (Using JWT Auth)
     * @OA\Post(
     *      tags={"Auth"},
     *      path="/api/front/refresh",
     *      operationId="front-auth-refresh-token",
     *      summary="Refresh token",
     *      description="Refresh new token",
     *      security={{"BearerAuth":{}}},
     *
     *      @OA\Response(response=200,ref="#/components/responses/Responses.Api.Share.Auth.RefreshOk"),
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
    public function refresh(BaseApiFormRequest $request): JsonResponse
    {
        // Check exist token.
        $token = $request->bearerToken();
        if (empty($token)) {
            return $this->unauthorizedApiResult(ResponseConst::CODE_UNAUTHORIZED, __('messages.token.error.invalid'), 'TokenInvalidException');
        }
        $user = $request->user();

        try {
            if (empty($user)) {
                /**
                 * Handle Authenticate with JWTAuth Provider for API.
                 *
                 * @throws \Tymon\JWTAuth\Exceptions\TokenExpiredException
                 * @throws \Tymon\JWTAuth\Exceptions\TokenBlacklistedException
                 * @throws \Tymon\JWTAuth\Exceptions\TokenInvalidException
                 * @throws \Tymon\JWTAuth\Exceptions\JWTException
                 * @var \Tymon\JWTAuth\JWTAuth $jwtAuth
                 */
                \Universe\JWTAuth\Services\JWTService::forge()->switchJWTGuard(auth()->getDefaultDriver(), JWTService::AREA_FRONT);
                $jwtAuth = \Tymon\JWTAuth\Facades\JWTAuth::parseToken();
                $jwtAuth->checkOrFail();
                $jwtAuth->authenticate();
            }

            // Handle JWT refresh token.
            $result = $this->handleJWTRefreshToken($request);
            if ($result instanceof LoginResource) {
                return $this->okApiResult($result->transform());
            }
            else {
                return $this->errorApiResult($result);
            }
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
            return $this->unauthorizedApiResult(ResponseConst::CODE_UNAUTHORIZED, __('messages.token.error.blacklisted'), $e::class);
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->unauthorizedApiResult(ResponseConst::CODE_UNAUTHORIZED, __('messages.token.error.invalid'), $e::class);
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // Handle JWT refresh token.
            $result = $this->handleJWTRefreshToken($request);
            if ($result instanceof LoginResource) {
                return $this->okApiResult($result->transform());
            }
            else {
                return $this->errorApiResult($result);
            }
        }
        catch (Throwable $e) {
            return $this->errorApiResult($e);
        }
    }

    /**
     * Handle JWT Refresh Token.
     *
     * @param BaseApiFormRequest $request
     * @return Throwable|LoginResource
     */
    private function handleJWTRefreshToken(BaseApiFormRequest $request): Throwable|LoginResource
    {
        try {
            $guard = auth()->getDefaultDriver();
            [$newToken, $expiration] = $this->JWTService->refreshToken($guard, $request->bearerToken(), JWTService::AREA_FRONT);
            if (empty($newToken)) {
                return new GeneralException(__('messages.auth.error.failed'));
            }

            $request->headers->set('Authorization', 'Bearer '.$newToken);

            /** @var \Tymon\JWTAuth\JWTGuard $JWTGuard */
            $JWTGuard = auth($guard);

            /** @var User $user */
            $user = $JWTGuard->setRequest($request)->setToken($newToken)->user();

            // Events
            event(new UserTokenRefreshedEvent($user));

            return LoginResource::from([
                'access_token' => $newToken,
                'token_type' => AuthConst::TOKEN_TYPE,
                'expires_in' => $expiration,
            ]);
        }
        catch (Throwable $e) {
            return $e;
        }
    }
}
