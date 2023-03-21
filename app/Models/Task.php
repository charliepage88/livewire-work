<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_done'      => 'boolean',
        'is_time_in'   => 'boolean',
        'grouped_date' => 'date',
        'hours'        => 'float:8,2',
    ];

    /**
     * User
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Notes
     * 
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(TaskNote::class);
    }
}
