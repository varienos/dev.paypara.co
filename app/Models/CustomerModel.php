<?php
namespace App\Models;
use CodeIgniter\Model;
class CustomerModel extends Model
{
    function __construct()
    {
        $this->session 			= \Config\Services::session();
        $this->db      			= \Config\Database::connect();
        $this->setting 		    = new \App\Models\SettingModel();
        $this->paypara          = new \App\Libraries\Paypara();
        $this->error  			= new \App\Libraries\Error();
	}
    public function detail($id)
	{
		return $this->db->query("
        select
        *,
        @id             :=  id,
        @gamer_site_id  :=  gamer_site_id,
        @site_id        :=  site_id,
        @clientName     := (select site_name from site where id=@site_id) as clientName,
        @totalProcess   := (select COUNT(id) as totalProcess from finance where status='onaylandı' and gamer_site_id=@gamer_site_id) as totalProcess,
        @totalRejectProcess   := (select COUNT(id) as totalRejectProcess from finance where status='reddedildi' and gamer_site_id=@gamer_site_id) as totalRejectProcess,
        @totalDepositProcess   := (select COUNT(id) as totalDepositProcess from finance where status='onaylandı' and request='deposit' and gamer_site_id=@gamer_site_id) as totalDepositProcess,
        @totalWithdrawProcess   := (select COUNT(id) as totalWithdrawProcess from finance where status='onaylandı' and request='withdraw' and gamer_site_id=@gamer_site_id) as totalWithdrawProcess,
        @totalWithdraw  := (select SUM(price) as totalWithdraw from finance where status='onaylandı' and request='withdraw' and gamer_site_id=@gamer_site_id) as totalWithdraw,
        @totalDeposit   := (select SUM(price) as totalDeposit from finance where status='onaylandı' and request='deposit' and gamer_site_id=@gamer_site_id) as totalDeposit,
        @lastProcess    := (select DATE_FORMAT(update_time,'%d %b %Y') from finance where gamer_site_id=@gamer_site_id order by update_time desc limit 1) as lastProcess,
        @firstProcess    := (select DATE_FORMAT(update_time,'%d %b %Y') from finance where gamer_site_id=@gamer_site_id order by update_time asc limit 1) as firstProcess
        from site_gamer
        where isDelete='0' and id='".$id."'");
	}
	public function saveData($data)
	{
		if($data['id']==0)
		{
			$sqlProcess	=	"insert into";
		}elseif($data['id']>0){
			$sqlProcess	= "update";
			$sqlUpdate	= "where id='".$data['id']."'";
		}
		$perm_site_ids = "";
		if(is_array($data["perm_site"]))
		{
			foreach($data["perm_site"] as $perm_site)
			{
				$perm_site_ids .= $perm_site.",";
			}
		}
        $this->db->query("insert into log_query set query=".$this->db->escape(json_encode($data)));
		$dataOld = $this->db->query("select * from account where id='".$data['id']."'")->getRowArray();
		$dataOld = is_array($dataOld) ? $dataOld : array();
		$this->db->query("insert into logSys set
		`method`	='formPaparaAccountUpdate()',
		`user_id`	='".$this->session->get('primeId')."',
		`data_id`	='".$data['id']."',
		`timestamp` =NOW(),
		`ip` 		='".getClientIpAddress()."',
		`dataOld`	=".$this->db->escape(json_encode($dataOld)).",
		`dataNew`	=".$this->db->escape(json_encode($data))."
		");
		$this->db->query($sqlProcess." account set
		updateTime			=NOW(),
		perm_site			='".rtrim($perm_site_ids,",")."',
		match_limit			='".$data['match_limit']."',
        dataType			='".$data['dataType']."',
		limitDeposit        ='".$data['limitDeposit']."',
		status				='".$data['status']."',
		limit_min			='".$data['limit_min']."',
		limit_max			='".$data['limit_max']."',
		account_name		='".$data['account_name']."',
		account_number		='".$data['account_number']."'
		".$sqlUpdate);
		$this->error->dbException($this->db->error())!=true ? die() : null;
		return $data["process"]=="update" ? $data['id'] : $this->db->insertID();
	}
	public function datatable($dataStart=0,$dataEnd=99999999,$postData=[])
	{
        $searchArray = explode("::",$postData["search"]["value"]);
        if($searchArray[1]!="" && $searchArray[1]!="all")
        {
            $search = " and ".$searchArray[0]."='".$searchArray[1]."'";
        }elseif($searchArray[1]==""){
            if(!empty($postData["search"]["value"]))  $search = " and (gamer_nick LIKE '%".$postData["search"]["value"]."%' or gamer_name LIKE '%".$postData["search"]["value"]."%')";
        }
        //selectClient: 1
        //isVip: 0
        //deposit: on
        //withdraw: on
        $setFilter = "";
        if($postData["selectClient"]!="") $setFilter .= " and site_id='".$postData["selectClient"]."'";
        if($postData["isVip"]!="") $setFilter .= " and isVip='".$postData["isVip"]."'";
        if($postData["deposit"]!="") $setFilter .= " and deposit='".$postData["deposit"]."'";
        if($postData["withdraw"]!="") $setFilter .= " and withdraw='".$postData["withdraw"]."'";
        $orderCol = $postData["order"][0]["column"];
        $orderDir = $postData["order"][0]["dir"];
        if($orderDir=="")$orderDir ="desc"; else $orderDir=$orderDir;
        if($orderCol=="")$orderCol ="id";
        if($orderCol==0) $orderCol ="id";
        if($orderCol==1) $orderCol ="clientName";
        if($orderCol==2) $orderCol ="gamer_nick";
        if($orderCol==3) $orderCol ="gamer_name";
        if($orderCol==4) $orderCol ="totalProcess";
        if($orderCol==5) $orderCol ="lastProcess";
        if($orderCol==6) $orderCol ="isVip";
        if(!empty($dataEnd))$limit  = "limit ".$dataStart.", ".$dataEnd."";
		$x = $this->db->query("
        select
        *,
        @id             :=  id,
        @gamer_site_id  :=  gamer_site_id,
        @site_id        :=  site_id,
        @clientName     := (select site_name from site where id=@site_id) as clientName,
        @totalProcess   := (select COUNT(id) as totalProcess from finance where status='onaylandı' and gamer_site_id=@gamer_site_id) as totalProcess,
        @lastProcess    := (select DATE_FORMAT(update_time,'%d %b %y') from finance where gamer_site_id=@gamer_site_id order by update_time desc limit 1) as lastProcess
        from site_gamer
        where isDelete='0' ".$setFilter." ".$search." order by ".$orderCol." ".$orderDir." ".$limit);
        $this->db->query("insert into log_query set query=".$this->db->escape($this->db->getLastQuery()));
        return $x;
	}
}