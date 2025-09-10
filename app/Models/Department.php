<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Department
 *
 * @property string $id
 * @property string $user_id
 * @property string $department
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 */
class Department extends Model
{
    /** @use HasFactory<DepartmentFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'department',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
