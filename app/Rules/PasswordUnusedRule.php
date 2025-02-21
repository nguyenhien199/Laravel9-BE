<?php

namespace App\Rules;

use App\Constants\RepositoryConst;
use App\Models\Core\BaseAuthModel;
use App\Models\PasswordHistory;
use App\Rules\Core\BaseRule;
use Illuminate\Support\Facades\Hash;

/**
 * Class PasswordUnusedRule
 *
 * @package App\Rules
 */
class PasswordUnusedRule extends BaseRule
{
    /**
     * @var BaseAuthModel Authenticatable instance.
     */
    protected BaseAuthModel $authenticatable;

    /**
     * UnusedPassword Constructor
     *
     * @param BaseAuthModel $authenticatable
     */
    public function __construct(BaseAuthModel $authenticatable)
    {
        $this->authenticatable = $authenticatable;

        $this->message = __('validation.custom.password.same_as_current');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // Check Password change history enabled?
        if (password_history_enabled() === false) {
            return true;
        }

        // Get Password change history number limit?
        $phl = password_history_limit();
        if ($phl > 0) {
            $phs = $this->authenticatable->password_histories()
                ->orderBy(PasswordHistory::CREATED_AT, RepositoryConst::SORT_TYPE_DESC)
                ->limit($phl)
                ->get();
            foreach ($phs as $val) {
                if (Hash::check($value, $val->password)) {
                    $this->message = __('validation.custom.password.existed_in_history', ['number' => $phl]);
                    return false;
                }
            }
        }
        else {
            // Check password currently used?
            if (Hash::check($value, $this->authenticatable->password)) {
                $this->message = __('validation.custom.password.same_as_current', ['attribute' => $attribute]);
                return false;
            }
        }

        return true;
    }
}
