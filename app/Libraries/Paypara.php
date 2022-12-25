<?php 
namespace App\Libraries;
class Paypara
{
    public $isMatch = 0;

    function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
        $this->db      = \Config\Database::connect();
    }
    public function accountTotalMatch($account_id)
    {
        $data = $this->db->query("select * from site_gamer_match where account_id='".$account_id."' and isDelete=0")->getResult();
        return count((array)$data);
    }
    public function pendingProcess($account_id)
    {
        $data = $this->db->query("select * from site_gamer_match where account_id='".$account_id."' and isDelete=0")->getResult();
        return count((array)$data);
    }
    public function accountTotalProcess($account_id)
    {
        $data = $this->db->query("select * from finance where request='deposit' and account_id='".$account_id."'")->getResult();
        return count((array)$data);
    }
    public function getGamerLastDepositTime($gamer_site_id)
    {
        $data = $this->db->query("SELECT request_time
        FROM finance
        WHERE
        gamer_site_id   ='".$gamer_site_id."' AND
        status          ='onaylandı'
        order by request_time desc limit 1")->getRow();
        $datetime1 	= new \DateTime($data->request_time);
        $datetime2 	= new \DateTime();
        $interval 	= $datetime1->diff($datetime2);
        $timing     = explode(":",$interval->format("%y:%d:%h:%i"));
        $str        = null;
        if($timing[0]>0) $str .= $timing[0]." yıl&nbsp;";
        if($timing[1]>0) $str .= $timing[1]." ay&nbsp;";
        if($timing[2]>0) $str .= $timing[2]." saat&nbsp;";
        if($timing[3]>0) $str .= $timing[3]." dakika";
        return $str;
    }
    public function getGamerMonthlyDeposit($gamer_site_id)
    {
        $data = $this->db->query("SELECT SUM(price) as amount
        FROM finance
        WHERE
        MONTH(request_time) = MONTH(CURRENT_DATE()) AND
        YEAR(request_time)  = YEAR(CURRENT_DATE()) AND
        gamer_site_id='".$gamer_site_id."' AND
        status='onaylandı'")->getRow();
        return $data->amount=="" ? 0 : $data->amount;
    }
    public function getGamerTotalDeposit($gamer_site_id)
    {
        $data = $this->db->query("SELECT SUM(price) as amount
        FROM finance
        WHERE
        gamer_site_id='".$gamer_site_id."' AND
        status='onaylandı'")->getRow();
        return $data->amount=="" ? 0 : $data->amount;
    }
    public function accountTotalMonthlyDeposit($account_id)
    {
        $data = $this->db->query("SELECT SUM(price) as amount
        FROM finance
        WHERE
        MONTH(request_time) = MONTH(CURRENT_DATE()) AND
        YEAR(request_time)  = YEAR(CURRENT_DATE()) AND
        account_id='".$account_id."' AND
        status='onaylandı'")->getRow();
        return $data->amount=="" ? 0 : $data->amount;
    }
    public function disableMatch($userId,$account_id,$site_id,$deposit,$vip="", $transaction_id)
    {
        $this->setLog("disableMatch","OYUNCUYU MEVCUT HESAPI İÇİN PASİF DURUMA GETİR",$userId,$site_id,$deposit,$vip,$account_id, $transaction_id);
        $this->db->query("update site_gamer_match set isDelete=1, delete_time=NOW() where gamer_site_id='".$userId."' and account_id='".$account_id."'");
    }
    public function setNormalAccount($deposit,$userId,$site_id,$vip, $transaction_id)
    {
        $account = $this->db->query("select * from account where status='on' and isDelete<>'1' and dataType='1' order by sendTime asc limit 1")->getRow();
        if($account->id > 0)
        {
            $this->setLog("setNormalAccount","OYUNCYA *".mb_strtoupper($account->account_name,"UTF-8")."* NORMAL HESABI DÖNDÜRÜLDÜ",$userId,$site_id,$deposit,$vip, $account->id, $transaction_id);
            $this->db->query("update account set sendTime=NOW() where id='".$account->id."'");
            return $account->id;
        }else{
            $this->setLog("setNormalAccount","UYGUN NORMAL HESAP BULUNAMADI",$userId,$site_id,$deposit,$vip, "", $transaction_id);
            return 0;
        }
    }
    public function setBankAccount($deposit,$userId,$site_id,$vip, $transaction_id)
    {
        $account = $this->db->query("select * from account where status='on' and isDelete<>'1' and dataType='3' order by sendTime asc limit 1")->getRow();
        if($account->id > 0)
        {
            $this->setLog("setBankAccount","OYUNCYA *".mb_strtoupper($account->account_name,"UTF-8")."* BANKA HESABI DÖNDÜRÜLDÜ",$userId,$site_id,$deposit,$vip, $account->id, $transaction_id);
            $this->db->query("update account set sendTime=NOW() where id='".$account->id."'");
            return $account->id;
        }else{
            $this->setLog("setBankAccount","UYGUN BANKA HESABI BULUNAMADI",$userId,$site_id,$deposit,$vip, "", $transaction_id);
            return 0;
        }
    }
    function setNumber($str)
    {
        return floatval(number_format($str, 2, '.', ''));
    }
    public function setNewMatch($userId,$deposit,$site_id,$vip, $transaction_id, $firstMatch=0)
    {
        // MIN. LIMIT YATIRIM'A UYGUN EŞLEŞTİRME HESAPLARINI DÖNDÜR
        $matchAccounts = $this->db->query("select * from account where match_limit>'0' and status='on' and isDelete<>'1' and dataType='2' order by sendTime asc")->getResult();
        if(count((array)$matchAccounts)>0)
        {
            $this->setLog("setNewMatch",count((array)$matchAccounts)." EŞLEŞME HESABI ARASINDA UYGUN HESAP ARANIYOR",$userId,$site_id,$deposit,$vip,0, $transaction_id);
            foreach($matchAccounts as $row)
            {
                //EŞLEŞME LİMİTİ UYGUN HESAPI BUL
                if($this->accountTotalMatch($row->id)<$row->match_limit && $this->setNumber($this->accountTotalMonthlyDeposit($row->id))<$this->setNumber($row->limitDeposit))
                {
                    $this->setLog("setNewMatch","EŞLEŞME VE AYLIK YATIRIM LİMİTİ UYGUN 1 HESAP BULUNDU",$userId,$site_id,$deposit,$vip,$row->id, $transaction_id);
                    //OYUNCUYU HESAP İLE EŞLEŞTİR
                    $this->db->query("insert into site_gamer_match set gamer_site_id='".$userId."', account_id='".$row->id."', firstMatch='".$firstMatch."', match_time=NOW()");
                    $this->setLog("setNewMatch","OYUNCU *".mb_strtoupper($row->account_name,"UTF-8")."* HESABI İLE EŞLEŞTİRİLDİ",$userId,$site_id,$deposit,$vip,$row->id, $transaction_id);
                    $this->db->query("update account set sendTime=NOW() where id='".$row->id."'");
                    return $row->id;
                    break;
                }
                $this->setLog("setNewMatch","*".mb_strtoupper($row->account_name,"UTF-8")."* EŞLEŞME HESABI UYGUN DEĞİL ÇÜNKÜ: @accountTotalMatch:".$this->accountTotalMatch($row->id)." < @accountMatchLimit:".$row->match_limit." && @accountTotalMonthlyDeposit:".$this->setNumber($this->accountTotalMonthlyDeposit($row->id))." < @accountLimitDeposit:".$this->setNumber($row->limitDeposit),$userId,$site_id,$deposit,$vip,0, $transaction_id);
            }
            $this->setLog("setNewMatch",count((array)$matchAccounts)." HESAP İÇERİSİNDE EŞLEŞME VE AYLIK YATIRIM LİMİTİ UYGUN HESAP BULUNAMADI",$userId,$site_id,$deposit,$vip,0, $transaction_id);
        }else{
            $this->setLog("setNewMatch","UYGUN EŞLEŞEN HESAP BULUNAMADI",$userId,$site_id,$deposit,$vip,0, $transaction_id);
        }
        $this->setLog("setNewMatch","OYUNCUYA İÇİN UYGUN NORMAL HESAP ARANIYOR",$userId,$site_id,$deposit,$vip,0, $transaction_id);
        return $this->setNormalAccount($deposit,$userId,$site_id,$vip,$transaction_id);
    }
    public function setLog($method="",$log="",$gamer_site_id="",$site_id="",$deposit="",$vip="",$account_id="", $transaction_id="")
    {
        $this->db->query("
        insert into log_transaction set
        method          ='".$method."',
        transaction_id  ='".$transaction_id."',
        account_id      ='".$account_id."',
        site_id         ='".$site_id."',
        isVip           ='".$vip."',
        gamer_site_id   ='".$gamer_site_id."',
        deposit         ='".$deposit."',
        log             ='".$log."',
        timeStamp       =NOW()
        ");
    }
    public function setMatch($userId,$deposit,$site_id,$vip,$transaction_id)
    {
        //EŞLEŞME SİSTEMİ DURUMU
        if(matchStatus!="on")
        {
            $this->setLog("setMatch","EŞLEME SİSTEMİ DEVREDIŞI OLDUĞU İÇİN OYUNCUYA NORMAL HESAP DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$vip,0,$transaction_id);
            return $this->setNormalAccount($deposit,$userId,$site_id,$vip,$transaction_id);
        }
        //OYUNCUN EŞLEŞTİĞİ HESAP VAR MI ?
        $getGamerMatchAccountId = $this->getGamerMatchAccountId($userId,$site_id,$deposit,$vip, $transaction_id);
        //OYUNCUN BİR EŞLEŞME HESAPI VAR
        if($getGamerMatchAccountId>0)
        {
            //HESAPIN DETAYLARINI AL
            $getAccountData = $this->getAccountData($getGamerMatchAccountId);
            $this->setLog("setMatch","OYUNCUN MEVCUT BİR EŞLEŞME HESAPI VAR",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
            //HESAP YATIRIM LİMİTİ MÜSAİT Mİ ?
            if(($this->accountTotalMonthlyDeposit($getGamerMatchAccountId)+$deposit)<$getAccountData->limitDeposit)
            {
                //HESAP YATIRIMA MÜSAİT
                $this->setLog("setMatch","OYUNCUNUN MEVCUT EŞLEŞME HESABI YATIRIMA MÜSAİT",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                //HESAP AKTİF Mİ ?
                if($this->getAccountStatus($getAccountData->id)!="on")
                {
                     //OYUNCUNUN MEVCUT EŞLEŞME HESABI PASİF DURUMDA
                    $this->setLog("setMatch","HESAP YATIRIMA MÜSAİT",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                    if($this->isMatch($deposit))
                    {
                        //OYUNCU YENİ BİR EŞLEŞME HESABI İLE İLİŞKİLENDİRİLİCEK
                        $this->setLog("setMatch","OYUNCU YENİ BİR EŞLEŞME HESABI İLE İLİŞKİLENDİRİLİCEK",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                        //OYUNCUYU MEVCUT HESAPI İÇİN PASİF DURUMA GETİR
                        $this->disableMatch($userId,$getAccountData->id,$site_id,$deposit,$vip, $transaction_id);
                        $this->setLog("setMatch","MEVCUT HESAP EŞLEŞMESİ PASİF DURUMA GETİRİLDİ",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                        //OYUNCU YENİ HESAP EŞLEŞTİRMESİ
                        $this->setLog("setMatch","OYUNCU BAŞKA BİR HRSABA AKTARILIYOR",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                        return $this->setNewMatch($userId,$deposit,$site_id,$vip, $transaction_id);
                    }else{
                        //OYUNCUNUN MEVCUT EŞLEŞME HESABI PASİF VE YATIRIMI @matchAmountLimit KURALINI KARŞILAMADIĞI İÇİN NORMAL HESAP DÖNDÜRÜLECEK
                        $this->setLog("setMatch","OYUNCUNUN MEVCUT EŞLEŞME HESABI PASİF VE YATIRIMI @matchAmountLimit KURALINI KARŞILAMADIĞI İÇİN NORMAL HESAP DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$vip,$getAccountData->id,$transaction_id);
                        return $this->setNormalAccount($deposit,$userId,$site_id,$vip,$transaction_id);
                    }
                }
                return $getAccountData->id;
            }else{
                //MEVCUT HESAP YATIRIMA UYGUN DEĞİL
                $this->setLog("setMatch","OYUNCUNUN MEVCUT EŞLEŞME HESABI YATIRIMA UYGUN DEĞİL",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                //OYUNCUYU MEVCUT HESAPI İÇİN PASİF DURUMA GETİR
                $this->disableMatch($userId,$getAccountData->id,$site_id,$deposit,$vip, $transaction_id);
                $this->setLog("setMatch","MEVCUT HESAP EŞLEŞMESİ PASİF DURUMA GETİRİLDİ",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                $this->setLog("setMatch","OYUNCU BAŞKA BİR HRSABA AKTARILIYOR",$userId,$site_id,$deposit,$vip,$getAccountData->id, $transaction_id);
                //OYUNCU YENİ HESAP EŞLEŞTİRMESİ
                return $this->setNewMatch($userId,$deposit,$site_id,$vip, $transaction_id);
            }
        }else{
            //OYUNCU YENİ HESAP EŞLEŞTİRMESİ
            $this->setLog("setMatch","OYUNCU İÇİN YENİ EŞLEŞME HESABI ARANIYOR",$userId,$site_id,$deposit,$vip,0, $transaction_id);
            return $this->setNewMatch($userId,$deposit,$site_id,$vip, $transaction_id, 1);
        }
        //return 0;
    }
    public function getGametMatchAccountInfo($userId)
    {
        $gamerData = $this->db->query("select * from site_gamer
        inner join site_gamer_match on site_gamer_match.`gamer_site_id`=site_gamer.`gamer_site_id`
        where site_gamer.`gamer_site_id`='".$userId."' and site_gamer_match.isDelete=0
        group by site_gamer.`gamer_site_id` limit 1");
        if(count((array)$gamerData->getResult())==0)
        {
            return 0;
        }else{
            $data = $gamerData->getRow();
            //HESAP AKTİF Mİ ?
            if($this->getAccountStatus($data->account_id) == "on")
            {
                $accountData = $this->getAccountData($data->account_id);
                return $accountData->account_name;
            }else{
                return 0;
            }
        }
    }
    public function getGamerMatchAccountId($userId,$site_id,$deposit,$vip, $transaction_id)
    {
        //EŞLEŞME SİSTEMİ DURUMU
        if(matchStatus!="on")
        {
            $this->setLog("setMatch","EŞLEME SİSTEMİ DEVREDIŞI OLDUĞU İÇİN OYUNCUYA NORMAL HESAP DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$vip,0,$transaction_id);
            return $this->setNormalAccount($deposit,$userId,$site_id,$vip,$transaction_id);
        }
        $gamerData = $this->db->query("select * from site_gamer
        inner join site_gamer_match on site_gamer_match.`gamer_site_id`=site_gamer.`gamer_site_id`
        where site_gamer.`gamer_site_id`='".$userId."' and site_gamer_match.isDelete=0
        group by site_gamer.`gamer_site_id` limit 1");
        if(count((array)$gamerData->getResult())==0)
        {
            return 0;
        }else{
            $data = $gamerData->getRow();
            //HESAP AKTİF Mİ ?
            if($this->getAccountStatus($data->account_id) == "on")
            {
                //HESAP AKTİF
                $this->setLog("getGamerMatchAccountId","HESAP AKTİF",$userId,$site_id,$deposit,$vip,$data->account_id, $transaction_id);
                return $data->account_id;
            }else{
                //HESAP DEAKTİF
                $this->setLog("getGamerMatchAccountId","HESAP DEAKTİF",$userId,$site_id,$deposit,$vip,$data->account_id, $transaction_id);
                //OYUNCUYU MEVCUT HESAPI İÇİN PASİF DURUMA GETİR
                $this->disableMatch($userId,$data->account_id,$site_id,$deposit,$vip, $transaction_id);
                return 0;
            }
        }
    }
    public function getAccountStatus($accountId)
    {
        $data = $this->db->query("select status from account where id='".$accountId."' limit 1")->getRow();
        return $data->status;
    }
    public function getAccountData($accountId)
    {
        return $this->db->query("select * from account where id='".$accountId."' limit 1")->getRow();
    }
    public function isMatch($deposit)
    {
        if($deposit>=matchAmountLimit)
        {
            return true;
        }else{
            return false;
        }
    }
    public function getAccount($deposit, $userId, $site_id, $transaction_id, $method)
    {
        //OYUNCU ANALİZİ
        $gamerData = $this->db->query("select * from site_gamer where `gamer_site_id`='".$userId."'")->getRow();
        //$this->db->query("delete from log_transaction where id<>0");

        //SITE PERM
        $matchStatusSite    = matchStatusSite==""?true:in_array($site_id,str_getcsv(matchStatusSite));
        $bankStatusSite     = bankStatusSite ==""?true:in_array($site_id,str_getcsv(matchStatusSite));

        //BANKA HESABI İSTENİYOR İSE
        if($method=="bank")
        {
            $this->setLog("getAccount","OYUNCU İÇİN BANKA HESABI DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
            if($matchStatusSite==true)
            {
                return $this->setBankAccount($deposit,$userId,$site_id,$gamerData->isVip, $transaction_id);
            }else{
                $this->setLog("getAccount","SİTE BANKA YETKİSİ KAPALI",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
                return 0;
            }
        }
        //OYUNCU VIP İSE @matchAmountLimit KURALI DEVRE DIŞI BIRAKILDI
        if($gamerData->isVip=="on" && $matchStatusSite==true)
        {
            //VIP OYUNCU BİR HESAP İLE EŞLEŞTİRİLECEK VEYA EŞLEŞTİĞİ HESAP DÖNDÜRÜLECEK
            $this->setLog("getAccount","VIP OYUNCU BİR HESAP İLE EŞLEŞTİRİLECEK VEYA EŞLEŞTİĞİ HESAP DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
            return $this->setMatch($userId,$deposit,$site_id,$gamerData->isVip, $transaction_id);
        }else{
            //OYUNCU VIP DEĞİL İSE @matchAmountLimit KURALINI SORGULA
            $this->setLog("getAccount","OYUNCU VIP DEĞİL @matchAmountLimit KURALINI SORGULA",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
            if($this->setNumber($deposit)>=$this->setNumber(matchAmountLimit) && $matchStatusSite==true)
            {
                //OYUNCU EŞLEŞME HESAPI KULLANACAK
                $this->setLog("getAccount","OYUNCUYA EŞLEŞME HESAPI DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
                return $this->setMatch($userId,$deposit,$site_id,$gamerData->isVip, $transaction_id);
            }else{
                $this->setLog("getAccount","OYUNCU @matchAmountLimit KURALINI AŞAMADI (".$this->setNumber($deposit).">=".$this->setNumber(matchAmountLimit).") VEYA SITE(".$site_id.") EŞLEŞME YETKİSİ KAPALI",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
                //OYUNCU BİR HESAPLA EŞLEŞTİRİLMİŞ Mİ ?
                if($this->getGamerMatchAccountId($userId,$site_id,$deposit,$gamerData->isVip, $transaction_id)>0)
                {
                    //OYUNCU BİR HESAP İLE ZATEN EŞLEŞTİRİLMİŞ
                    $this->setLog("getAccount","OYUNCU BİR HESAP İLE ZATEN EŞLEŞTİRİLMİŞ",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
                    return $this->getGamerMatchAccountId($userId,$site_id,$deposit,$gamerData->isVip, $transaction_id);
                }else{
                    //OYUNCU BİR HESAPA TANIMLI DEĞİL VE YATIRIMI @matchAmountLimit KURALINI KARŞILAMIYOR NORMAL HESAP DÖNDÜRÜLECEK
                    $this->setLog("getAccount","OYUNCU BİR HESAPA TANIMLI DEĞİL VE YATIRIMI @matchAmountLimit KURALINI KARŞILAMIYOR NORMAL HESAP DÖNDÜRÜLECEK",$userId,$site_id,$deposit,$gamerData->isVip, "", $transaction_id);
                    return $this->setNormalAccount($deposit,$userId,$site_id,$gamerData->isVip, $transaction_id);
                }
            }
        }
    }

} ?>