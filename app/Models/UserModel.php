<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    function __construct()
    {
        $this->session  = \Config\Services::session();
        $this->db       = \Config\Database::connect();
        $this->setting  = new \App\Models\SettingModel();
        $this->paypara  = new \App\Libraries\Paypara();
        $this->error    = new \App\Libraries\Error();
        $this->secure   = new \App\Models\SecureModel();
    }
    public function check($param, $value, $current = "")
    {
        return !empty($param) && !empty($value) ? $this->db->query("select * from user where " . $param . "=" . $this->db->escape($value) . " and isDelete<>1 " . (!empty($current) ? " and " . $param . "<>" . $this->db->escape($current) : null))->getResult() : [];
    }
    public function detail($id)
    {
        return $this->db->query("select *, DATE_FORMAT(user_create_time, '%d.%m.%y %H:%i:%s') as user_create_time, DATE_FORMAT(user_last_login, '%d.%m.%y %H:%i:%s') as user_last_login from user where " . (!isMd5($id) ? "id='" . $id . "'" : "hash_id='" . $id . "'"));
    }
    public function role($id)
    {
        return $this->db->query("select * from user_role where id='" . $id . "'");
    }
    public function activity()
    {
        return $this->db->query("update log_user_login set lastActivitiy=NOW() where token='" . $this->secure->getToken() . "' and user_id=" . userId);
    }
    public function saveData($data)
    {
        $perm_site_ids = "";
        if (is_array($data["perm_site"])) {
            foreach ($data["perm_site"] as $perm_site) {
                $perm_site_ids .= $perm_site . ",";
            }
        }
        $this->db->query("insert into user set
                        perm_site			='" . rtrim($perm_site_ids, ",") . "',
                        user_create_time    =NOW(),
                        email				='" . $data['email'] . "',
                        user_name			='" . $data['user_name'] . "',
                        user_pass_hash		='" . md5($data['user_pass']) . "',
                        role_id			    ='" . $data['role_id'] . "'
                    ");
        $this->error->dbException($this->db->error()) != true ? die() : null;
        $this->db->query("update user set hash_id='" . md5($this->db->insertID()) . "' where id='" . $this->db->insertID() . "'");
        return $data["process"] == "update" ? $data['id'] : $this->db->insertID();
    }
    public function saveRole($data)
    {
        if ($data["id"] > 0) {
            $fields = $this->db->getFieldNames('user_role');
            foreach ($fields as $field) {
                if ($field != "id") $colsReset   .= "`" . $field . "`='0',";
            }
            $this->db->query("update user_role set " . rtrim($colsReset, ",") . " where id='" . $data["id"] . "'");
        }
        foreach ($data as $key => $value) {
            if ($this->db->fieldExists($key, 'user_role')) {
                if ($key != "id") $cols .= "`" . $key . "`=" . $this->db->escape($value) . ",";
            }
        }
        $this->db->query(($data["id"] > 0 ? "update" : "insert into") . " user_role set " . rtrim($cols, ",") . ($data["id"] > 0 ? " where id='" . $data["id"] . "'" : null));
        $this->error->dbException($this->db->error()) != true ? die() : null;
    }
    public function updateData($id, $data)
    {


        $this->db->query("update user set " . ($data['dataName'] == "user_pass" ? "user_pass_hash='" . md5($data['dataValue']) . "'" : $data['dataName'] . "='" . $data['dataValue'] . "'") . " where " . (!isMd5($id) ? "id='" . $id . "'" : "hash_id='" . $id . "'"));
        $this->error->dbException($this->db->error()) != true ? die() : null;
    }
    public function datatable($dataStart = 0, $dataEnd = 99999999, $postData = [])
    {
        $searchArray = explode("::", $postData["search"]["value"]);
        if ($searchArray[1] != "" && $searchArray[1] != "all") {
            $search = " and " . $searchArray[0] . "='" . $searchArray[1] . "'";
        } elseif ($searchArray[1] == "") {
            if (!empty($postData["search"]["value"]))  $search = " and (user_name LIKE '%" . $postData["search"]["value"] . "%')";
        }
        $setFilter = "";
        //if($postData["selectClient"]!="")   $setFilter .= " and site_id='".$postData["selectClient"]."'";
        //if($postData["isVip"]!="")          $setFilter .= " and isVip='".$postData["isVip"]."'";
        /*
            <th class="min-w-125px">KULLANICI</th>
            <th class="min-w-125px">YETKİ</th>
            <th class="min-w-125px">SON GİRİŞ</th>
            <th class="min-w-125px">2FA DOĞRULAMA</th>
            <th class="min-w-125px">OLUŞTURMA TARİHİ</th>
            <th class="text-end min-w-100px">İŞLEMLER</th>
        </tr>
        */
        if ($postData["is2fa"] != "")        $setFilter .= " and is2fa='" . $postData["is2fa"] . "' ";
        if ($postData["role_id"] != "")      $setFilter .= " and role_id='" . $postData["role_id"] . "' ";
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];
        if ($orderDir == "") $orderDir = "desc";
        else $orderDir = $orderDir;
        if ($orderCol == "") $orderCol = "id";
        if ($orderCol == 0) $orderCol = "user_name";
        if ($orderCol == 1) $orderCol = "role_id";
        if ($orderCol == 2) $orderCol = "DATE(user_last_login)";
        if ($orderCol == 3) $orderCol = "is2fa";
        if ($orderCol == 4) $orderCol = "DATE(user_create_time)";
        if (!empty($dataEnd)) $limit  = "limit " . $dataStart . ", " . $dataEnd . "";
        $x = $this->db->query("select *, DATE_FORMAT(user_create_time, '%d.%m.%y %H:%i:%s') as user_create_time, DATE_FORMAT(user_last_login, '%d.%m.%y %H:%i:%s') as user_last_login from user where isDelete='0' and id<>0 " . $setFilter . $search . " order by " . $orderCol . " " . $orderDir . " " . $limit);
        //$this->db->query("insert into log_query set query=".$this->db->escape($this->db->getLastQuery()));
        return $x;
    }
    public function sessiontable($dataStart = 0, $dataEnd = 99999999, $postData = [], $userId)
    {
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];
        if ($orderDir == "") $orderDir = "desc";
        else $orderDir = $orderDir;
        if ($orderCol == "") $orderCol = "id";
        if ($orderCol == 0) $orderCol = "id";
        if (!empty($dataEnd)) $limit  = "limit " . $dataStart . ", " . $dataEnd . "";
        $x = $this->db->query("select *, DATE_FORMAT(lastActivitiy, '%d.%m.%y %H:%i:%s') as lastActivitiyFix from log_user_login where user_id='" . decodeUserId($userId) . "' order by " . $orderCol . " " . $orderDir . " " . $limit);
        return $x;
    }
    public function datatableRole($dataStart = 0, $dataEnd = 99999999, $postData = [])
    {
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];
        if ($orderDir == "") $orderDir = "desc";
        else $orderDir = $orderDir;
        if ($orderCol == "") $orderCol = "id";
        if ($orderCol == 0) $orderCol = "id";
        if (!empty($dataEnd)) $limit  = "limit " . $dataStart . ", " . $dataEnd . "";
        $x = $this->db->query("select *, @id:=id,
        @totalUser  := (select COUNT(id) as totalUser from user where isDelete<>1 and role_id=@id) as totalUser
        from user_role where isDelete='0' and id<>0 order by " . $orderCol . " " . $orderDir . " " . $limit);
        return $x;
    }
}