<?php

namespace App\Services;

use App\Models\PasswordResetToken;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class PasswordResetTokenService
 *
 * @package App\Services
 */
class PasswordResetTokenService extends Core\BaseService
{
    protected array|null $config = null;

    protected mixed $hasher;

    protected string $key;

    /**
     * PasswordResetTokenService Constructor.
     */
    public function __construct()
    {
        $this->hasher = app('hash');
        $this->key = config('app.key');
        $this->setConfigUser();
    }

    /**
     * @return void
     */
    public function setConfigUser(): void
    {
        $this->config = config('auth.passwords.users');
    }

    /**
     * Create new Token via Email.
     *
     * @param string $email
     * @return string
     * @throws BindingResolutionException
     */
    public function createTokenViaEmail(string $email): string
    {
        $token = $this->genToken();
        $tokenHash = $this->hasher->make($token);

        $this->getTable()->where('email', $email)->delete();
        $this->getTable()->insert(['email' => $email, 'token' => $tokenHash, 'created_at' => new Carbon]);

        return $token;
    }

    /**
     * Create new Token via Phone.
     *
     * @param string $phone
     * @return string
     * @throws BindingResolutionException
     */
    public function createTokenViaPhone(string $phone): string
    {
        $token = $this->genToken();
        $tokenHash = $this->hasher->make($token);

        $this->getTable()->where('phone', $phone)->delete();
        $this->getTable()->insert(['phone' => $phone, 'token' => $tokenHash, 'created_at' => new Carbon]);

        return $token;
    }

    /**
     * Check Token by Email.
     *
     * @param string $email
     * @param string $token
     * @return bool
     * @throws BindingResolutionException
     */
    public function checkTokenByEmail(string $email, string $token): bool
    {
        $record = $this->getTable()->where('email', $email)->first();

        return !empty($record) && !$this->tokenExpired($record->created_at) && $this->hasher->check($token, $record->token);
    }

    /**
     * Check Token by Email.
     *
     * @param string $phone
     * @param string $token
     * @return bool
     * @throws BindingResolutionException
     */
    public function checkTokenByPhone(string $phone, string $token): bool
    {
        $record = $this->getTable()->where('phone', $phone)->first();

        return !empty($record) && !$this->tokenExpired($record->created_at) && $this->hasher->check($token, $record->token);
    }

    /**
     * Delete All Token by Email.
     *
     * @param string $email
     * @return bool
     */
    public function deleteTokenByEmail(string $email): bool
    {
        $this->getTable()->where('email', $email)->delete();

        return true;
    }

    /**
     * Delete all Token by Phone.
     *
     * @param string $phone
     * @return bool
     */
    public function deleteTokenByPhone(string $phone): bool
    {
        $this->getTable()->where('phone', $phone)->delete();

        return true;
    }

    /**
     * Get Table query.
     *
     * @return PasswordResetToken|Builder
     */
    private function getTable(): PasswordResetToken|Builder
    {
        return PasswordResetToken::query();
    }

    /**
     * Gen new Token string.
     *
     * @return string
     */
    private function genToken(): string
    {
        $key = $this->key;
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return hash_hmac('sha256', Str::random(40), $key);
    }

    /**
     * @param string $createdAt
     * @return bool
     */
    private function tokenExpired(string $createdAt): bool
    {
        return Carbon::parse($createdAt)->addSeconds(($this->config['expire'] ?: 60) * 60)->isPast();
    }
}
