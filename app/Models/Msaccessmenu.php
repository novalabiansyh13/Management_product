<?php

namespace App\Models;

use CodeIgniter\Model;

class Msaccessmenu extends Model
{
    protected $table = 'msaccessmenu';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }

    public function AccessCheck($menuid, $usergroupid, $componentid)
    {
        return $this->builder
            ->where('menuid', $menuid)
            ->where('usergroupid', $usergroupid)
            ->where('componentid', $componentid);
    }

    public function deleteUsergroup($usergroupid)
    {
        return $this->builder->delete(['usergroupid' => $usergroupid]);
    }

    public function addAccess($data)
    {
        return $this->builder->insert($data);
    }

    public function getByGroupMenuid($groupid, $menuid)
    {
        return $this->builder
            ->where('usergroupid', $groupid)
            ->where('componentid', 1)
            ->where('menuid', $menuid)->get()->getRowArray();
    }

    public function getByComponentGroupMenuid($componentid, $groupid, $menuid)
    {
        return $this->builder
            ->where('usergroupid', $groupid)
            ->where('menuid', $menuid)
            ->where('componentid', $componentid)
            ->get()->getRowArray();
    }

    public function hapus($id)
    {
        return $this->builder->delete(['id' => $id]);
    }

    public function getAccessUser($userid, $menuid)
    {
        return $this->builder
            ->where("usergroupid IN (
                SELECT
                    accgroup.usergroupid
                FROM msaccessgroup as accgroup
                WHERE accgroup.userid = $userid
            )")
            ->where('menuid', $menuid)
            ->get()
            ->getResultObject();
    }

    public function getSpecificAccessUser($userid, $menuid, $componentid)
    {
        return $this->builder
            ->where("usergroupid IN (
                SELECT
                    accgroup.usergroupid
                FROM msaccessgroup as accgroup
                WHERE accgroup.userid = $userid
            )")
            ->where('menuid', $menuid)
            ->where('componentid', $componentid)
            ->get()->getResultObject();
    }
}

?>