<?php

namespace App\Libraries;

class Console
{
    protected $remoteConsole = "https://app.paypara.co/dev/console";

    function __construct()
    {
        \error_reporting(1);
        date_default_timezone_set('Europe/Istanbul');

        $this->mysqlSync     = new \App\Libraries\mysqlSync();

        define("SERVER_PATH", (strpos($_SERVER['HTTP_HOST'], 'localhost') > 0 ? '/Applications/XAMPP/xamppfiles/htdocs/dev.paypara.composer/' : '/home/devpaypara/public_html/'));
    }

    function manuel()
    {
        $help = [];
        $help[] = ['desc' => 'Yazılımı dağıtım için paketler:', 'cmd' => 'package'];
        $help[] = ['desc' => 'Yazılımı üretim ortamına yükler ve yayına alır:', 'cmd' => 'deploy veya deploy ~~CI4'];
        $help[] = ['desc' => 'CI4 ile versiyon yükseltilemiyorsa core php ile acil durum yüklemesi:', 'cmd' => 'deploy ~~core-php'];
        $help[] = ['desc' => 'Üretim ortamı sunucusunda ssh komutu çalıştırıp cevabı döndürür:', 'cmd' => 'remote.ssh ~~[cmd] veya remote ~~ssh ~~[cmd_1];[cmd_2]'];
        $help[] = ['desc' => 'Dev ve prod versiyonlarını döndürür:', 'cmd' => 'version'];
        $help[] = ['desc' => 'Dev ortamı versiyonunu yükseltir ve assets cache yeniler.', 'cmd' => 'version.update'];
        $help[] = ['desc' => 'Dev ve prod veritabanlarının tablolarını senkron eder, veriler işlenmez:', 'cmd' => 'db.sync'];
        $help[] = ['desc' => 'Hedef ortamın veri tabanı yedeğini verir:', 'cmd' => 'db.backup ~~production veya db.backup ~~development'];

        for ($i = 0; $i < count($help); $i++) {
            echo "<li id='response' class='fw-bold text-primary'>" . $help[$i]['desc'] . "<span class='text-light'> `" . $help[$i]['cmd'] . "`</span></li>";
        }
    }

    function cmd($cmd)
    {
        if ($this->isExec()) {
            echo "<li class='text-danger'>warning: " . SUBDOMAIN . ".paypara.co server 'exec' function disabled in php.ini</li>";
            die();
        }

        $opt = "";
        if (strpos($cmd, ' ~~') > 0) {
            $explode    = explode(' ~~', $cmd);
            $opt        = trim($explode[1]);
            $cmd        = trim($explode[0]);
            $optArray   = $explode;
        }

        if ($cmd == "help") $this->manuel();
        else if ($cmd == "db.backup" && $opt == "production") $this->backup($optArray);
        else if ($cmd == "remote.ssh") $this->remotessh($optArray);
        else if ($cmd == "remote") $this->remote($optArray);
        else if ($cmd == "package") $this->package();
        else if ($cmd == "version") echo "<li>Development: " . $this->getVer() . ", Production: " . $this->remoteGetVer() . "</li>";
        else if ($cmd == "version.update") echo "<li>" . $this->getVer() . " upgraded to " . updateVersion() . "</li>";
        else if ($cmd == "deploy")  $this->deploy($optArray);
        else if ($cmd == "db.sync")    $this->mysqlSync->init();
        else if ($cmd == "fileExists") $this->fileExists($opt);
        else if ($cmd != "") echo "<li>Unknown command: '".$cmd."'. Try again or type `help` to get help.</li>";
    }

    function isExec()
    {
        $disabled = explode(',', ini_get('disable_functions'));
        return in_array('exec', $disabled);
    }

    function fileExists($file)
    {
        if (!file_exists($file)) {
            echo 'path or file name incorrect</li>';
        } else {
            echo 'true => ' . $file . '</li>';
        }
    }

    function setVer()
    {
        if (!file_exists("version.txt")) {
            $version = fopen("version.txt", "w");
            $v       = "1.0.0";
            fwrite($version, $v);
            fclose($version);
            chmod("version.txt", 0777);
        }

        $v          = $this->getVer();
        $version    = fopen("version.txt", "w");

        if ($v != "") {
            $v = explode(".", $v);
            $x = intval($v[2]) + 1;
            $y = $x == 100 ? (intval($v[1]) + 1) : (intval($v[1]));
            $x = $x == 100 ? 0 : $x;
            $z = $y == 100 ? (intval($v[0]) + 1) : (intval($v[0]));
            $y = $y == 100 ? 0 : $y;

            file_put_contents("version.txt", "");
            fwrite($version, $z . "." . $y . "." . $x);
        } else {
            fwrite($version, "1.0.0");
        }

        fclose($version);
    }

    function getVer()
    {
        $version = fopen("version.txt", "r");
        $v = fgets($version);
        fclose($version);

        return $v;
    }

    function package()
    {
        $source = SERVER_PATH;
        $release = SERVER_PATH . "deploy.dev.paypara.co";
        $output = null;
        $retval = null;
        $file = "deploy.paypara." . date("Y.m.d") . '.' . $this->getVer() . ".tar.gz";

        exec("rm -Rf $release/*;
              cp -Rf $source/* $release;
              rm -Rf $release/cgi-bin;
              rm -Rf $release/__MACOSX;
              rm -Rf $release/writable/session/*;
              rm -Rf $release/writable/logs/*;
              rm -Rf $release/writable/cache/*;
              rm -Rf $release/writable/debugbar/*;
              rm -Rf $release/public;
              rm -Rf $release/release;
              rm -Rf $release/deploy;
              rm -Rf $release/well-known;
              rm -Rf $release/deploy.dev.paypara.co;
              rm -Rf $release/revision;
              rm -Rf $release/release.dev.paypara.co;
              rm -Rf $release/ioncube.dev.paypara.co;
              rm $release/.htaccess;
              rm $release/.jsbeautifyrc;
              rm $release/.user.ini;
              rm $release/.env;
              rm $release/builds;
              rm $release/composer.json;
              rm $release/composer.lock;
              rm $release/error_log;
              rm $release/spark;
              rm $release/php.ini;
              rm $release/phpunit.xml.dist;
              rm $release/LICENSE;
              rm $release/README.md;
              rm $release/local_error_log;
              rm $release/local_access_log;
              rm '" . $file . "';
              tar -czvf " . $source . "/deploy/" . $file . " $release/*;
              cp -Rf $source/.htaccess $release;
              cp -Rf $source/.env $release;
        ", $output, $retval);

        echo "<li>Returned with exec $retval and output:\n";
        print_r($output);
        echo "</li>";
        echo "<li><a href='https://deploy.dev.paypara.co/secure/login' target='_blank' style='color:#46ff6c'>https://deploy.dev.paypara.co</a> v." . $this->getVer() . " is ready for production!<br />Awaiting for deploy ...</li>";

        die();
    }

    function deploy($opt)
    {
        $version = ($opt[2] != "" ? $opt[2] : $this->getVer());

        if (file_exists("deploy/deploy.paypara." . date("Y.m.d") . "." . $version . ".tar.gz")) {
            $ch = curl_init();
            $this->mysqlSync->init();

            curl_setopt($ch, CURLOPT_URL, $opt[1] == "" || $opt[1] == "CI4" ? $this->remoteConsole : "https://app.paypara.co/deploy/app.core.update.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ($opt[1] == "" || $opt[1] == "CI4" ? "core=deploy&cmd=remote ~~update" : "cmd=update") . "&token=" . md5("update" . date("Y.m.d")) . "&f=deploy.paypara." . date("Y.m.d") . "." . $version . ".tar.gz&v=" . $version);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            $server_output = curl_exec($ch);

            if (!empty(curl_error($ch))) die("<li>CURL Error: " . curl_error($ch) . "</li>");

            echo "<li>request to " . ($opt[1] == "" || $opt[1] == "CI4" ? $this->remoteConsole : "https://app.paypara.co/deploy/app.core.update.php") . "</li>";
            echo "<li>" . ($opt[1] == "" || $opt[1] == "CI4" ? "core=deploy&cmd=remote ~~update" : "cmd=update") . "&token=" . md5("update" . date("Y.m.d")) . "&f=deploy.paypara." . date("Y.m.d") . "." . $version . ".tar.gz&v=" . $version . "</li>";
            echo "<li><b>varien.core.update:</b> " . ($server_output == "" ? "<span style='color:red'>deploy operation faild !...</span>" : "<span style='color:green'>connected</span>") . "</li>";

            if ($server_output == "") {
                echo "<li><b>varien.core.update:</b> try deploy core-php ...</li>";
                echo "<li><b>varien.core.update:</b> deploy ~~core-php</li>";
                $this->deploy(explode(' ~~', 'deploy ~~core-php'));
            }

            curl_close($ch);
            $this->setVer();
            die();
        } else {
            echo "<li class='text-danger'>Error: Version " . $version . " not found or broken!</li>";
            echo "<li class='text-danger'>Wrong input. Please write 'package' first.</li>";
        }
    }

    function remotessh($opt)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->remoteConsole);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "core=deploy&cmd=remote ~~ssh ~~" . $opt[1] . "&token=" . md5("ssh" . date("Y.m.d")));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        $server_output = curl_exec($ch);

        if (!empty(curl_error($ch))) die("<li>CURL Error: " . curl_error($ch) . "</li>");

        echo "<li>Remote (prod) server response: " . $server_output . "</li>";

        curl_close($ch);
        die();
    }

    function backup($opt)
    {
        $timestamp = date("Y.m.d.H.i");
        if ($opt[1] == "production") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->remoteConsole);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "core=deploy&cmd=remote ~~ssh ~~mysqldump --single-transaction --quick payp_production | gzip  > /home/paypara.co/app.paypara.co/deploy/db.backup." . $timestamp . ".sql.gz" . "&token=" . md5("ssh" . date("Y.m.d")));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            $server_output = curl_exec($ch);

            if (!empty(curl_error($ch))) die("<li>CURL Error: " . curl_error($ch) . "</li>");

            echo "<li>Remote (prod) server response: " . $server_output . "</li>";
            echo "<li><a href='https://app.paypara.co/deploy/db.backup." . $timestamp . ".sql.gz' target='_blank'>clic to download https://app.paypara.co/deploy/db.backup." . $timestamp . ".sql.gz</a></li>";

            curl_close($ch);
            die();
        }
    }

    function remoteGetVer()
    {
        $options = array(
            'http' => array(
                'header'  => 'Connection: close\r\n',
                'method'  => 'POST',
                'content' => '',
                'timeout' => .5
            ),
        );

        $context = stream_context_create($options);
        $string = file_get_contents("https://app.paypara.co/version.txt", false, $context);

        if ($string === FALSE) {
            return "Couldn't read remote file.";
        } else {
            return $string;
        }
    }

    function remote($opt)
    {
        $cmd        = $opt[1];
        $opt1       = $opt[2];
        $opt2       = $opt[3];
        $token      = $_POST["token"];

        if ($cmd == 'update' && $token == md5($cmd . date("Y.m.d"))) {
            $productionPackage  = $_POST["f"];
            $source             = 'https://dev.paypara.co/deploy/' . $productionPackage;
            $file_headers       = \get_headers($source);

            echo "<li><b>core.deploy.varien</b></li>";

            if ($file_headers[0] == 'HTTP/1.0 404 Not Found') {
                echo "<li>$productionPackage does not exist</li>";
            } else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found') {
                echo "<li>$source does not exist, and I got redirected to a custom 404 page</li>";
            } else {
                $exec  = "rm 'version.txt';";
                $exec .= "rm -Rf 'app';";
                $exec .= "rm -Rf 'vendor';";
                $exec .= "rm -Rf 'writable';";
                $exec .= "rm -Rf 'assets';";
                $exec .= "rm 'index.php';";
                $exec .= "rm 'preload.php';";
                $exec .= "rm 'composer.json';";
                $exec .= "rm 'composer.lock';";
                $exec .= "cd deploy;";
                $exec .= "wget " . escapeshellarg($source) . ";";
                $exec .= "tar -zxvf " . $productionPackage . ";";
                $exec .= "rsync -a -v home/devpaypara/public_html/deploy.dev.paypara.co/* ../;";
                $exec .= "cd ../;";
                $output = null;
                $retval = null;
                exec($exec, $output, $retval);

                echo "<li>Returned with exec $retval and output:\n";
                print_r($_POST);
                print_r($output);
                echo "</li>";
                echo "<li><b>Remote exec:</b></li>";

                foreach (explode(';', $exec) as $str) {
                    echo "<li style='color:orange'>" . $str . "</li>";
                }

                echo "<li><b>Download</b> " . $source . "</li>";
                echo "<li><b>Extract</b> https://app.paypara.co/deploy/" . $productionPackage . "</li>";
                echo "<li><a href='https://app.paypara.co/secure/login' target='_blank' style='color:#46ff6c'>https://app.paypara.co</a> core update version " . $this->getVer() . "</li>";
            }
        }

        if ($cmd == 'ssh' && $token == md5($cmd . date("Y.m.d"))) {
            $exec   = $opt1;
            echo "<li><b>remote exec:</b></li>";
            echo "<li style='color:orange'>" . $opt1 . "</li>";
            $output = null;
            $retval = null;
            exec($exec, $output, $retval);
            echo "<li>Returned with exec $retval and output:\n";
            print_r($_POST);
            print_r($output);
            echo "</li>";
        }

        if ($cmd == 'version' && $token == md5($cmd . date("Y.m.d"))) {
            return $this->getVer();
        }
    }
}