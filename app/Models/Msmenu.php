<?php

namespace App\Models;

use CodeIgniter\Model;

class Msmenu extends Model
{
    protected $table = 'msmenu as a';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }

    public function searchable()
    {
        return [
            null,
            "a.menuname",
            null,
            null,
            null,
            null,
            null
        ];
    }

    public function getMenu($masterid = '', $search = '')
    {
        $x = $this->builder
            ->select('a.menuid, a.menuname, master.menuname as mastername, master.menuid as masterid, a.menulink, a.menuicon, a.sequence')
            ->join('msmenu as master', 'master.menuid=a.masterid', 'left');
        if ($masterid != '') $x->where('a.masterid', $masterid);
        if ($search != '') {
            $searchable = $this->searchable();
            foreach ($searchable as $value) {
                if ($value != null) {
                    $x->orWhere("LOWER($value) LIKE '%" . strtolower($search) . "%'");
                }
            }
        }
        return $x;
    }

    public function getAllMenuByUser()
    {
        return $this->builder
            ->select('a.menuid, a.menulink, a.menuname, a.menuicon, a.sequence, master.menuname as mastername, master.menuid as masterid')
            ->join('msaccessmenu as accm', 'accm.menuid=a.menuid')
            ->join('msmenu as master', 'master.menuid=a.masterid', 'left')
            ->join('msusergroup as grp', 'grp.groupid=accm.usergroupid')
            ->join('msaccessgroup as accg', 'accg.usergroupid=grp.groupid')
            ->where('accm.componentid', 1)
            ->where('accg.userid', getSession('userid'))
            ->groupBy('accm.menuid')
            ->groupBy('a.menuid, master.menuname, master.menuid')
            ->orderBy('a.sequence', 'asc')->get()->getResultArray();
    }

    public function getSidebar()
    {
        return $this->builder
            ->select('a.menuid, a.menulink, a.menuname, a.menuicon')
            ->join('msaccessmenu as accm', 'accm.menuid=a.menuid')
            ->join('msusergroup as grp', 'grp.groupid=accm.usergroupid')
            ->join('msaccessgroup as accg', 'accg.usergroupid=grp.groupid')
            ->where('accm.componentid', 1)
            ->where('a.masterid is null')
            ->where('accg.userid', getSession('userid'))
            ->groupBy('accm.menuid')
            ->orderBy('a.sequence', 'asc')->get()->getResultArray();
    }

    public function checkMenu($masterid)
    {
        return $this->builder
            ->select('a.menuid, a.menulink, a.menuname, a.menunameind, a.menuicon')
            ->join('msaccessmenu as accm', 'accm.menuid=a.menuid')
            ->join('msusergroup as grp', 'grp.groupid=accm.usergroupid')
            ->join('msaccessgroup as accg', 'accg.usergroupid=grp.groupid')
            ->where('accm.componentid', 1)
            ->where('a.masterid', $masterid)
            ->where('accg.userid', getSession('userid'))
            ->groupBy('accm.menuid')
            ->groupBy('a.menuid')
            ->orderBy('a.sequence', 'asc');
    }

    public function getByUrl($link)
    {
        return $this->builder->where('lower(menulink)', strtolower($link))->get()->getRowArray();
    }

    public function getOne($menuid = '')
    {
        $x = $this->builder
            ->select('a.menuid, a.menuname, master.menuname as mastername, master.menuid as masterid, a.menulink, a.menuicon, a.sequence')
            ->join('msmenu as master', 'master.menuid=a.masterid', 'left');
        if ($menuid != '') {
            $x->where('a.menuid', $menuid);
        }
        return $x->get()->getRowArray();
    }
}
?>