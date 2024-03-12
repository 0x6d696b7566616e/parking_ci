<?php

namespace App\Controllers\Parking\Student;

use App\Controllers\BaseController;
use App\Models\ExitsAproved;
use App\Models\OutOfParking;
use App\Models\Student;
use App\Models\Vehicle;
use App\Traits\FormatDate;

class RequestToGetOut extends BaseController
{
    use FormatDate;
    
    public function index($id_request)
    {
        $out_of_parking = model(OutOfParking::class);
        $exits_aproved = model(ExitsAproved::class);
        
        if(!empty($exits_aproved->where('id_out_of_parking', $id_request)->first())) return redirect()->to(base_url('aproved-request/'.$id_request));
        
        $data = $out_of_parking
            ->select('out_of_parkings.id, out_of_parkings.created_at, vehicles.nama as vehicle, vehicles.plat, students.nama as student, students.nim, students.prodi')
            ->join('vehicles', 'vehicles.id = out_of_parkings.id_vehicle')
            ->join('students', 'students.nim = vehicles.nim')
            ->where('out_of_parkings.id', $id_request)
            ->where('students.id', ((array)json_decode(session()->get('credentials')))['id'])
            ->first();
        
        if(empty($data)) return redirect()->to(base_url('404'));

        return view('parking/student/request_to_get_out', ['data' => $data]);
    }

    public function delete_request_to_get_out($id_request)
    {
        $out_of_parking = model(OutOfParking::class);

        $student_model = model(Student::class);
        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);

        $data = $out_of_parking
            ->select('out_of_parkings.id')
            ->join('vehicles', 'vehicles.id = out_of_parkings.id_vehicle')
            ->where('out_of_parkings.id', $id_request)
            ->where('vehicles.nim', $student['nim'])
            ->first();

        if(empty($data)) return redirect()->to(base_url('dashboard/request-list'))->with('error', 'Data to delete is not found.');

        try {
            $out_of_parking->where('id', $id_request)->delete();
            
            return redirect()->to(base_url('dashboard/request-list'));
        } catch (\Throwable $th) {
            return redirect()->to(base_url('500'));
        }
    }

    public function request_to_get_out_list()
    {
        $out_of_parking = model(OutOfParking::class);
        $student_model = model(Student::class);
        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);
        
        $data = $out_of_parking
            ->select('out_of_parkings.id, out_of_parkings.created_at, vehicles.nama as vehicle, vehicles.plat')
            ->join('vehicles', 'vehicles.id = out_of_parkings.id_vehicle')
            ->join('exits_aproved', 'exits_aproved.id_out_of_parking = out_of_parkings.id', 'left')
            ->where('exits_aproved.id', null)
            ->where('vehicles.nim', $student['nim'])
            ->paginate(20);
        
        return view('parking/student/request_to_get_out_list', ['data' => $data, 'paging' => $out_of_parking->pager, 'ctx' => $this, 'active_nav' => 'request-list']);
    }

    public function request_to_get_out($id_vehicle)
    {
        $rule = [
            'created_at' => 'required|valid_date[Y-m-d H:i:s]'
        ];

        $is_valid = $this->validateData($this->request->getPost(), $rule);
        if(!$is_valid) return redirect()->to(base_url('dashboard/vehicles'))->with('error_get_out', 'Invalid date format');

        $out_of_parking = model(OutOfParking::class);
        $vehicle_model = model(Vehicle::class);
        $student_model = model(Student::class);

        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);
        $is_exists = $vehicle_model->where('nim', $student['nim'])->where('id', $id_vehicle)->first();

        if(!$is_exists) return redirect()->to(base_url('dashboard/vehicles'))->with('error_get_out', 'This vehicle is not registered');

        $out_of_parking->save([
            'id_vehicle' => $id_vehicle,
            'created_at' => $this->request->getPost('created_at')
        ]);

        return redirect()->to(base_url('dashboard/request-to-get-out/'.$out_of_parking->getInsertID()));
    }
}
