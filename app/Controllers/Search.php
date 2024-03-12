<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExitsAproved;
use App\Models\Guard;
use App\Traits\FormatDate;

class Search extends BaseController
{
    use FormatDate;

    private function parse_query_string()
    {
        $search_for = 'students.nama';
        $date_range = 'date(out_of_parkings.created_at)';

        switch ($this->request->getGet('search_for')) {
            case 'brand':
                $search_for = 'vehicles.nama';
                break;
            case 'plat':
                $search_for = 'vehicles.plat';
                break;
            case 'nim':
                $search_for = 'students.nim';
                break;
            case 'guard':
                $search_for = 'guards.nama';
                break;
        }

        if($this->request->getGet('date_range') === 'aproved_at') {
            $date_range = 'date(exits_aproved.aproved_at)';
        }

        return [
            [$search_for, $this->request->getGet('keywords')],
            [$date_range, [$this->request->getGet('start_date'), $this->request->getGet('end_date')]]
        ];
    }

    private function for_admin()
    {
        $this->parse_query_string();
        
        $condition = $this->parse_query_string();
        
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
            ->like($condition[0][0], $condition[0][1], 'both')
            ->where($condition[1][0].' >=', $condition[1][1][0])
            ->where($condition[1][0].' <=', $condition[1][1][1])
            ->findAll();
        
        return view('dashboard/guard', ['exits_aproved' => $exits_aproved, 'ctx' => $this, 'active_nav' => 'dashboard']);
    }

    private function for_guard()
    {
        $condition = $this->parse_query_string();
        
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
            ->where('exits_aproved.id_guard', ((array)json_decode(session()->get('credentials')))['id'])
            ->like($condition[0][0], $condition[0][1], 'both')
            ->where($condition[1][0].' >=', $condition[1][1][0])
            ->where($condition[1][0].' <=', $condition[1][1][1])
            ->findAll();
        
        return view('dashboard/guard', ['exits_aproved' => $exits_aproved, 'ctx' => $this, 'active_nav' => 'dashboard']);
    }

    private function for_student()
    {
        $condition = $this->parse_query_string();
        
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
            ->like($condition[0][0], $condition[0][1], 'both')
            ->where($condition[1][0].' >=', $condition[1][1][0])
            ->where($condition[1][0].' <=', $condition[1][1][1])
            ->findAll();
        
        return view('parking/student/aproved_get_out_list', ['exits_aproved' => $exits_aproved, 'ctx' => $this, 'active_nav' => 'dashboard']);
    }

    public function index()
    {
        $current = ((array)json_decode(session()->get('credentials')));

        if($current['role'] === 'student') return $this->for_student();
        if($current['role'] === 'guard') {
            $tmp = model(Guard::class);
            $tmp = $tmp->find($current['id']);

            if((int)$tmp['is_admin'] === 1) return $this->for_admin();
            return $this->for_guard();
        }
        return redirect()->to(base_url('404'));
    }
}
