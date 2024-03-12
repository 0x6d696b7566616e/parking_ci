<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ErrorPage extends BaseController
{
    public function unauthorize()
    {
        return view('error_responses/403');
    }

    public function notfound()
    {
        return view('error_responses/404');
    }

    public function server_error()
    {
        return view('error_responses/500');
    }
}
