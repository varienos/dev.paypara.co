<?php

namespace App\Libraries;

class Error
{
    protected $db = "";
    function __construct()
    {
        $this->db      = \Config\Database::connect();
    }
    public function string($flag, $controller, $method)
    {
        $data = getString($flag, $controller, $method);
        return ["status" => false, "id" => $data->id, "error" => ($data->string != "" ? $data->string : $data->flag)];
    }
    public function dbException($error)
    {
        if (!\is_array($error)) {
            return true;
        } elseif ($error['code'] == 0) {
            return true;
        } else {
            $this->db->save_queries = TRUE;
            $str = $this->db->getLastQuery();
            $this->db->query("insert into log_mysql_error set code='" . $error['code'] . "',error=" . $this->db->escape($error['message']) . ", query=" . $this->db->escape($str) . ", jsonData=" . $this->db->escape(json_encode($error)) . ", timestamp=NOW()");
            return $this->response->setJSON(json_encode($error, JSON_NUMERIC_CHECK));
            die();
        }
    }
}