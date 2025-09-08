<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PersonalDataTypeFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PersonalDataType
 *
 * @property string $id
 * @property string $user_id
 * @property string $data_type
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 */
class PersonalDataType extends Model
{
    /** @use HasFactory<PersonalDataTypeFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'data_type',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
