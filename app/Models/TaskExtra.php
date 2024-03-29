<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class TaskExtra extends Model implements Sortable
{
    use HasFactory,
        Searchable,
        SortableTrait;

    /**
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'position',
        'sort_when_creating' => true,
    ];

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
     * @var array
     */
    protected $fillable = [
        'label',
        'is_done',
        'is_time_in',
        'hours',
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
     * Build Sort Query
     * 
     * @return object
     */
    public function buildSortQuery()
    {
        return static::query()->where('user_id', $this->user_id)->where('grouped_date', $this->grouped_date);
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

    /**
     * Get Dashboard Tasks
     * 
     * @return Collection
     */
    public static function getDashboardTasks()
    {
        return (new TaskExtra)::where('user_id', auth()->user()->id)
            ->orderBy('grouped_date', 'desc')
            ->orderBy('position', 'asc')
            ->get()
            ->groupBy('grouped_date')
            ->toBase();
    }
}
