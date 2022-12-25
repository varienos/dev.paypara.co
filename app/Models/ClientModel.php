<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientModel extends Model
{
    function __construct()
    {
        $this->session 			= \Config\Services::session();
        $this->db      			= \Config\Database::connect();
        $this->setting 		    = new \App\Models\SettingModel();
        $this->paypara          = new \App\Libraries\Paypara();
        $this->error  			= new \App\Libraries\Error();
	}
	public function dataRemove($id)
	{
		$this->db->query("update site set isDelete='1', status='0' where id='".$id."'"); $this->error->dbException($this->db->error())!=true ? die() : null;
		$this->db->query("insert into logSys set
		`method`	='dataRemove()',
		`user_id`	='".$this->session->get('primeId')."',
		`data_id`	='".$id."',
		`timestamp` =NOW(),
		`ip` 		='".getClientIpAddress()."'
		");
		return true;
	}
    public function detail($id)
	{
    }
    public function clients()
	{
		return $this->db->query("select * from site where isDelete=0 and status='on'  order by site_name asc")->getResult(); $this->error->dbException($this->db->error())!=true ? die() : null;
	}
	public function dataSave($data)
	{
		if($data['id']=="0")
		{
			$sqlProcess	=	"insert into";
		}else{
			$sqlProcess	= "update";
			$sqlUpdate	= "where id='".$data['id']."'";
		}

		$this->db->query($sqlProcess." site set
		updateTime			=NOW(),
		".(strpos($data['api_key'],"***")===false?"api_key='".md5(trim($data['api_key']))."',":null)."
		".(strpos($data['api_key'],"***")===false?"api_key_pin='".substr(trim($data['api_key']),0,8)."',":null)."
		private_key			='".substr(md5(substr(trim($data['api_key']),0,8)),0,16)."',
		site_name			='".$data['site_name']."',
		status			    ='".$data['status']."'
		".$sqlUpdate);
		$this->error->dbException($this->db->error())!=true ? die() : null;
	}
    public function datatable($dataStart=0,$dataEnd=99999999,$postData=[])
	{
        $searchArray = explode("::",$postData["search"]["value"]);
        if($searchArray[1]!="" && $searchArray[1]!="all")
        {
            $search = " and ".$searchArray[0]."='".$searchArray[1]."'";
        }elseif($searchArray[1]==""){
            if(!empty($postData["search"]["value"]))
            {
                $search = " and (site_name LIKE '%".$postData["search"]["value"]."%' or id LIKE '%".$postData["search"]["value"]."%')";
            }
        }
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];
        if($orderDir=="")$orderDir ="desc"; else $orderDir=$orderDir;
        if($orderCol=="")$orderCol ="id";
		if($orderCol==0) $orderCol ="id";
        if($orderCol==1) $orderCol ="site_name";
		if($orderCol==3) $orderCol ="status";
        if(!empty($dataEnd))$limit  = "limit ".$dataStart.", ".$dataEnd."";
        $x = $this->db->query("select * from site where isDelete<>1 ".$search." order by ".$orderCol." ".$orderDir." ".$limit);
        $this->error->dbException($this->db->error())!=true ? die() : null;
        return $x;
	}
}