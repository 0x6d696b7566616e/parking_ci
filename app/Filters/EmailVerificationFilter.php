<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class EmailVerificationFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        
        $curr = ((array)json_decode(session()->get('credentials')));
        
        switch ($curr['role']) {
            case 'student':
                $model = model(Student::class);

                $data = $model->find($curr['id']);

                if(empty($data['verified_at'])) return redirect()->to(base_url('verify-your-email'));
                return;

            case 'guard':
                $model = model(Guard::class);

                $data = $model->find($curr['id']);

                if(empty($data['verified_at'])) return redirect()->to(base_url('verify-your-email'));
                return;
            
            default:
                session()->destroy();
                return redirect()->to(base_url(403));
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
