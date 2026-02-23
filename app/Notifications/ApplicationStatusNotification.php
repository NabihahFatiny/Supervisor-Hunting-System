<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;
    protected $status;
    protected $remarks;

    /**
     * Create a new notification instance.
     */
    public function __construct($application, $status, $remarks)
    {
        $this->application = $application;
        $this->status = $status;
        $this->remarks = $remarks;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = ucfirst(strtolower($this->status));
        $subject = "FYP Application {$statusText}";

        $message = (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->studName},")
            ->line("Your FYP application has been {$statusText}.")
            ->line("Project Title: {$this->application->TitleName}");

        if ($this->remarks) {
            $message->line("Remarks from supervisor:")
                   ->line($this->remarks);
        }

        if ($this->status === 'Approved') {
            $message->line("Congratulations! You can now proceed with your FYP.")
                   ->action('View Application Details', route('student.applications'));
        } else {
            $message->line("You may submit a new application or revise your proposal.")
                   ->action('Submit New Application', route('student.submit'));
        }

        return $message->line('Thank you for using our application system.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->application_id,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'title' => $this->application->TitleName,
            'timestamp' => now()
        ];
    }
}
