<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $url = $this->getUrl($notifiable->email_verification_code);
        return (new MailMessage)
            ->from('service@catgram.jp', 'Catitionary')
            ->subject('[Catitionary] 仮登録完了のお知らせ')
            ->view('mail.auth.email_verification', [
                'url' => $this->getUrl($notifiable->email_verification_code),
            ]);
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
            'code' => $notifiable->email_verification_code,
            'url'  => $this->getUrl($notifiable->email_verification_code),
        ];
    }

    private function getUrl(string $code): string
    {
        return url()->to("/auth/verify-email?code={$code}");
    }
}
