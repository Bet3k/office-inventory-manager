<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\SoftwareFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Software
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $status
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 */
class Software extends Model
{
    /** @use HasFactory<SoftwareFactory> */
    use HasFactory;
    use HasUuids;


    protected $fillable = [
        'user_id',
        'name',
        'status',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
