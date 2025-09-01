<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PersonalDataProcessedFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PersonalDataProcessed
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 */
class PersonalDataProcessed extends Model
{
    /** @use HasFactory<PersonalDataProcessedFactory> */
    use HasFactory;
    use HasUuids;

    protected $table = 'personal_data_processed';

    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
