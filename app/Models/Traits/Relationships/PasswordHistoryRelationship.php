<?php

namespace App\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Trait PasswordHistoryRelationship
 *
 * @package App\Models\Traits\Relationships
 */
trait PasswordHistoryRelationship
{
    /**
     * Get the parent modelable model.
     *
     * @return MorphTo
     */
    public function modelable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id', 'id');
    }
}
