<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Jenssegers\Agent\Agent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public $ip;
    public $browser;
    public $os;
    public $time;

    public function __construct($token)
    {
        parent::__construct($token);
        
        $request = request();
        $this->ip = $request->ip() ?: 'Unknown';
        
        $this->browser = $request->userAgent() ?: 'Tidak diketahui';
        $this->os = 'Tidak diketahui';

        if (class_exists(Agent::class)) {
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());
            $this->browser = $agent->browser() ?: 'Tidak diketahui';
            if ($agent->version($this->browser)) {
                $this->browser .= ' ' . $agent->version($this->browser);
            }
            $this->os = $agent->platform() ?: 'Tidak diketahui';
            if ($agent->version($this->os)) {
                $this->os .= ' ' . $agent->version($this->os);
            }
        }
        $this->time = now()->translatedFormat('l, d F Y H:i:s') . ' WIB';
    }

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

        return (new MailMessage)
            ->subject('Permintaan Reset Password - IMM Korkom UNISA')
            ->view('emails.reset-password-custom', [
                'url' => $url,
                'user' => $notifiable,
                'ip' => $this->ip,
                'browser' => $this->browser,
                'os' => $this->os,
                'time' => $this->time,
            ]);
    }
}
