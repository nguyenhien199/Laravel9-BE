<?php

namespace App\Models\Core;

use App\Constants\ModelConst;
use App\Models\Core\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * Set default Model value
 *
 * @package App\Models\Core
 */
abstract class BaseModel extends Model
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
}
