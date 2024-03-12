<?php

namespace App\Controllers\UpdateProfile;

use App\Controllers\BaseController;
use App\Models\Guard;
use App\Traits\EmailVerification;
use App\Traits\SendEmail;
use CodeIgniter\Files\File;

class GuardUpdateProfile extends BaseController
{
    use EmailVerification;

    public function index()
    {
        helper('form');
        $model = model(Guard::class);
        $curr = $model->find(((array)json_decode(session()->get('credentials')))['id']);
        return view('profile/guard/update_profile', ['curr' => $curr, 'active_nav' => 'dashboard']);
    }

    public function post_basic_data()
    {
        helper('form');

        $rules = [
            'id_card' => 'max_size[id_card,1024]|ext_in[id_card,png,jpg,jpeg]|mime_in[id_card,image/png,image/jpg,image/jpeg]',
            'nama' => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return view('profile/guard/update_profile', ['validation' => $this->validator, 'curr' => $this->request->getPost(['email', 'nip', 'nama'])]);
        }

        $model = model(Guard::class);

        $img = $this->request->getFile('id_card');
        $data_to_update = [
            'nama' => $this->request->getPost('nama'),
        ];

        if ($img->isValid()) {
            if ($img->hasMoved()) return redirect()->to(base_url('dashboard/update-profile'))->with('error', 'Failed to upload ID card');
            
            $curr = $model->find(((array)json_decode(session()->get('credentials')))['id'])['image_url'];

            $name = $img->getRandomName();
            new File(WRITEPATH . 'uploads/' . $img->store('guard_profile', $name));
            $data_to_update['image_url'] = $name;

            try {
                unlink(WRITEPATH . 'uploads/guard_profile/' . $curr);
            } catch (\Throwable $th) {}
        }
        
        $model->update(((array)json_decode(session()->get('credentials')))['id'], $data_to_update);

        return redirect()->to(base_url('guard/dashboard/update-profile'))->with('success', 'Data updated successfully');
    }

    public function post_update_nip()
    {
        helper('form');

        $rules = [
            'nip' => 'required|max_length[50]',
            'confirm_password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('profile/guard/update_profile', ['validation' => $this->validator, 'curr' => $this->request->getPost(['email', 'nip', 'nama'])]);
        }

        $model = model(Guard::class);
        $curr = $model->find(((array)json_decode(session()->get('credentials')))['id']);

        if (!password_verify($this->request->getPost('confirm_password') ?? '', $curr['password'])) {
            return redirect()->to(base_url('guard/dashboard/update-profile'))->with('error_nip', 'Invalid password');
        }

        $model->update(((array)json_decode(session()->get('credentials')))['id'], [
            'nip' => $this->request->getPost('nip'),
        ]);

        return redirect()->to(base_url('guard/dashboard/update-profile'))->with('success', 'Data updated successfully');
    }

    public function post_update_email()
    {
        helper('form');

        $rules = [
            'email' => 'required|valid_email|is_unique[guards.email]',
            'confirm_password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('profile/guard/update_profile', ['validation' => $this->validator, 'curr' => $this->request->getPost(['email', 'nip', 'nama'])]);
        }

        $model = model(Guard::class);
        $curr = $model->find(((array)json_decode(session()->get('credentials')))['id']);

        if (!password_verify($this->request->getPost('confirm_password') ?? '', $curr['password'])) {
            return redirect()->to(base_url('guard/dashboard/update-profile'))->with('error_email', 'Invalid password');
        }

        $model->update(((array)json_decode(session()->get('credentials')))['id'], [
            'email' => $this->request->getPost('email'),
            'verified_at' => null,
        ]);

        $this->verify_email($this->request->getPost('email'), 'students');

        session()->set('credentials', json_encode([
            'id' => $curr['id'],
            'nama' => $curr['nama'],
            'is_admin' => $curr['is_admin'],
            'email' => $this->request->getPost('email'),
            'role' => 'guard',
        ]));

        return redirect()
            ->to(base_url('guard/dashboard/update-profile'))
            ->with('success', 'Data updated successfully')
            ->with('email', 'Please check your mailbox to verify this email address');
    }
}
