<?php

namespace App\Models;

use CodeIgniter\Model;

class DevModel extends Model
{
    function __construct()
    {
        $this->session  = \Config\Services::session();
        $this->db       = \Config\Database::connect();
        $this->setting  = new \App\Models\SettingModel();
        $this->paypara  = new \App\Libraries\Paypara();
        $this->error    = new \App\Libraries\Error();
    }

    public function errorHandler($language, $data)
    {
        if ($language == 'js') {

            $this->db->query("insert into log_js_error set
            `location`      =" . $this->db->escape($data['location']) . ",
            `source`        =" . $this->db->escape($data['source']) . ",
            `line`          =" . $this->db->escape($data['line']) . ",
            `col`           =" . $this->db->escape($data['col']) . ",
            `ip`            =" . $this->db->escape($data['getClientIpAddress']) . ",
            `error`         =" . $this->db->escape($data['error']) . ",
            `browser`       =" . $this->db->escape($data['getBrowser']) . ",
            `agentString`   =" . $this->db->escape($data['getAgentString']) . ",
            `platform`      =" . $this->db->escape($data['getPlatform']) . ",
            `isMobil`       =" . $this->db->escape($data['getMobile']) . ",
            `browserVersion`=" . $this->db->escape($data['getBrowserVersion']) . ",
            `errorTime`     =NOW()
        ");
        }
    }

    public function usersCheckHash()
    {
        $users = $this->db->query("select * from user")->getResult();
        echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">';
        echo '<style>body{ background:#041526;font-family: "VT323", monospace; font-size:15px; color:#a5c5e5; margin: 50px; }</style>';
        foreach ($users as $row) {
            $this->db->query("update user set hash_id='" . md5($row->id) . "' where id='" . $row->id . "'");
            $this->db->query("update user set user_pass_hash='" . md5($row->user_pass) . "' where id='" . $row->id . "'");
            echo $row->id . " => " . md5($row->id) . "<br>";
        }
    }

    public function clientsCheckHash()
    {
        $users = $this->db->query("select * from site")->getResult();
        echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">';
        echo '<style>body{ background:#041526;font-family: "VT323", monospace; font-size:15px; color:#a5c5e5; margin: 50px; }</style>';
        foreach ($users as $row) {
            $this->db->query("update site set api_key='" . md5($row->api_key) . "', api_key_pin='" . substr($row->api_key, 0, 8) . "' where id='" . $row->id . "'");
            echo $row->api_key . " => " . md5($row->api_key) . "<br>";
        }
    }

    public function clientsCheckSecurityHash()
    {
        $sites = $this->db->query("select * from site")->getResult();
        echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">';
        echo '<style>body{ background:#041526;font-family: "VT323", monospace; font-size:15px; color:#a5c5e5; margin: 50px; }</style>';
        foreach ($sites as $row) {
            $this->db->query("update site set private_key='" . substr(md5($row->api_key_pin), 0, 16) . "' where id='" . $row->id . "'");
            echo "private_key => " . substr(md5($row->api_key_pin), 0, 16) . "<br>";
        }
    }
}