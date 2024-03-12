<?php

namespace App\Controllers\Vehicle;

use App\Controllers\BaseController;
use App\Models\Student;
use App\Models\Vehicle;

class StudentVehicle extends BaseController
{
    public function index()
    {
        $student_model = model(Student::class);
        $vehicle_model = model(Vehicle::class);

        $student = $student_model->find(((array)json_decode(session()->get('credentials')))['id']);
        $vehicles = $vehicle_model->where('nim', $student['nim'])->findAll();

        return view('vehicle/student/vehicles', ['active_nav' => 'vehicles', 'vehicles' => $vehicles]);
    }
}
