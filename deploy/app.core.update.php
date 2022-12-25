<?php
    date_default_timezone_set('Europe/Istanbul');
    $productionPackage  = $_POST["f"];
    $cmd                = $_POST["cmd"];
    $token              = $_POST["token"];
    $source             = 'https://dev.paypara.co/deploy/'.$productionPackage;
    $file_headers       = \get_headers($source);

    if($file_headers[0] == 'HTTP/1.0 404 Not Found'){
        echo "$productionPackage does not exist";
    } else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found'){
        echo "$filename does not exist, and I got redirected to a custom 404 page.";
    } else {


        if($cmd=='update')
        {
            $output = null;
            $retval = null;
            function getVer()
            {
                if(file_exists("../version.txt"))
                {
                    $version    = fopen("../version.txt", "r");
                    $v          = fgets($version); fclose($version);
                }else{
                    $v          = "null";
                }

                return $v;
            }
            exec('
            wget '.escapeshellarg($source).';
            rm "../version.txt";
            rm -Rf "../app";
            rm -Rf "../vendor";
            rm -Rf "../writable";
            rm -Rf "../assets";
            rm "../index.php";
            rm "../preload.php";
            rm "../composer.json";
            rm "../composer.lock";
            tar -zxvf '.$productionPackage.';
            rsync -a -v home/devpaypara/public_html/deploy.dev.paypara.co/* ../;', $output, $retval);
            echo "<li>Returned with exec $retval and output:\n";
            print_r($_POST);
            print_r($output);
            echo "</li>";
            $locale             = 'https://app.paypara.co/deploy/'.$productionPackage;
            $file_headers_locale= \get_headers($locale);
            if($file_headers_locale[0] == 'HTTP/1.0 404 Not Found'){
                echo "<li style='color:red'>$locale does not exist";
            } else if ($file_headers_locale[0] == 'HTTP/1.0 302 Found' && $file_headers_locale[7] == 'HTTP/1.0 404 Not Found</li>'){
                echo "<li style='color:red'>$locale does not exist, and I got redirected to a custom 404 page.</li>";
            } else {
                echo "<li><b>download</b> ".$source."</li>";
                echo "<li><b>extract</b> https://app.paypara.co/deploy/".$productionPackage."</li>";
                echo "<li><a href='https://app.paypara.co/secure/login' target='_blank' style='color:#46ff6c'>https://app.paypara.co</a> core update version ".getVer()."</li>";
            }
        }

    }
