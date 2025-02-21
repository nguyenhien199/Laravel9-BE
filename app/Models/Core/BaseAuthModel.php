<?php

namespace App\Models\Core;

use App\Constants\ModelConst;
use App\Models\Core\Eloquent\Concerns\HasRelationships;
use App\Models\PasswordHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class BaseAuthModel
 * Set default Auth Model value
 *
 * @package App\Models\Core
 */
abstract class BaseAuthModel extends Authenticatable implements JWTSubject
{
    use HasFactory,
        HasRelationships;

    public const CREATED_AT = ModelConst::CREATED_AT;
    public const UPDATED_AT = ModelConst::UPDATED_AT;
    public const DELETED_AT = ModelConst::DELETED_AT;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public static function morphClass(): string
    {
        return (new static)->getMorphClass();
    }

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ModelConst::ID_PRIMARY;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The model's default values for attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot'
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = DATE_TIME_FORMAT;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * ==================== FOR JWT ====================
     */

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            //
        ];
    }

    /**
     * ==================== FOR RELATION ====================
     */

    /**
     * With list Password history.
     *
     * @return MorphMany
     */
    public function password_histories(): MorphMany
    {
        return $this->morphMany(PasswordHistory::class, 'modelable', 'model_type', 'model_id', 'id');
    }
}