<?php

namespace App\Models;

use Codeigniter\Model;

class Msaccessgroup extends Model
{
    protected $table = "msaccessgroup as a";
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
}

?>