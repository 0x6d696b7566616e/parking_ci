<?php

namespace App\Traits;

trait SendEmail{
    public function send_mail(
        $receiver,
        $subject,
        $message,
    )
    {
        $email = \Config\Services::email();

        $email->setFrom('developer@parking.com', 'Kirisaki Rem');
        $email->setTo($receiver);

        $email->setSubject($subject);
        $email->setMessage($message);

        $res = $email->send();

        if(!$res) log_message('error', 'Error Send Email ('.$subject.')');

        return $res;
    }
}