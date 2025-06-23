<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\DeviceStaffMappingFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DeviceStaffMapping
 *
 * @property string $id
 * @property string $user_id
 * @property string $member_of_staff_id
 * @property string $device_id
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read MemberOfStaff $memberOfStaff
 * @property-read Device $device
 */
class DeviceStaffMapping extends Model
{
    /** @use HasFactory<DeviceStaffMappingFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'member_of_staff_id',
        'device_id',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<MemberOfStaff, $this>
     */
    public function memberOfStaff(): BelongsTo
    {
        return $this->belongsTo(MemberOfStaff::class);
    }

    /**
     * @return BelongsTo<Device, $this>
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
