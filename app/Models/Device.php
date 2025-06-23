<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\DeviceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Device
 *
 * @property string $id
 * @property string $user_id
 * @property string $brand
 * @property string $type
 * @property string $serial_number
 * @property string $status
 * @property string $service_status
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read DeviceStaffMapping $deviceMapping
 */
class Device extends Model
{
    /** @use HasFactory<DeviceFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'brand',
        'type',
        'serial_number',
        'status',
        'service_status',
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
            $this->deviceMapping()->exists(),
        ])->contains(true);
    }

    /**
     * @return HasOne<DeviceStaffMapping, $this>
     */
    public function deviceMapping(): HasOne
    {
        return $this->hasOne(DeviceStaffMapping::class);
    }
}
