<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class DeadlineReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $activity;
    public $type;

    public function __construct($activity, string $type = 'activity')
    {
        $this->activity = $activity;
        $this->type = $type;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $title = $this->getTitle();
        $date = optional($this->activity->activity_date)?->format('M d, Y') ?? 'No date set';

        return (new MailMessage)
            ->subject("Reminder: pending {$this->type} — {$title}")
            ->greeting('Hello ' . ($notifiable->name ?? 'Instructor') . ',')
            ->line("You have a pending {$this->type} that needs attention.")
            ->line("Title: {$title}")
            ->line("Status: " . ucfirst($this->activity->status))
            ->line("Activity Date: {$date}")
            ->action('Open Dashboard', url('/instructor'))
            ->line('Please update or complete this item in the system.');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->type,
            'activity_id' => $this->activity->id,
            'model' => get_class($this->activity),
            'title' => $this->getTitle(),
            'status' => $this->activity->status,
            'activity_date' => optional($this->activity->activity_date)?->toDateString(),
            'message' => "{$this->getTitle()} is pending and needs attention.",
        ];
    }

    protected function getTitle(): string
    {
        return $this->activity->assignment_title
            ?? $this->activity->email_subject
            ?? $this->activity->gdb_identifier
            ?? $this->activity->ticket_id
           ?? ($this->activity->description ? Str::limit($this->activity->description, 50) : 'Task');

    }
}
