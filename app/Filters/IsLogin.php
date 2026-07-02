<?php
    namespace App\Filters;
    use CodeIgniter\Filters\FilterInterface;
    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\ResponseInterface;

    class IsLogin implements FilterInterface
    {
        public function before(RequestInterface $request, $arguments = null)
        {
            if (!empty(getSession('userid'))) {
                return redirect()->to(base_url('products'));
            }
        }

        public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
        {
            // Do something here
        }
    }
?>