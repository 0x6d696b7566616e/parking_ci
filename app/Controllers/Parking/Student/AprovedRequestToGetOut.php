<?php

namespace App\Controllers\Parking\Student;

use App\Controllers\BaseController;
use App\Models\ExitsAproved;
use App\Traits\FormatDate;

class AprovedRequestToGetOut extends BaseController
{
    use FormatDate;

    public function aproved_request_list()
    { 
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
            ->join('guards', 'guards.id = exits_aproved.id_guard')
            ->where('students.id', ((array)json_decode(session()->get('credentials')))['id'])
            ->paginate(20);
        
        return view('parking/student/aproved_get_out_list', ['exits_aproved' => $exits_aproved, 'paging' => $exits_aproved_model->pager, 'ctx' => $this, 'active_nav' => 'aproved-list']);
    }

    public function aproved_request($id_request)
    {
        $curr_user = ((array)json_decode(session()->get('credentials')));

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
                students.image_url,
                students.nama as student,
                guards.nama as guard,
                guards.nip as nip,
                guards.image_url as guard_image_url
            ")
            ->join('out_of_parkings', 'exits_aproved.id_out_of_parking = out_of_parkings.id')
            ->join('vehicles', 'vehicles.id = out_of_parkings.id_vehicle')
            ->join('guards', 'guards.id = exits_aproved.id_guard')
            ->join('students', 'students.nim = vehicles.nim')
            ->where('out_of_parkings.id', $id_request)
            ->first();

        return view('parking/aproved_get_out', [
            'data' => $exits_aproved,
            'ctx' => $this,
            'img_url' => $curr_user['role'] !== 'guard' ? base_url('id-card') : base_url('id-card?query-img='.$exits_aproved['image_url']),
            'img_guard_url' => base_url('guard-id-card?img-url='.$exits_aproved['guard_image_url'])
        ]);
    }
}
