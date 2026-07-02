<?php

namespace App\Filters;

use App\Helpers\Privileges\PrivilegesUser;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class checkAccess implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty(getSession('userid'))) {
            return redirect()->to(base_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $privileges = PrivilegesUser::instance();
        if (!$privileges->has([COMVIEW])) {
            return redirect()->to(getURL('welcome'));
        }
    }
}

?>