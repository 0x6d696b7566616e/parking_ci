<?php

namespace App\Controllers\UpdateProfile;

use App\Controllers\BaseController;
use App\Models\Student as ModelStudent;
use App\Traits\EmailVerification;
use CodeIgniter\Files\File;

class StudentUpdateProfile extends BaseController
{
    use EmailVerification;

    public function index()
    {
        helper('form');
        $model = model(ModelStudent::class);
        $curr = $model->find(((array)json_decode(session()->get('credentials')))['id']);
        return view('profile/student/update_profile', ['curr' => $curr, 'active_nav' => 'dashboard']);
    }

    public function post_basic_data()
    {
        helper('form');

        $rules = [
            'id_card' => 'max_size[id_card,1024]|ext_in[id_card,png,jpg,jpeg]|mime_in[id_card,image/png,image/jpg,image/jpeg]',
            'nama' => 'required|max_length[50]',
            'prodi' => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return view('profile/student/update_profile', ['validation' => $this->validator, 'curr' => $this->request->getPost(['email', 'nim', 'nama', 'prodi'])]);
        }

        $model = model(ModelStudent::class);

        $img = $this->request->getFile('id_card');
        $data_to_update = [
            'nama' => $this->request->getPost('nama'),
            'prodi' => $this->request->getPost('prodi'),
        ];

        if ($img->isValid()) {
            if ($img->hasMoved()) return redirect()->to(base_url('dashboard/update-profile'))->with('error', 'Failed to upload ID card');
            
            $curr = $model->find(((array)json_decode(session()->get('credentials')))['id'])['image_url'];
            
            $name = $img->getRandomName();
            new File(WRITEPATH . 'uploads/' . $img->store('id_cards', $name));
            $data_to_update['image_url'] = $name;

            try {
                unlink(WRITEPATH . 'uploads/id_cards/' . $curr);
            } catch (\Throwable $th) {}
        }
        
        $model->update(((array)json_decode(session()->get('credentials')))['id'], $data_to_update);

        return redirect()->to(base_url('dashboard/update-profile'))->with('success', 'Data updated successfully');
    }

    public function post_update_nim()
    {
        helper('form');

        $rules = [
            'nim' => 'required|max_length[10]',
            'confirm_password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('profile/student/update_profile', ['validation' => $this->validator, 'curr' => $this->request->getPost(['email', 'nim', 'nama', 'prodi'])]);
        }

        $model = model(ModelStudent::class);
        $curr = $model->find(((array)json_decode(session()->get('credentials')))['id']);

        if (!password_verify($this->request->getPost('confirm_password') ?? '', $curr['password'])) {
            return redirect()->to(base_url('dashboard/update-profile'))->with('error_nim', 'Invalid password');
        }

        $model->update(((array)json_decode(session()->get('credentials')))['id'], [
            'nim' => $this->request->getPost('nim'),
        ]);

        return redirect()->to(base_url('dashboard/update-profile'))->with('success', 'Data updated successfully');
    }

    
    public function post_update_email()
    {
        helper('form');

        $rules = [
            'email' => 'required|valid_email|is_unique[students.email]',
            'confirm_password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('profile/student/update_profile', ['validation' => $this->validator, 'curr' => $this->request->getPost(['email', 'nim', 'nama', 'prodi'])]);
        }

        $model = model(ModelStudent::class);
        $curr = $model->find(((array)json_decode(session()->get('credentials')))['id']);

        if (!password_verify($this->request->getPost('confirm_password') ?? '', $curr['password'])) {
            return redirect()->to(base_url('dashboard/update-profile'))->with('error_email', 'Invalid password');
        }

        $model->update(((array)json_decode(session()->get('credentials')))['id'], [
            'email' => $this->request->getPost('email'),
            'verified_at' => null,
        ]);

        $this->verify_email($this->request->getPost('email'), 'students');

        session()->set('credentials', json_encode([
            'id' => $curr['id'],
            'nama' => $curr['nama'],
            'is_admin' => false,
            'email' => $this->request->getPost('email'),
            'role' => 'student',
        ]));

        return redirect()
            ->to(base_url('dashboard/update-profile'))
            ->with('success', 'Data updated successfully')
            ->with('email', 'Please check your mailbox to verify this email address');
    }
}
