<script><? foreach(getRolesArray() as $key=>$value) { $script .= 'var '.$key.' = '.$value.';'; } $script.= " var gulpAssets= '".gulpAssets()."';  var coreAssets= '".coreAssets()."'; var requestMethod ='".$_SERVER['REQUEST_METHOD']."';";   echo jsObfuscator($script,'inline'); ?></script>
<script><?=jsObfuscator(getJsClientData,'inline'); ?></script>