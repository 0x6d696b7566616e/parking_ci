<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Guard;
use App\Models\ResetPassword;
use App\Models\Student;
use App\Traits\SendEmail;
use App\Traits\UUID;

class ForgotPassword extends BaseController
{
    use UUID;
    use SendEmail;

    private function handleResetGuard($password, $email)
    {
        $model = model(ResetPassword::class);
        $model->set('expired_at', Date('Y-m-d H:i:s'))->where('token', $this->request->getPost('token'))->update();

        $model = model(Guard::class);
        $model->set('password', password_hash($password, PASSWORD_BCRYPT))->where('email', $email)->update();

        return redirect()->to(base_url('login'))->with('success', 'Your password has been changed');
    }

    public function handleResetStudent($password, $email)
    {
        $model = model(ResetPassword::class);
        $model->set('expired_at', Date('Y-m-d H:i:s'))->where('token', $this->request->getPost('token'))->update();

        $model = model(Student::class);
        $model->set('password', password_hash($password, PASSWORD_BCRYPT))->where('email', $email)->update();
        
        return redirect()->to(base_url('login'))->with('success', 'Your password has been changed');
    }

    private function handleResetGuardAndStudent($password, $email)
    {
        $model = model(ResetPassword::class);
        $model->set('expired_at', Date('Y-m-d H:i:s'))->where('token', $this->request->getPost('token'))->update();
        
        $model = model(Guard::class);
        $model->set('password', password_hash($password, PASSWORD_BCRYPT))->where('email', $email)->update();
        
        $model = model(Student::class);
        $model->set('password', password_hash($password, PASSWORD_BCRYPT))->where('email', $email)->update();

        return redirect()->to(base_url('login'))->with('success', 'Your password has been changed');
    }

    public function index()
    {
        return view('auth/forgot_password');
    }

    public function request_send_email()
    {        
        helper('form');
        $posts = $this->request->getPost(['email',]);
        $is_valid = $this->validateData($posts, [
            'email' => 'required|valid_email',
        ]);
        if(!$is_valid) return redirect()->to(base_url('forgot-password'))->with('error', 'Invalid Email Address');

        $student_model = model(Student::class);
        $guard_model = model(Guard::class);
        $reset_password_model = model(ResetPassword::class);

        $guard = $guard_model->where('email', $posts['email'])->first();
        $student = $student_model->where('email', $posts['email'])->first();

        if(!$guard && !$student) return redirect()->to(base_url('forgot-password'))->with('error', 'Email Address not found');
        
        $data = [
            'email' => $posts['email'],
            'token' => $this->uuid_v4(random_bytes(16)),
            'role' => 'student',
            'expired_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),
        ];

        if($guard) ($data['role'] = 'guard');
        if($guard && $student) ($data['role'] = 'guard-student');

        $reset_password_model->save($data);

        $res = $this->send_mail(
            $data['email'],
            'Reset Password',
            view('send_email/reset_password', ['token' => $data['token']]),
        );

        if(!$res) return redirect()->to(base_url('forgot-password'))->with('error', 'Failed to send email');
        return redirect()->to(base_url('forgot-password'))->with('success', 'Email sent');
    }

    public function get_reset_password($token)
    {
        return view('auth/reset_password', ['token' => $token]);
    }

    public function post_reset_password()
    {        
        helper('form');        
        $posts = $this->request->getPost(['token', 'password']);
        $is_valid = $this->validateData($posts, [
            'password' => 'required|min_length[8]',
            'token' => 'required'
        ]);
        if(!$is_valid) return redirect()->to(base_url('reset-password/'.$this->request->getPost('token')))->with('error', 'Invalid Credentials');

        $model = model(ResetPassword::class);
        $ctx = $model
            ->where('token', $this->request->getPost('token'))
            ->first();
        
        if(empty($ctx)) return redirect()->to(base_url('reset-password/'.$this->request->getPost('token')))->with('error', 'Invalid Credentials');
        if(strtotime(Date('Y-m-d H:i:s')) > strtotime($ctx['expired_at'])) return redirect()->to(base_url('reset-password/'.$this->request->getPost('token')))->with('error', 'Your token has been expired');
        
        if($ctx['role'] === 'guard') return $this->handleResetGuard($this->request->getPost('password'), $ctx['email']);
        if($ctx['role'] === 'student') return $this->handleResetStudent($this->request->getPost('password'), $ctx['email']);
        if($ctx['role'] === 'student-guard') return $this->handleResetGuardAndStudent($this->request->getPost('password'), $ctx['email']);
        return redirect()->to(base_url(400));
    }
}
