<?php

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\actingAs;

// Freeze "now" so the -1 month dashboard window and week labels are deterministic.
beforeEach(fn () => Carbon::setTestNow('2026-05-28 10:00:00')); // Thursday
afterEach(fn () => Carbon::setTestNow());

/**
 * Create a task for the given user with explicit grouped_date / created_at.
 * Bypasses mass-assignment guards (user_id is not fillable) for test setup.
 */
function makeTask(User $user, string $label, string $groupedDate, string $createdAt): Task
{
    $task = Task::forceCreate([
        'user_id'      => $user->id,
        'label'        => $label,
        'hours'        => 1.5,
        'is_done'      => false,
        'is_time_in'   => false,
        'grouped_date' => $groupedDate,
    ]);

    // created_at drives the dashboard's 1-month window; set it past the model's auto-stamp.
    Task::where('id', $task->id)->update(['created_at' => $createdAt]);

    return $task->fresh();
}

test('dashboard shows tasks from the last month but not older ones', function () {
    $user = User::factory()->create();

    makeTask($user, 'Recent weekday task', '2026-05-26', now()->toDateTimeString());
    makeTask($user, 'Old archived task', '2026-03-10', '2026-03-10 09:00:00'); // >1 month before frozen now

    actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Recent weekday task')
        ->assertDontSee('Old archived task');
});

test('view all page groups tasks into Mon-Fri weeks and excludes weekend tasks', function () {
    $user = User::factory()->create();

    makeTask($user, 'Recent weekday task', '2026-05-26', now()->toDateTimeString()); // Tue, week of Mon May 25
    makeTask($user, 'Old archived task', '2026-03-10', '2026-03-10 09:00:00');        // Tue, week of Mon Mar 9
    makeTask($user, 'Sunday weekend task', '2026-05-24', now()->toDateTimeString());  // Sunday — excluded

    actingAs($user)
        ->get('/tasks/all')
        ->assertOk()
        ->assertSee('Recent weekday task')      // weekday, shown
        ->assertSee('Old archived task')        // no date window on this page
        ->assertDontSee('Sunday weekend task')  // weekend, excluded
        ->assertSee('May 25')                   // week header for the May 25–29 workweek
        ->assertSee('Mar 9');                   // week header for the Mar 9–13 workweek
});

test('view all page shows an empty state when the user has no tasks', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/tasks/all')
        ->assertOk()
        ->assertSee('No tasks yet');
});
