<?php

namespace App\Controllers;

use App\Models\Student;

class Auth extends BaseController
{
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function get_login()
    {
        helper('form');
        return view('auth/login');
    }

    public function get_register()
    {
        helper('form');
        return view('auth/register');
    }

    public function post_register()
    {
        helper('form');
        if(!$this->request->is('post')) return view('error_responses/400');
        $posts = $this->request->getPost(['email', 'nim', 'password', 'confirm_password']);
        $is_valid = $this->validateData($posts, [
            'email' => 'required|valid_email|is_unique[students.email]',
            'nim' => 'required|max_length[10]|is_unique[students.nim]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ]);
        if(!$is_valid) return view('auth/register', ['validation' => $this->validator]);
        $model = model(Student::class);
        $model->save(array_merge(            
            $posts,
            ['password' => password_hash($posts['password'], PASSWORD_BCRYPT),]
        ));
        return view('auth/login');
    }
    
    public function post_login()
    {
        helper('form');
        if(!$this->request->is('post')) return view('error_responses/400');
        $posts = $this->request->getPost(['nim', 'password']);
        $is_valid = $this->validateData($posts, [
            'nim' => 'required|max_length[10]',
            'password' => 'required|min_length[8]',
        ]);
        if(!$is_valid) return view('auth/login', ['validation' => $this->validator]);
        $model = model(Student::class);
        $student = $model->where('nim', $posts['nim'])->first();
        if(!$student) return view('auth/login', ['error' => 'Invalid NIM or password']);
        if(!password_verify($posts['password'], $student['password'])) return view('auth/login', ['error' => 'Invalid NIM or password']);
        session()->set('credentials', json_encode([
            'id' => $student['id'],
            'email' => $student['email'],
            'nama' => $student['nama'],
            'role' => 'student',
            'is_admin' => false,
        ])); 
        return redirect()->to(base_url('dashboard'));
    }
}
 