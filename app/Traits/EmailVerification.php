<?php

namespace App\Traits;

use App\Models\EmailVerification as ModelsEmailVerification;

trait EmailVerification{
    use UUID;
    use SendEmail;

    public function verify_email(
        $email,
        $role
    )
    {
        $data = [
            'email' => $email,
            'role' => $role,
            'token' => $this->uuid_v4(random_bytes(16)),
            'expired_at' => Date('Y-m-d H:i:s', strtotime('+1 days')),
        ];

        $model = model(ModelsEmailVerification::class);
        $model->save($data);
        
        $res = $this->send_mail(
            $email,
            'Email Verification',
            view('send_email/email_verification', ['token' => $data['token']])
        );

        return $res;
    }
}