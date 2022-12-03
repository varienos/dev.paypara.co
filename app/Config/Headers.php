<?php

/*
 | --------------------------------------------------------------------
 | App Custom Headers
 | --------------------------------------------------------------------
 */
if (isset($_SERVER['HTTP_ORIGIN'])) $http_origin = $_SERVER['HTTP_ORIGIN'];

if (isset($http_origin))
{
    header("Access-Control-Allow-Origin: $http_origin");
}
header("X-Robots-Tag: noindex");
header("X-Robots-Tag: googlebot: noindex, nofollow");
header("X-Robots-Tag: otherbot: noindex, nofollow");