<?php

namespace App\Models;

use App\Models\Traits\Attributes\PasswordHistoryAttribute;
use App\Models\Traits\Methods\PasswordHistoryMethod;
use App\Models\Traits\Relationships\PasswordHistoryRelationship;
use App\Models\Traits\Scopes\PasswordHistoryScope;

/**
 * Class PasswordHistory
 *
 * @package App\Models
 */
class PasswordHistory extends Core\BaseModel
{
    use PasswordHistoryAttribute,
        PasswordHistoryMethod,
        PasswordHistoryRelationship,
        PasswordHistoryScope;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = TABLE_PASSWORD_HISTORY;

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
        'password',
    ];

    /**
     * The model's default values for attributes
     *
     * @var array
     */
    protected $attributes = [
        'password' => '',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'password' => 'hashed', // Laravel 9 Unsupported hashed 
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
