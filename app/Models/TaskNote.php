<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class TaskNote extends Model
{
    use HasFactory,
        Searchable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'grouped_date' => 'date',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'body',
        'grouped_date',
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
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $data = $this->toArray();

        $data['user'] = $this->user->toArray();

        return $data;
    }
}
