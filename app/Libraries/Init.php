<?php

namespace App\Libraries;

class Init
{
    public $request;
    public $session;
    public $db;
    public $router;
    public $error;
    public $settings;
    public $paypara;
    public $SecureModel;
    public $JsObfuscator;
    public $agent;
    public $uri;

    public function __construct($request)
    {
        $this->session = \Config\Services::session();
        $this->router = \Config\Services::router();
        $this->db = \Config\Database::connect();
        $this->settings = new \App\Models\SettingsModel();
        $this->paypara = new \App\Libraries\Paypara();
        $this->error = new \App\Libraries\Error();
        $this->JsObfuscator = new \App\Libraries\JsObfuscator();
        $this->SecureModel = new \App\Models\SecureModel();
        $this->request = $request;
        $this->uri = new \CodeIgniter\HTTP\URI();
        $this->agent = $this->request->getUserAgent();
    }

    public function prepare()
    {
        $this->setHeader();
        $this->setClient();
        $this->setVersion();
        $this->setLocale();
        $this->setSettings();
        $this->setSegment();
        $this->initialize();
    }

    public function setClient()
    {
        define('getClientIpAddress', getClientIpAddress());
        define('getBrowser', $this->agent->getBrowser());
        define('getAgentString', $this->agent->getAgentString());
        define('getPlatform', $this->agent->getPlatform());
        define('getMobile', $this->agent->getMobile());
        define('getBrowserVersion', $this->agent->getVersion());
        define('getJsClientData', '');
    }

    public function setHeader()
    {
        isset($_SERVER['HTTP_ORIGIN']) || $http_origin = $_SERVER['HTTP_ORIGIN'];
        isset($http_origin) || header("Access-Control-Allow-Origin: $http_origin");

        header('X-Robots-Tag: noindex');
        header('X-Robots-Tag: googlebot: noindex, nofollow');
        header('X-Robots-Tag: otherbot: noindex, nofollow');
        define('CI_INIT_FIRE', microtime(true));
    }

    public function setSettings()
    {
        $settings = $this->db->query('select * from settings')->getResult();

        foreach ($settings as $row) {
            define($row->name, $row->value, false);
        }
    }

    public function setSegment()
    {
        if (count($this->request->uri->getSegments()) > 0) {
            foreach ($this->request->uri->getSegments() as $key => $value) {
                $segment[$key] = $value;
            }

            define('segment', $segment);
        }
    }

    public function setSession()
    {
        // SET SESSION CONTANT
        if (count($_SESSION) > 0) {
            foreach ($_SESSION as $key => $value) {
                define($key, $value, false);
            }
        }
    }

    public function auth()
    {
        if (!$this->SecureModel->security()) {
            return base_url('secure/login');
        }

        if (!$this->session->has('verify2fa')) {
            return base_url('dashboard');
        }

        if (!$this->session->get("verify2fa")) {
            return base_url('secure/2fa');
        }

        return true;
    }

    public function setUserPermission()
    {
        $fields = $this->db->getFieldNames('user_role');

        if ($this->session->get('root') == false) {
            $perms = $this->db->query("select * from user_role where id='" . $this->session->get('role_id') . "'")->getResult();
            foreach ($perms as $perm) {
                foreach ($fields as $field) {
                    if (!defined($field) && $field != 'id' && $field != 'isDelete' && $field != 'name' && $field != 'root') {
                        define(($field), ($perm->$field == 1 ? true : false));
                    }
                }
            }
        } elseif ($this->session->get('root') == true) {
            foreach ($fields as $field) {
                if (!defined($field) && $field != 'id' && $field != 'isDelete' && $field != 'name' && $field != 'root' && $field != 'partner') {
                    define(($field), true);
                }
            }

            define('partner', false);
        }
    }

    public function setLocale()
    {
        $this->db->query("SET lc_time_names = 'tr_TR'");
    }

    public function setVersion()
    {
        define('getVersion', getVer());
    }

    public function initialize()
    {
        if (SUBDOMAIN == 'api' || $this->request->getVar('core') != 'deploy' || $this->request->uri->getSegment(1) != 'json') {
            if (SUBDOMAIN == 'dev' || SUBDOMAIN == 'app' || SUBDOMAIN == 'deploy') {
                if ($this->request->uri->getSegment(1) != 'secure') {
                    if ($this->auth() !== true) {
                        header('Location: ' . $this->auth());
                        die();
                    }

                    $this->setSession();
                    $this->setUserPermission();
                }
            }
        }
    }
}