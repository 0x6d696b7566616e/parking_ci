<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Guard;

class GuardManagement extends BaseController
{
    public function index()
    {
        $model = model(Guard::class);        
        return view('guard_management/guard_list', ['active_nav' => 'guard-list', 'data' => $model->findAll()]);
    }

    public function activate($id)
    {
        $model = model(Guard::class);
        $model->update($id, ['is_active' => true]);
        return redirect()->to(base_url('guard'));
    }

    public function inactivate($id)
    {
        $model = model(Guard::class);
        $model->update($id, ['is_active' => false]);
        return redirect()->to(base_url('guard'));
    }
}
