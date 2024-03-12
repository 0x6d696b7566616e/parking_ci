<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Guard;

class AuthGuard extends BaseController
{
    public function get_login()
    {
        helper('form');
        return view('auth/guard/login');
    }

    public function get_register()
    {
        helper('form');
        return view('auth/guard/register');
    }

    public function post_register()
    {
        helper('form');
        $posts = $this->request->getPost(['email', 'nip', 'password', 'confirm_password', 'is_admin']);
        $is_valid = $this->validateData($posts, [
            'email' => 'required|valid_email|is_unique[guards.email]',
            'nip' => 'required|max_length[50]|is_unique[guards.nip]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ]);
        if(!$is_valid) return view('auth/guard/register', ['validation' => $this->validator]);
        $model = model(Guard::class);
        $model->save(array_merge(
            $posts,
            [
                'password' => password_hash($posts['password'], PASSWORD_BCRYPT),
                'is_admin' => $posts['is_admin'] === 'on' ? true : false
            ]
        ));
        return redirect()->to(base_url('guard/login'));
    }
    
    public function post_login()
    {
        helper('form');
        $posts = $this->request->getPost(['email', 'password']);
        $is_valid = $this->validateData($posts, [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ]);
        if(!$is_valid) return view('auth/guard/login', ['validation' => $this->validator]);
        $model = model(Guard::class);
        $guard = $model->where('email', $posts['email'])->first();
        if(!$guard) return view('auth/guard/login', ['error' => 'Invalid Email or password']);
        if(!password_verify($posts['password'], $guard['password'])) return view('auth/guard/login', ['error' => 'Invalid Email or password']);
        if(!((bool)$guard['is_active'])) return view('auth/guard/login', ['error' => 'Your account has been inactivated, please contact Admin']);
        session()->set('credentials', json_encode([
            'id' => $guard['id'],
            'email' => $guard['email'],
            'nama' => $guard['nama'],
            'role' => 'guard',
            'is_admin' => (bool)$guard['is_admin']
        ])); 
        return redirect()->to(base_url('guard/dashboard'));
    }
}
