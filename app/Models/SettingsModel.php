<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    function __construct()
    {
        $this->session  = \Config\Services::session();
        $this->db       = \Config\Database::connect();
        $this->paypara  = new \App\Libraries\Paypara();
        $this->error    = new \App\Libraries\Error();
    }

    public function clientSelect()
    {
        return $this->db->query("select id,site_name from site where isDelete='0' order by site_name asc")->getResult();
    }

    public function dataUpdate($data)
    {
        $settings = $this->db->query("select * from settings")->getResult();

        foreach ($settings as $row) {
            if (isset($data[$row->name])) $val[$row->name] = $row->value;
        }

        foreach ($data as $key => $value) {
            $check = $this->db->query("select name from settings where name='" . $key . "'")->getRow();
            if ($check->name != "") {
                if (is_array($value)) {
                    $newValue = "";
                    foreach ($value as $id) {
                        $newValue .= $id . ",";
                    }

                    $value = rtrim($newValue, ",");
                }

                $this->db->query("update settings set value='" . $value . "' where name='" . $key . "'");
                unset($val[$key]);
            }
        }

        if (count($val) > 0) {
            foreach ($val as $key => $value) {
                $this->db->query("update settings set value='' where name='" . $key . "'");
            }
        }
    }

    public function updateErrorStrings($data)
    {
        $settings = $this->db->query("select * from settings")->getResult();
        $dbErrors = null;
        for($i=0;$i<count($data['id']);$i++)
        {
            try 
            {
                $this->db->query("update def_string set custom_id='".$data['custom_id'][$i]."', string=".$this->db->escape($data['string'][$i])." where id='".$data['id'][$i]."'");
                $error     = $this->db->error();
                $dbErrors  = !empty($error['message'])?$this->db->error():$dbErrors;
                    
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                $dbErrors = $e;
            }
            
        }
    }
}