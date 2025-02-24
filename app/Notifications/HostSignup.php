<?php

namespace App\Notifications;

use App\HelpType;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Routing\Route;

class HostSignup extends Notification
{
    use Queueable;

    private User $user;
    private string $resetToken;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user, string $resetToken)
    {
        $this->user = $user;
        $this->resetToken = $resetToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->getMail();
    }

    private function getMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(__("Thank you for your signup"))
            ->line($this->user->name . ', ' . __('Please click here to confirm your account and choose a password'))
            ->action(__("Confirm your account"), route('password.reset', $this->resetToken))
            ->greeting(__("Thank you for your signup"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
