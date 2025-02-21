<?php

namespace App\Services;

use App\Constants\FileSystemConst;
use App\Constants\RepositoryConst;
use App\Enums\GenderFlag;
use App\Enums\StatusFlag;
use App\Exceptions\DatabaseException;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\GeneralException;
use App\Models\PasswordHistory;
use App\Models\User;
use App\Repositories\Contracts\IUserRepo;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService extends Core\BaseService
{
    /**
     * User repository instance.
     *
     * @var IUserRepo
     */
    protected IUserRepo $userRepo;

    /**
     * @param IUserRepo $userRepo
     */
    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Find User by primary key.
     *
     * @param int|string $userId  <p>The User primary key value.</p>
     * @param array      $columns [optional] <p>Select column list (default: ['*']). <br/>
     *                            column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                            or <br/>
     *                            select all column: <b>['*']</b>
     *                            </p>
     * @param array      $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null  $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                            <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                            <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                            <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                            </p>
     * @return User|null The User instance or NULL if not found.
     * @throws DatabaseException
     */
    public function getById(int|string $userId, array $columns = RepositoryConst::COLUMNS_DEFAULT, array $withs = [], bool|null $inTrash = false): ?User
    {
        /** @var User|null */
        return $this->userRepo->find($userId, $columns, $withs, $inTrash);
    }

    /**
     * Get User by username (to login)
     *
     * @param string    $username <p>User username value.</p>
     * @param array     $columns  [optional] <p>Select column list (default: ['*']). <br/>
     *                            column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                            or <br/>
     *                            select all column: <b>['*']</b>
     *                            </p>
     * @param array     $withs    [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null $inTrash  [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                            <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                            <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                            <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                            </p>
     * @return User|null The User instance or NULL if not found.
     * @throws DatabaseException
     */
    public function getByUsername(string $username, array $columns = RepositoryConst::COLUMNS_DEFAULT, array $withs = [], bool|null $inTrash = false): ?User
    {
        /** @var User|null */
        return $this->userRepo->getFirst(['username' => $username], ['columns' => $columns], $withs, $inTrash);
    }

    /**
     * Get User by email (to login SSO).
     *
     * @param string    $email   <p>User email value.</p>
     * @param array     $columns [optional] <p>Select column list (default: ['*']). <br/>
     *                           column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                           or <br/>
     *                           select all column: <b>['*']</b>
     *                           </p>
     * @param array     $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                           <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                           <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                           <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                           </p>
     * @return User|null The User instance or NULL if not found.
     * @throws DatabaseException
     */
    public function getByEmail(string $email, array $columns = RepositoryConst::COLUMNS_DEFAULT, array $withs = [], bool|null $inTrash = false): ?User
    {
        /** @var User|null */
        return $this->userRepo->getFirst(['email' => $email], ['columns' => $columns], $withs, $inTrash);
    }

    /**
     * Get User by phone (to login OTP).
     *
     * @param string    $phone   <p>User phone value.</p>
     * @param array     $columns [optional] <p>Select column list (default: ['*']). <br/>
     *                           column selection: <b>['table_a.column_a', 'table_a.column_b', ... ]</b> <br/>
     *                           or <br/>
     *                           select all column: <b>['*']</b>
     *                           </p>
     * @param array     $withs   [optional] <p>The Relationships need to be loaded.</p>
     * @param bool|null $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                           <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                           <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                           <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                           </p>
     * @throws DatabaseException
     */
    public function getByPhone(string $phone, array $columns = RepositoryConst::COLUMNS_DEFAULT, array $withs = [], bool|null $inTrash = false): ?User
    {
        /** @var User|null */
        return $this->userRepo->getFirst(['phone' => $phone], ['columns' => $columns], $withs, $inTrash);
    }

    /**
     * Delete user.
     *
     * @param User $user
     * @return bool
     * @throws DatabaseException
     */
    public function deleteByObj(User $user): bool
    {
        return $this->userRepo->delete($user);
    }

    /**
     * Check User's password.
     *
     * @param User   $user
     * @param string $password
     * @return bool
     */
    public function itsPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Check duplicate old password with new password when edit user.
     *
     * @param User   $user
     * @param string $password
     * @return bool
     */
    public function checkPasswordSameAsOld(User $user, string $password): bool
    {
        // Check Password change history enabled?
        if (password_history_enabled() === false) {
            return true;
        }

        // Get Password change history number limit?
        $phl = password_history_limit();
        if ($phl > 0) {
            $phs = $user->password_histories()
                ->orderBy(PasswordHistory::CREATED_AT, RepositoryConst::SORT_TYPE_DESC)
                ->limit($phl)
                ->get();
            foreach ($phs as $ph) {
                if (Hash::check($password, $ph->password)) {
                    return true;
                }
            }
        }
        else {
            // Check password currently used?
            if (Hash::check($password, $user->password)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Upload Avatar by Base64 encode.
     *
     * @param string $encode <p>Image encode base64.</p>
     * @return string image path after upload.
     * @throws GeneralException
     */
    public function uploadAvatarByFileBase64(string $encode): string
    {
        $disk = config('filesystems.default');
        $disk = ($disk === FileSystemConst::LOCAL_DISK ? FileSystemConst::PUBLIC_DISK : $disk);
        return (new FileUploadService())->storeFileByBase64($encode, User::AVATAR_SUB_PATH, $disk);
    }

    /**
     * Upload Avatar by UploadFile.
     *
     * @param UploadedFile $uploadedFile <p>File uploaded.</p>
     * @return string image path after upload.
     * @throws GeneralException
     */
    public function uploadAvatarByUploadFile(UploadedFile $uploadedFile): string
    {
        $disk = config('filesystems.default');
        $disk = ($disk === FileSystemConst::LOCAL_DISK ? FileSystemConst::PUBLIC_DISK : $disk);
        return (new FileUploadService())->storeFile($uploadedFile, '', User::AVATAR_SUB_PATH, $disk);
    }

    /**
     * ==================== MANAGEMENT FUNCTIONS ====================
     */

    /**
     * Get list with search and return paginate
     *
     * @param array     $params  [per_page, page_name, page, columns, sort_type, sort, user_id, email, firstname, gender, status]
     * @param bool|null $inTrash [optional] <p>Use Trashed for Model's query (default: FALSE). <br/>
     *                           <b>FALSE</b>: Get only Models that are not soft-deleted (withoutTrashed). <br/>
     *                           <b>TRUE</b>: Get only Models that have been soft-deleted (onlyTrashed). <br/>
     *                           <b>NULL</b>: Get all Models including soft-deleted (withTrashed).
     *                           </p>
     * @return LengthAwarePaginator
     * @throws DatabaseException
     */
    public function getPagination(array $params = [], bool|null $inTrash = false): LengthAwarePaginator
    {
        $options = [
            'sort' => (!empty($params['sort']) && array_key_exists(strtolower($params['sort']), User::SORT_FIELDS))
                ? User::SORT_FIELDS[strtolower($params['sort'])]
                : User::SORT_FIELDS[User::SORT_DEFAULT]
        ];
        $options = array_merge($params, $options);

        $where = [];
        if (isset($params['user_id']) && $params['user_id'] != '') {
            $where[] = [TABLE_USER.'.id', '=', (int)$params['user_id']];
        }
        if (isset($params['email']) && $params['email'] != '') {
            $where[] = [TABLE_USER.'.email', 'like', '%'.trim($params['email']).'%'];
        }
        if (isset($params['gender']) && $params['gender'] != '') {
            $where[] = [TABLE_USER.'.gender', '=', (int)$params['gender']];
        }
        if (isset($params['status']) && $params['status'] != '') {
            $where[] = [TABLE_USER.'.status', '=', (int)$params['status']];
        }

        return $this->userRepo->paginate($where, $options, [], $inTrash);
    }

    /**
     * Handle User create new.
     *
     * @param array $params
     * @return User
     * @throws GeneralException
     */
    public function handleCreateNew(array $params = []): User
    {
        DB::beginTransaction();
        try {
            $userData = $this->handlingBeforeCreation($params);
            if (empty($userData)) {
                DB::rollBack();
                throw new DataNotFoundException(__('validation.custom.request.data_not_found'));
            }

            /** @var User $newUser */
            $newUser = $this->userRepo->create($userData);
            DB::commit();
            return $newUser->refresh();
        }
        catch (Throwable $e) {
            DB::rollBack();
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * Handle User update.
     *
     * @param User  $user
     * @param array $params [firstname, lastname, gender...]
     * @return bool
     * @throws GeneralException
     */
    public function handleUpdate(User $user, array $params = []): bool
    {
        DB::beginTransaction();
        try {
            $userData = $this->handlingBeforeUpdate($params);
            if (empty($userData)) {
                DB::commit();
                return true;
            }

            $update = $this->userRepo->update($user, $userData);
            if (!$update) {
                DB::rollBack();
                throw new GeneralException(__('messages.action.error.update'));
            }

            DB::commit();
            return true;
        }
        catch (Throwable $e) {
            DB::rollBack();
            throw new GeneralException($e->getMessage());
        }
    }

    /**
     * ==================== PRIVATE FUNCTIONS ====================
     */

    /**
     * Handling data before creation User.
     *
     * @param array $params
     * @return array
     * @throws DataNotFoundException|GeneralException
     */
    private function handlingBeforeCreation(array $params = []): array
    {
        if (empty($params) || !is_array($params)) {
            return [];
        }

        // Unset other data.
        unset($params['id'], $params['created_at'], $params['updated_at'], $params['deleted_at']);

        $fieldNotNull = ['username', 'password', 'firstname', 'lastname', 'email', 'phone'];
        foreach ($fieldNotNull as $field) {
            if (!isset($params[$field])) {
                throw new DataNotFoundException(__('validation.custom.request.field_not_found', ['attribute' => $field]));
            }
        }

        if (!empty($params['avatar']) && $params['avatar'] instanceof UploadedFile) {
            $params['avatar'] = $this->uploadAvatarByUploadFile($params['avatar']);
        }
        else {
            unset($params['avatar']);
        }

        $params = $this->formatDefaultData($params);

        // Setting default data.
        $params['gender'] = isset($params['gender']) && in_array($params['gender'], GenderFlag::getValues()) ? $params['gender'] : GenderFlag::OTHER;
        $params['status'] = isset($params['status']) && in_array($params['status'], StatusFlag::getValues()) ? $params['status'] : StatusFlag::ACTIVE;
        $params['secret'] = !empty($params['secret']) ? $params['secret'] : Str::random(64);

        $params['phone_verified_at'] = null;
        $params['email_verified_at'] = null;
        $params['remember_token'] = null;

        return $params;
    }

    /**
     * Handling data before update User
     *
     * @param array $params
     * @return array
     * @throws DataNotFoundException|GeneralException
     */
    private function handlingBeforeUpdate(array $params = []): array
    {
        if (empty($params) || !is_array($params)) {
            return [];
        }

        // Unset other data.
        unset($params['id'], $params['created_at'], $params['updated_at'], $params['deleted_at']);

        $fieldNotNull = ['username', 'password', 'firstname', 'lastname', 'email', 'phone'];
        foreach ($fieldNotNull as $field) {
            if (isset($params[$field]) && empty($params[$field])) {
                throw new DataNotFoundException(__('validation.custom.request.field_not_empty', ['attribute' => $field]));
            }
        }

        if (!isset($params['gender']) || !in_array($params['gender'], GenderFlag::getValues())) {
            unset($params['gender']);
        }
        if (!isset($params['status']) || !in_array($params['status'], StatusFlag::getValues())) {
            unset($params['status']);
        }

        if (!empty($params['avatar']) && $params['avatar'] instanceof UploadedFile) {
            $params['avatar'] = $this->uploadAvatarByUploadFile($params['avatar']);
        }
        else {
            unset($params['avatar']);
        }

        return $this->formatDefaultData($params);
    }

    /**
     * Format Default Data before Insert/Update.
     *
     * @param array $params
     * @return array
     */
    private function formatDefaultData(array $params = []): array
    {
        foreach ($params as $field => $value) {
            if (is_null($value)) {
                continue;
            }

            $value = mb_trim($value);
            switch ($field) {
                case 'username':
                case 'email':
                    $params[$field] = strtolower($value);
                    break;
                case 'password':
                    $params[$field] = Hash::make($value);
                    break;
                case 'firstname':
                case 'lastname':
                    $params[$field] = ucwords(strtolower($value));
                    break;
            }
        }
        return $params;
    }
}
