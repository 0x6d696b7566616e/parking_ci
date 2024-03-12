<?php

namespace App\Controllers\Vehicle;

use App\Controllers\BaseController;

class StudentUpdateVehicle extends BaseController
{
    public function index($id)
    {        
        helper('form');

        $student_model = model(Student::class);
        $vehicle_model = model(Vehicle::class);

        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);
        $vehicle = $vehicle_model->where('id', $id)->where('nim', $student['nim'])->first();
        
        return view('vehicle/student/update_vehicle', ['active_nav' => 'vehicles', 'curr' => $vehicle]);
    }

    
    public function post_update_vehicle($id)
    {
        helper('form');        

        $posts = $this->request->getPost(['nama', 'plat']);
        $is_valid = $this->validateData($posts, [
            'nama' => 'required|max_length[100]',
            'plat' => 'required|max_length[13]',
        ]);

        if(!$is_valid) return view('vehicle/student/update_vehicle', ['active_nav' => 'vehicles', 'validation' => $this->validator, 'curr' => array_merge($posts, ['id' => $id])]);

        $vehicle_model = model(Vehicle::class);
        $student_model = model(Student::class);
        
        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);

        $is_exists = $vehicle_model->where('nim', $student['nim'])->where('plat', $posts['plat'])->first();
        
        if($is_exists) {
            $vehicle_model->where('nim', $student['nim'])->where('id', $id)->set(['nama' => $posts['nama']])->update();
            return redirect()->to(base_url('dashboard/update-vehicle/'.$id))->with('error', 'Plat number cant be updated, because already exists');
        }

        $vehicle_model->where('nim', $student['nim'])->where('id', $id)->set($posts)->update();
        return redirect()->to(base_url('dashboard/update-vehicle/'.$id))->with('success', 'Vehicle created successfully');
    }
}
