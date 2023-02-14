<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportsModel extends Model
{
    function __construct()
    {
      $this->db       = \Config\Database::connect();
      $this->session  = \Config\Services::session();
    }

    public function allFirms()
    {
      $db = \Config\Database::connect();
      return $db->query("SELECT id, site_name AS name FROM site WHERE status = 'on' AND isDelete = 0")->getResultArray();
    }

    public function userFirms()
    {
      $db = \Config\Database::connect();

      return $db->query("
        SELECT site.id, site.site_name AS name
        FROM user
        JOIN site ON FIND_IN_SET(site.id, user.perm_site) > 0
        WHERE user.id = " . $this->session->get('userId')
      )->getResultArray();
    }
}