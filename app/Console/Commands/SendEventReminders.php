<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminderNotification;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('start_date', [now(), now()->addDay()])
            ->get();

        $eventsCount = $events->count();
        $eventLable = Str::plural('event', $eventsCount);

        $this->info("Found {$eventsCount} {$eventLable}");
        $this->info("Reminder Notification Sent Successfully");

        $events->each(
                fn ($event) => $event->attendees
                ->each(fn ($attendee) => $attendee->user->notify(
                    new EventReminderNotification($event)
                ))
            );
    }
}
