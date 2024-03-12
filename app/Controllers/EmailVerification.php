<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmailVerification as ModelsEmailVerification;
use App\Models\Guard;
use App\Models\Student;
use App\Traits\EmailVerification as TraitsEmailVerification;

class EmailVerification extends BaseController
{
    use TraitsEmailVerification;

    public function must_verify()
    {
        return view('email_verification/must_verify');
    }

    public function request_to_verify()
    {
        $curr = ((array)json_decode(session()->get('credentials')));
        $curr = $this->verify_email($curr['email'], $curr['role']);

        $msg = ['success', 'Request code has been sent, please check your mailbox.'];
        if(!$curr) ($msg = ['error', 'Ups, something wrong while send the email']);

        return redirect()->to(base_url('verify-your-email'))->with(...$msg);
    }

    public function get_verify_email($token)
    {
        helper('form');
        return view('email_verification/form_verify', ['token' => $token]);
    }

    public function post_verify_email()
    {
        helper('form');        
        $posts = $this->request->getPost(['email', 'token', 'password']);
        $is_valid = $this->validateData($posts, [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'token' => 'required'
        ]);
        if(!$is_valid) return redirect()->to(base_url('verify-email/'.$this->request->getPost('token')))->with('error', 'Invalid Credentials');

        $model = model(ModelsEmailVerification::class);
        $ctx = $model
            ->where('token', $this->request->getPost('token'))
            ->where('email', $this->request->getPost('email'))
            ->first();

        if(empty($ctx)) return redirect()->to(base_url('verify-email/'.$this->request->getPost('token')))->with('error', 'Invalid Password or Email');
        if(strtotime(Date('Y-m-d H:i:s')) > strtotime($ctx['expired_at'])) return redirect()->to(base_url('verify-email/'.$this->request->getPost('token')))->with('error', 'Your token has been expired');
        
        if($ctx['role'] === 'student') ($model = model(Student::class));
        if($ctx['role'] === 'guard') ($model = model(Guard::class));

        $usr = $model->where('email', $this->request->getPost('email'))->first();
        if(!password_verify($this->request?->getPost('password') ?? '', $usr['password'])) return redirect()->to(base_url('verify-email/'.$this->request->getPost('token')))->with('error', 'Invalid Email or Password');

        $model->set(['verified_at' => Date('Y-m-d H:i:s')])
            ->where('email', $this->request->getPost('email'))
            ->update();

        $model = model(ModelsEmailVerification::class);
        $model
            ->set('expired_at', Date('Y-m-d H:i:s'))
            ->where('token', $this->request->getPost('token'))
            ->where('email', $this->request->getPost('email'))
            ->update();

        return redirect()->to('login');
    }
}
