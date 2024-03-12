<?php

namespace App\Controllers\Parking\Guard;

use App\Controllers\BaseController;
use App\Models\ExitsAproved;
use CodeIgniter\API\ResponseTrait;

class AprovedRequestToGetOut extends BaseController
{
    use ResponseTrait;

    public function scan_barcode()
    {
        return view('parking/guard/scan');
    }

    public function aproved()
    {        
        $decoded = $this->request->getVar('decoded');
        $aproved_at = $this->request->getVar('aproved_at');
        $is_valid = $this->validateData(['decoded' => $decoded, 'aproved_at' => $aproved_at], [
            'decoded' => 'required|decimal|min_length[0]',
            'aproved_at' => 'required|valid_date[Y-m-d H:i:s]'
        ]);
        if(!$is_valid) return $this->respond(['status' => 'error', 'message' => 'Bad Request'], 403, 'error');
        if($decoded < 1) return $this->respond(['status' => 'error', 'message' => 'Bad Request'], 403, 'error');

        try {            
            $exits_aproved_model = model(ExitsAproved::class);
            if(!empty($exits_aproved_model->where('id_out_of_parking', $decoded)->first())) return $this->respond(['status' => 'warning', 'message' => 'This data has been aproved'], 403, 'warning');
            
            $exits_aproved_model->save([
                'id_guard' => ((array)json_decode(session()->get('credentials')))['id'],
                'id_out_of_parking' => $decoded,
                'aproved_at' => $aproved_at
            ]);

            return $this->respond(['status' => 'success', 'message' => 'Success Aproved'], 201, 'success');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->respond(['status' => 'error', 'message' => 'Server Error'], 500, 'error');
        }
    }
}
