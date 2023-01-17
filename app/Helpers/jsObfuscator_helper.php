<?php
function jsObfuscator($source, $type = "external")
{
    $jsObfuscator     = new \App\Libraries\JsObfuscator();
    $jsCode           = $source;
    if ($type != "inline") :
        ob_start();
        readfile($source . '?v=' . md5(microtime()));
        $jsCode = ob_get_contents();
        ob_end_clean();
    endif;
    return $jsObfuscator->init($jsCode);
}