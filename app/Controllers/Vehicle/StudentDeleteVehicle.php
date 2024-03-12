<?php

namespace App\Controllers\Vehicle;

use App\Controllers\BaseController;

class StudentDeleteVehicle extends BaseController
{
    public function index($id)
    {
        $student_model = model(Student::class);
        $vehicle_model = model(Vehicle::class);

        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);
        $vehicle_model->where('id', $id)->where('nim', $student['nim'])->delete();

        return redirect()->to('dashboard/vehicles')->with('success', 'Vehicle deleted successfully');
    }
}
