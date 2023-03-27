<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class TaskExtraCollection extends Collection
{
    /**
     * Get Total Hours
     * 
     * @return float
     */
    public function getTotalHours(): float
    {
        return $this->filter(function ($task) {
            return $task->is_done;
        })->sum(function ($task) {
            return floatval($task->hours);
        });
    }
}
