<?php
    namespace App\Controllers\Auth;

    use CodeIgniter\Exceptions\PageNotFoundException;
    use App\Controllers\BaseController;
    use App\Models\UserModel;
    use DateTime;

    class LoginController extends BaseController
    {
        protected $user;
        public function __construct()
        {
            $this->user = new UserModel();
        }

        public function index() 
        {
            return view('auth/login');
        }
        
public function auth() 
        {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            $res = array();

            $user = $this->user->getData($username);
            if (empty($username) || empty($password)) respondAndDie(0, 'Username dan Password dibutuhkan!');
            if (!empty($user)) {
                if ($password === $user['password']) {
                    setSession('id', $user['id']);
                    setSession('username', $user['username']);
                    $redirecturl = getURL('products');
                    $res = [
                        'success' => 1,
                        'msg' => 'Login Berhasil',
                        'redirecturl' => $redirecturl
                    ];
                } else {
                    $res = [
                        'success' => 0,
                        'msg' => 'Login Gagal, pastikan username dan password benar!',
                    ];
                }
            } else {
                $res = [
                    'success' => 0,
                    'msg' => 'User tidak terdaftar'
                ];
            }
            $res['csrfToken'] = csrf_hash();
            echo json_encode($res);
        }

        public function logout(){
            destroySession();
            return redirect()->to('login');
        }
    }
?>