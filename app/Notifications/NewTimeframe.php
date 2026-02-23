<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewTimeframe extends Notification implements ShouldQueue
{
    use Queueable;

    protected $startDate;
    protected $endDate;

    /**
     * Create a new notification instance.
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        try {
            $startDate = \Carbon\Carbon::parse($this->startDate)->format('d/m/Y');
            $endDate = \Carbon\Carbon::parse($this->endDate)->format('d/m/Y');

            // Get the correct name and email based on the model type
            if ($notifiable instanceof \App\Models\Student) {
                $name = $notifiable->studName;
                $email = $notifiable->studEmail;
                $role = 'Student';
            } else {
                $name = $notifiable->lecturerName;
                $email = $notifiable->email;
                $role = 'Lecturer';
            }

            Log::info("Sending email to {$role}: {$name} ({$email})");

            return (new MailMessage)
                ->subject('New Supervisor Hunting Period Announced')
                ->greeting("Hello {$name}")
                ->line("This email is to inform you that a new supervisor hunting period has been set.")
                ->line("Start Date: {$startDate}")
                ->line("End Date: {$endDate}")
                ->line($role === 'Student'
                    ? 'Please ensure to complete your supervisor selection within this timeframe.'
                    : 'Please ensure to review and respond to student requests within this timeframe.')
                ->action('Access System', url('/'))
                ->line('Thank you for using our Supervisor Hunting System.');

        } catch (\Exception $e) {
            Log::error("Error preparing email for {$notifiable->email}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
    }
}
