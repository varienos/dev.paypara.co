<?php

namespace App\Models;

use CodeIgniter\Model;

class SecureModel extends Model
{
    protected $table              = 'root';
    protected $primaryKey         = 'id';
    protected $returnType         = 'object';
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['id', 'user_mail', 'user_pass', 'user_nick'];
    protected $useTimestamps      = false;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

    function __construct()
    {
        $this->session  = \Config\Services::session();
        $this->db       = \Config\Database::connect();
        $this->request  = \Config\Services::request();
        $this->agent    = $this->request->getUserAgent();
        $this->sql      = $this->db->table('root');
        $this->settings = new \App\Models\SettingsModel();
        $this->error    = new \App\Libraries\Error();

        helper("app");
    }

    public function security($status = true)
    {
        if (!$status) {
            $this->session->destroy();
            header("Location: secure/login");
            die();
        } elseif ($this->session->get("token") != $this->getToken() && $status === true) {
            return false;
        } else {
            return true;
        }
    }

    public function setup2fa($secret)
    {
        if ($this->session->get('userId') > 0 && $secret != "") {
            $this->db->query("update user set secret2fa=" . $this->db->escape($secret) . ", is2fa='on' where id=" . $this->session->get('userId'));
            $this->session->set('is2fa', 'on');
            $this->session->set('secret2fa', $secret);
            return true;
        } else {
            return false;
        }
    }

    public function disable2fa($user_id)
    {
        if ($this->session->get('userId') != "") {
            $this->db->query("update user set secret2fa='', is2fa='0' where id=" . ($this->session->get('root') ? decodeUserId($user_id) : $this->session->get('userId')));
            $this->session->set('is2fa', '0');
            $this->session->set('secret2fa', '');
            return true;
        } else {
            return false;
        }
    }

    public function sessionStatus()
    {
        $userSessionData = $this->db->query("select * from log_user_login where token='" . $this->getToken() . "' and user_id=" . $this->session->get('userId'));
        @date_default_timezone_set('Europe/Istanbul');
        $start  = strtotime($userSessionData->lastActivitiy);
        $end    = strtotime(date('Y-m-d H:i:s'));
        $second = $end - $start;
        if ($second > $this->sessionTimeout()) {
            $this->security(false);
        } else {
            return true;
        }
    }

    public function sessionTimeout()
    {
        return (60 * 60);
    }

    public function stateAuth($defined)
    {
        if ($defined !== true) {
            header("Location: " . base_url('/404'));
            die();
        }
    }

    public function getToken()
    {
        return md5($this->request->getHeaderLine('Cf-Ipcity') . $this->request->getHeaderLine('Cf-Ipcountry') . getClientIpAddress() . date("Y-m-d") . $this->session->get("userId") . $this->agent->getBrowser() . $this->agent->getAgentString() . $this->agent->getPlatform() . $this->agent->getVersion());
    }

    public function log($id)
    {
        helper("app");
        $token = md5($this->request->getHeaderLine('Cf-Ipcity') . $this->request->getHeaderLine('Cf-Ipcountry') . getClientIpAddress() . date("Y-m-d") . $id .

        $this->agent->getBrowser() . $this->agent->getAgentString() . $this->agent->getPlatform() . $this->agent->getVersion());
        $this->session->set('token', $token, $this->sessionTimeout());

        $this->db->query("insert into log_user_login set
            user_id='" . $id . "',
            city='" . $this->request->getHeaderLine('Cf-Ipcity') . "',
            country='" . $this->request->getHeaderLine('Cf-Ipcountry') . "',
            latitude='" . $this->request->getHeaderLine('Cf-Iplatitude') . "',
            longitude='" . $this->request->getHeaderLine('Cf-Iplongitude') . "',
            ip='" . getClientIpAddress() . "',
            sessionId='" . $this->session->get('ci_session') . "',
            token='" . $token . "',
            `browser`='" . $this->agent->getBrowser() . "',
            `agentString`='" . $this->agent->getAgentString() . "',
            `platform`='" . $this->agent->getPlatform() . "',
            `isMobil`='" . $this->agent->getMobile() . "',
            `browserVersion`='" . $this->agent->getVersion() . "',
            `loginTime`=NOW(),
            `lastActivitiy`=NOW(),
            dataHeader = " . $this->db->escape(json_encode(getallheaders(), JSON_UNESCAPED_UNICODE)) . "
        ");
    }

    public function auth()
    {
        $data = $this->sql->where('user_mail', $this->request->getVar('x'))->where('user_pass', md5(trim($this->request->getVar('y'))))->get()->getRow();

        if ($data->id == 0 && $data->user_name == "root") {
            try {
                $this->session->set(md5(getClientIpAddress() . $data->id), $data->id, $this->sessionTimeout());
                $this->session->set('primeId', $data->id, $this->sessionTimeout());
                $this->session->set('email', 'aras@bozok.net', $this->sessionTimeout());
                $this->session->set('is2fa', 0, $this->sessionTimeout());
                $this->session->set('secret2fa', null, $this->sessionTimeout());
                $this->session->set('verify2fa', true, $this->sessionTimeout());
                $this->session->set('userId', $data->id, $this->sessionTimeout());
                $this->session->set('hashId', $data->id, $this->sessionTimeout());
                $this->session->set('user_name', "Root", $this->sessionTimeout());
                $this->session->set("root", true, $this->sessionTimeout());
                $this->session->set('role', 'System Administrator', $this->sessionTimeout());
                $this->session->set('role_id', 4, $this->sessionTimeout());
                $this->session->set('notificationSound', ($data->notificationSound), $this->sessionTimeout());
                $this->log($data->id);
            } catch (\CodeIgniter\UnknownFileException $e) {
                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }

            if ($this->sql->set(
                    array(
                        'user_last_login'   => date('Y-m-d H:i:s'),
                        'user_session_id'   => $this->session->get('ci_session')
                    )
                )->where('id', $data->id)->update() == true
            ) {
                return json_encode(array('status' => true, 'url' => 'dashboard'));
            } else {
                $error = $this->db->error();
                return json_encode(array('status' => false, 'message' => $error['message']));
            }
        } else {
            $user  = $this->db->query("select * from user where email='" . $this->request->getVar('x') . "' and user_pass_hash='" . md5($this->request->getVar('y')) . "' and status='on' and isDelete='0'")->getRow();

            if ($user->id > 0) {
                $this->db->query("
                    update user set
                    user_last_login=NOW(),
                    user_ip='" . getClientIpAddress() . "'
                    where id='" . $user->id . "'"
                );

                $this->session->set(md5(getClientIpAddress() . $user->id), $user->id, $this->sessionTimeout());
                $this->session->set('primeId', $user->id, $this->sessionTimeout());
                $this->session->set('is2fa', $user->is2fa, $this->sessionTimeout());
                $this->session->set('secret2fa', $user->secret2fa, $this->sessionTimeout());
                $this->session->set('verify2fa', ($user->is2fa == 'on' ? false : true), $this->sessionTimeout());
                $this->session->set('userId', $user->id, $this->sessionTimeout());
                $this->session->set('hashId', $user->hash_id, $this->sessionTimeout());
                $this->session->set("root", (\getAuth($user->role_id, 'root') == 1 ? true : false), $this->sessionTimeout());
                $this->session->set('role_id', ($user->role_id), $this->sessionTimeout());
                $this->session->set('user_name', $user->user_name, $this->sessionTimeout());
                $this->session->set('email', $user->email, $this->sessionTimeout());
                $this->session->set('notificationSound', ($user->notificationSound), $this->sessionTimeout());
                $this->session->set('role', getRoleName($user->role_id), $this->sessionTimeout());
                $this->log($user->id);

                return json_encode(array('status' => true, 'url' => 'dashboard', 'is2fa' => $user->is2fa, 'secret2fa' => $user->secret2fa));
            }

            return json_encode(array('status' => false, 'url' => 'dashboard', 'is2fa' => $user->is2fa, 'secret2fa' => $user->secret2fa));
        }
    }
}