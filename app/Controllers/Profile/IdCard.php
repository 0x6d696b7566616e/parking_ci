<?php

namespace App\Controllers\Profile;

use App\Controllers\BaseController;
use App\Models\Guard;

class IdCard extends BaseController
{
    public function index()
    {
        $curr_user = ((array)json_decode(session()->get('credentials')));

        if($curr_user['role'] !== 'guard') {
            $img_url = model('App\Models\Student')->find($curr_user['id'])['image_url'];
            return $this->response->download(WRITEPATH . 'uploads/id_cards/' . $img_url, null);
        }

        $query_img = $this->request->getVar('query-img');
        return $this->response->download(WRITEPATH . 'uploads/id_cards/' . $query_img, null);
    }
    
    public function current_guard_id_card()
    {
        $curr_user = ((array)json_decode(session()->get('credentials')));

        if($curr_user['role'] === 'guard') {
            $img_url = model(Guard::class)->find($curr_user['id'])['image_url'];
            return $this->response->download(WRITEPATH . 'uploads/guard_profile/' . $img_url, null);
        }
        
        return false;
    }

    public function guard_id_card()
    {
        $img_url = $this->request->getVar('img-url');
        return $this->response->download(WRITEPATH . 'uploads/guard_profile/' . $img_url, null);
    }
}
