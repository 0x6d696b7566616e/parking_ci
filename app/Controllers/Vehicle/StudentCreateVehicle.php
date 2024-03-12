<?php

namespace App\Controllers\Vehicle;

use App\Controllers\BaseController;
use App\Models\Student;
use App\Models\Vehicle;

class StudentCreateVehicle extends BaseController
{
    public function index()
    {        
        helper('form');
        return view('vehicle/student/create_vehicle', ['active_nav' => 'vehicles']);
    }

    public function post_create_vehicle()
    {
        helper('form');        

        $posts = $this->request->getPost(['nama', 'plat']);
        $is_valid = $this->validateData($posts, [
            'nama' => 'required|max_length[100]',
            'plat' => 'required|max_length[13]',
        ]);

        if(!$is_valid) return view('vehicle/student/create_vehicle', ['active_nav' => 'vehicles', 'validation' => $this->validator]);

        $vehicle_model = model(Vehicle::class);
        $student_model = model(Student::class);
        
        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);
        $is_exists = $vehicle_model->where('nim', $student['nim'])->where('plat', $posts['plat'])->first();
        
        if($is_exists) return redirect()->to(base_url('dashboard/create-vehicle'))->with('error', 'This vehicle already registered');

        $vehicle_model->save(array_merge(
            $posts,
            ['nim' => $student['nim']]
        ));

        return redirect()->to(base_url('dashboard/vehicles'))->with('success', 'Vehicle created successfully');
    }
}
