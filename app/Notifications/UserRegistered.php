<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    private $username;
    private $tempPassword;
    private $role;

    public function __construct($username, $tempPassword, $role)
    {
        $this->username = $username;
        $this->tempPassword = $tempPassword;
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Supervisor Hunting System')
            ->greeting('Hello!')
            ->line('Your account has been created successfully as a ' . $this->role . '.')
            ->line('Please use the following credentials to login:')
            ->line('Username: ' . $this->username)
            ->line('Temporary Password: ' . $this->tempPassword)
            ->line('For security reasons, please change your password after your first login.')
            ->action('Login Now', url('/SHS'))
            ->line('Thank you for using our application!');
    }
}
