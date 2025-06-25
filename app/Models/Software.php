<?php

namespace App\Models;

use Database\Factories\SoftwareFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
