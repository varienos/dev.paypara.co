<?php
function jsObfuscator($source, $type = "external")
{
    $jsCode = $source;
    $jsObfuscator = new \App\Libraries\JsObfuscator();

    if ($type != "inline") {
        ob_start();

        readfile($source . '?v=' . md5(microtime()));
        $jsCode = ob_get_contents();

        ob_end_clean();
    }

    return $jsObfuscator->init($jsCode);
}