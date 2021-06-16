<?php

declare(strict_types=1);

namespace Tests\Unit\Notification\Auth;

use App\Domain\User\User;
use App\Notifications\EmailVerification;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    public function testMessage()
    {
        $user = User::factory()->create();
        $notification = new EmailVerification();
        $mail = $notification->toMail($user);

        $expectedFrom = ['service@catgram.jp', 'Catitionary'];
        $expectedSubject = '[Catitionary] 仮登録完了のお知らせ';
        $expectedBody =
            "Catitionaryへのご登録ありがとうございます。\n" .
            "\n" .
            "仮登録が完了しましたので、本登録についてご案内いたします。\n" .
            "\n" .
            "以下のURLにアクセスし、本登録を完了させてください。\n" .
            "\n" .
            config('app.url') . "/auth/verify-email?code={$user->email_verification_code}\n" .
            "\n" .
            "※URLの有効期間は仮登録から24時間です。\n" .
            "　期限を超過してしまった場合は、お手数ですが再度登録をお願いいたします。\n" .
            "\n" .
            "──────────────────────────────────\n" .
            "このメールは、自動配信システムを利用し、送信専用のメールアドレスから配信しております。\n" .
            "本メールにご返信いただいてもご対応いたしかねますので、あらかじめご了承願います。\n" .
            "──────────────────────────────────\n" .
            "\n" .
            "【発行元】 Catitionary\n"
        ;

        $this->assertEquals($expectedFrom, $mail->from);
        $this->assertEquals($expectedSubject, $mail->subject);
        $this->assertEquals($expectedBody, $mail->render());
    }
}
/*
Catitionaryへのご登録ありがとうございます。

仮登録が完了しましたので、本登録についてご案内いたします。

以下のURLにアクセスし、本登録を完了させてください。

{{ $url }}

※URLの有効期間は仮登録から24時間です。
　期限を超過してしまった場合は、お手数ですが再度登録をお願いいたします。

──────────────────────────────────
このメールは、自動配信システムを利用し、送信専用のメールアドレスから配信しております。
本メールにご返信いただいてもご対応いたしかねますので、あらかじめご了承願います。
──────────────────────────────────

【発行元】 Catitionary  catitionary.catgram.jp

*/
