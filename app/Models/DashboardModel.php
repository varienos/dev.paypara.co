<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    function __construct()
    {
        $this->session             = \Config\Services::session();
        $this->db                  = \Config\Database::connect();
        $this->settings             = new \App\Models\SettingsModel();
        $this->paypara          = new \App\Libraries\Paypara();
        $this->error              = new \App\Libraries\Error();
    }
}