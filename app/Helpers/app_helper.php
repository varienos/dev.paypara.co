<?php

function getVer()
{
    if (defined('getVersion')) {
        return getVersion;
    } else {
        $version    = fopen("version.txt", "r") or fopen("../deploy/version.txt", "r");
        $v          = fgets($version);
        fclose($version);
        return $v;
    }
}

function getVersion()
{
    return getVer();
}

function updateVersion()
{
    if(!file_exists("version.txt")):
        $version = fopen("version.txt", "w");
        $v       = "1.0.0";
        fwrite($version, $v);
        fclose($version);
        chmod("version.txt", 0777);
    endif;
    $v          = getVer();
    $version    = fopen("version.txt", "w");
    if($v!="") {
        $v      = explode(".", $v);
        $x      = intval($v[2])+1;
        $y      = $x==100 ? (intval($v[1])+1) : (intval($v[1]));
        $x      = $x==100 ? 0 : $x;
        $z      = $y==100 ? (intval($v[0])+1) : (intval($v[0]));
        $y      = $y==100 ? 0 : $y;
        $newVersion = $z.".".$y.".".$x;
        file_put_contents("version.txt", "");
        fwrite($version, $newVersion);
    } else {
        fwrite($version, "1.0.0");
    }
    fclose($version);

    return $newVersion;
}

function baseUrl($url="")
{
    return base_url($url);
}

function appViewPath()
{
    return APPPATH.'Views/app/';
}

function assetsPath()
{
    return 'assets/build/dist';
}

function activeDomain()
{
    $domain = strpos(HOSTNAME, "localhost") > 0 ? "http://" : "https://";
    $domain .= SUBDOMAIN == "dev" || SUBDOMAIN == "deploy" ? (SUBDOMAIN == "deploy" ? "deploy." : null)  . "dev.paypara." : "app.paypara.";

    if (strpos(HOSTNAME, "localhost") > 0) {
        $domain .= "localhost";
    } else if (substr(HOSTNAME, -3) == "dev") {
        $domain .= "dev";
    } else {
        $domain .= "co";
    }

    return $domain;
}

function isExec()
{
    $disabled = explode(',', ini_get('disable_functions'));
    return in_array('exec', $disabled);
}

function isMd5($md5)
{
    return preg_match('/^[a-f0-9]{32}$/', $md5);
}

function getClientIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if(strpos($ip, ",")) {
        $exp = explode(',', $ip);
        $ip  = $exp[0];
    }

    return $ip;
}

function bankName($key)
{
    return bankArray()[$key];
}

function bankArray($available=1)
{
    $x=     ["1"=>"Akbank",
            "2"=>"Albaraka Türk",
            "3"=>"Alternatif Bank",
            "4"=>"Burgan Bank",
            "5"=>"Denizbank",
            "6"=>"Fibabanka",
            "7"=>"Garanti BBVA",
            "8"=>"Halkbank",
            "9"=>"HSBC",
            "10"=>"ING Bank",
            "11"=>"İş Bankası",
            "12"=>"Kuveyt Türk",
            "13"=>"Şekerbank",
            "14"=>"Odeabank",
            "15"=>"TEB",
            "16"=>"Türkiye Finans",
            "17"=>"Vakıf Katılım",
            "18"=>"Vakıfbank",
            "19"=>"Yapı Kredi",
            "20"=>"Ziraat Bankası",
            "21"=>"Ziraat Katılım",
            "22"=>"QNB Finansbank"];

    if($available==1) {
        if(strlen(availableBanks)<1) {
            return $x;
        } else {
            $availableBanks=[];
            foreach($x as $key=>$value) {
                if(in_array($key, str_getcsv(availableBanks))==true) {
                    $availableBanks[$key] = $value;
                }
            }
            return $availableBanks;
        }
    } else {
        return $x;
    }
}

function htmlMinify($Html)
{
    $Search = array(
     '/(\n|^)(\x20+|\t)/',
     '/(\n|^)\/\/(.*?)(\n|$)/',
     '/\n/',
     '/\<\!--.*?-->/',
     '/(\x20+|\t)/', # Delete multispace (Without \n)
     '/\>\s+\</', # strip whitespaces between tags
     '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
     '/=\s+(\"|\')/'); # strip whitespaces between = "'

    $Replace = array(
     "\n",
     "\n",
     " ",
     "",
     " ",
     "><",
     "$1>",
     "=$1");

    $Html = preg_replace($Search, $Replace, $Html);
    return $Html;
}

function cssMinify($str)
{
    $input=file_get_contents($str);

    //if(trim($input) === "") return $input;
    $css = preg_replace(
        array(
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
        $input
    );
    $s = ['url(fonts/'];
    $r = ['url(assets/v8/plugins/global/fonts/'];
    return str_replace($s, $r, $css);
}

function jsMinify($str)
{
    $input=file_get_contents($str);
    $js= preg_replace(
        array(
            // Remove comment(s)
            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
            // Remove white-space(s) outside the string and regex
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
            // Remove the last semicolon
            '#;+\}#',
            // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
            // --ibid. From `foo['bar']` to `foo.bar`
            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
        ),
        array(
            '$1',
            '$1$2',
            '}',
            '$1$3',
            '$1.$3'
        ),
        $input
    );

    return str_replace("var ", " var ", $js).";";
}

function phpError($file, $line, $message)
{
    $db     = \Config\Database::connect();
    $db->query("insert into log_php_error set
                file        ='".$file."',
                line        ='".$line."',
                message     =".$db->escape($message)."
                timeStamo   =NOW()");
}

function getSettingSiteStatus($site_id, $setting)
{
    if(strlen($setting)==0) {
        return true;
    } elseif(in_array($site_id, str_getcsv($setting))) {
        return true;
    } else {
        return false;
    }
}

function getSession($param)
{
    $session = \Config\Services::session();
    return $session->get($param);
}

function getHeaderLine($param)
{
    $request = \Config\Services::request();
    return $request->getHeaderLine($param);
}
