<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Fort\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationNotification extends Notification
{
    /**
     * The email verification token.
     *
     * @var string
     */
    public $token;

    /**
     * The password reset token expiration.
     *
     * @var string
     */
    public $expiration;

    /**
     * Create a notification instance.
     *
     * @param array  $token
     * @param string $expiration
     */
    public function __construct(array $token, $expiration)
    {
        $this->token = $token;
        $this->expiration = $expiration;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage())
            ->subject(trans('rinvex/fort::frontend/emails.verification.email.subject'))
            ->line(trans('rinvex/fort::frontend/emails.verification.email.intro', ['expire' => $this->expiration]))
            ->action(trans('rinvex/fort::frontend/emails.verification.email.action'), route('rinvex.fort.frontend.verification.email.verify').'?token='.$this->token['token'].'&email='.$this->token['email'])
            ->line(trans('rinvex/fort::frontend/emails.verification.email.outro', [
                'ip'         => $this->token['ip'],
                'agent'      => $this->token['agent'],
                'created_at' => $this->token['created_at'],
            ]));
    }
}
