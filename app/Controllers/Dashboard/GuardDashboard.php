<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\ExitsAproved;
use App\Models\Guard;
use App\Traits\FormatDate;

class GuardDashboard extends BaseController
{
    use FormatDate;

    public function index()
    {
        $current = ((array)json_decode(session()->get('credentials')));
        $exits_aproved_model = model(ExitsAproved::class);
        
        $exits_aproved = $exits_aproved_model
            ->select("
                exits_aproved.id,
                exits_aproved.id_out_of_parking,
                exits_aproved.aproved_at,
                out_of_parkings.created_at,
                vehicles.plat,
                vehicles.nama as vehicle,
                students.nim,
                students.nama as student,
                guards.nama as guard
            ")
            ->join('out_of_parkings', 'exits_aproved.id_out_of_parking = out_of_parkings.id')
            ->join('vehicles', 'vehicles.id = out_of_parkings.id_vehicle')
            ->join('students', 'students.nim = vehicles.nim')
            ->join('guards', 'guards.id = exits_aproved.id_guard');

        $tmp = model(Guard::class);
        $tmp = $tmp->find($current['id']);
        
        if((int)$tmp['is_admin'] === 1) {
            $exits_aproved = $exits_aproved->findAll();
        } else {
            $exits_aproved = $exits_aproved
                ->where('exits_aproved.id_guard', ((array)json_decode(session()->get('credentials')))['id'])
                ->findAll();
        }
        
        return view('dashboard/guard', ['exits_aproved' => $exits_aproved, 'ctx' => $this, 'active_nav' => 'dashboard']);
    }
}
