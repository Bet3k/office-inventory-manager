<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Session
 *
 * @property Carbon $last_activity
 *
 * @property-read User $user
 *
 * @property string $id
 * @property string $payload
 * @property string $user_agent
 * @property string $ip_address
 * @property string $user_id
 */
class UserSession extends Model
{
    use HasUuids;

    protected $table = 'sessions';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
