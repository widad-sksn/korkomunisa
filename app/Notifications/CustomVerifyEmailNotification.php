<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomVerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Verifikasi Email Akun Anda - IMM Korkom UNISA'))
            ->view('emails.verify-email-custom', ['url' => $verificationUrl, 'user' => $notifiable]);
    }
}
