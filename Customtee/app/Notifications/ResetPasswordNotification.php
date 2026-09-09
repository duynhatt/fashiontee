<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $expire = (int) config('auth.passwords.users.expire', 10);

        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Mã đặt lại mật khẩu')
            ->greeting('Xin chào!')
            ->line('Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
            ->line('Mã xác nhận của bạn:')
            ->line("**{$this->code}**")
            ->line("Mã này sẽ hết hạn sau {$expire} phút.")
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, ' . config('app.name'));
    }
}
