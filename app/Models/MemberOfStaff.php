<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\MemberOfStaffFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\MemberStaff
 *
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read DeviceStaffMapping $staffDevices
 */
class MemberOfStaff extends Model
{
    /** @use HasFactory<MemberOfStaffFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasResources(): bool
    {
        return collect([
            $this->staffDevices()->exists(),
        ])->contains(true);
    }

    /**
     * @return HasMany<DeviceStaffMapping, $this>
     */
    public function staffDevices(): HasMany
    {
        return $this->hasMany(DeviceStaffMapping::class);
    }
}
