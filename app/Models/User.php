<?php

namespace App\Models;

use App\Enums\GenderFlag;
use App\Enums\StatusFlag;
use App\Models\Traits\Attributes\UserAttribute;
use App\Models\Traits\Methods\UserMethod;
use App\Models\Traits\Relationships\UserRelationship;
use App\Models\Traits\Scopes\UserScope;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Core\BaseAuthModel implements MustVerifyEmail
{
    use MustVerifyEmailTrait,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;

    /**
     * @const avatar sub_path
     */
    public const AVATAR_SUB_PATH = 'users/avatar/';

    /**
     * The attributes to sort.
     *
     * @var array<int, string>
     */
    public const SORT_FIELDS = [
        'id'        => TABLE_USER.'.id',
        'email'     => TABLE_USER.'.email',
        'firstname' => TABLE_USER.'.firstname',
    ];

    /**
     * This is a key of the SORT_FIELDS array
     */
    public const SORT_DEFAULT = 'id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = TABLE_USER;

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
    protected $fillable = [
        'status',
        'username',
        'password',
        'firstname',
        'lastname',
        'gender',
        'birthday',
        'phone',
        'phone_verified_at',
        'email',
        'email_verified_at',
        'avatar',
        'description',
        'secret',
        'remember_token',
        'lang',
        'timezone',
        'organization',
        'department',
        'position',
        'address',
        'city',
        'country',
        'password_changed_at',
        'first_login_at',
        'first_login_ip',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The model's default values for attributes
     *
     * @var array
     */
    protected $attributes = [
        'status'   => StatusFlag::ACTIVE,
        'password' => '',
        'gender'   => GenderFlag::OTHER,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot',
        'password',
        'secret',
        'remember_token',
        'password_changed_at',
        'first_login_at',
        'first_login_ip',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'password'          => 'hashed', // Laravel 9 Unsupported hashed        
        'birthday'            => 'string',
        'phone_verified_at'   => 'datetime',
        'email_verified_at'   => 'datetime',
        'password_changed_at' => 'datetime',
        'first_login_at'      => 'datetime',
        'last_login_at'       => 'datetime',
    ];

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
}
