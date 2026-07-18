<?php

namespace App\Models;

use CodeIgniter\Model;

class Msusergroup extends Model
{
    protected $table = "msusergroup as a";
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }

    public function searchable()
    {
        return [
            null,
            "groupname",
            null,
            null,
        ];
    }

    public function getTable()
    {
        return $this->builder
            ->select('a.groupname, a.groupid, u.name as createdby, a.createddate')
            ->join('msuser as u', 'u.userid=a.createdby');
    }

    public function getOne($groupid)
    {
        $x = $this->builder;
        if ($groupid != '') $x->where('a.groupid', $groupid);
        return $x->get()->getRowArray();
    }

    public function store($data)
    {
        return $this->builder->insert($data);
    }

    public function edit($data, $id)
    {
        return $this->builder->update($data, ['groupid' => $id]);
    }

    public function destroy($groupid)
    {
        return $this->builder->delete(['groupid' => $groupid]);
    }

    public function getSelect($search, $notin = [0])
    {
        return $this->builder
            ->like('lower(groupname)', strtolower($search))
            ->whereNotIn('groupid', $notin)
            ->limit(15)
            ->get()->getResultArray();
    }

    public function getByName($name)
    {
        return $this->builder
            ->where('groupname', $name)
            ->limit(1)
            ->get()->getRowArray();
    }
}

?>