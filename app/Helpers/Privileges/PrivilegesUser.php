<?php

namespace App\Helpers\Privileges;

use App\Models\Msaccessmenu;

class PrivilegesUser
{

    static public $instance;

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = (new PrivilegesUser())->fetch();
        }

        return self::$instance;
    }

    public $userid;

    public $menuid;

    protected $accesses = [];

    public function __construct()
    {
        $this->userid = getSession('userid');
        $this->menuid = getSession('menuid');
    }

    public function fetch()
    {
        $this->accesses = (new Msaccessmenu())->getAccessUser(getSession('userid'), getSession('menuid'));

        return $this;
    }

    public function has($componentid)
    {
        if (!is_array($componentid)) $componentid = [$componentid];

        $isValid = false;
        foreach ($this->accesses as $access) {
            if (in_array($access->componentid, $componentid)) {
                $isValid = true;
                break;
            }
        }

        return $isValid;
    }
}
