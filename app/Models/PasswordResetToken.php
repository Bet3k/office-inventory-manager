<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PasswordResetToken
 *
 * @property Carbon|null $created_at
 *
 * @property-read User $user_id
 *
 * @property string $token
 */
class PasswordResetToken extends Model
{
    use HasUuids;

    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'created_at',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'timestamp',
        ];
    }
}
