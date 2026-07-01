<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Jenssegers\Agent\Agent;

class CustomResetPasswordNotification extends ResetPassword
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Get request details
        $request = request();
        $ip = $request->ip();
        
        $browser = $request->userAgent() ?: 'Tidak diketahui';
        $os = 'Tidak diketahui';

        if (class_exists(Agent::class)) {
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());
            $browser = $agent->browser() ?: 'Tidak diketahui';
            if ($agent->version($browser)) {
                $browser .= ' ' . $agent->version($browser);
            }
            $os = $agent->platform() ?: 'Tidak diketahui';
            if ($agent->version($os)) {
                $os .= ' ' . $agent->version($os);
            }
        }

        return (new MailMessage)
            ->subject('Permintaan Reset Password - IMM Korkom UNISA')
            ->view('emails.reset-password-custom', [
                'url' => $url,
                'user' => $notifiable,
                'ip' => $ip,
                'browser' => $browser,
                'os' => $os,
                'time' => now()->translatedFormat('l, d F Y H:i:s') . ' WIB',
            ]);
    }
}
