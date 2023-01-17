<?php

namespace App\Controllers;

class Json extends BaseController
{

	public function __construct()
	{
	}

	public function resources()
	{
		$obj['getClientIpAddress']  = getClientIpAddress;
		$obj['getBrowser']          = getBrowser;
		$obj['getAgentString']      = getAgentString;
		$obj['getPlatform']         = getPlatform;
		$obj['getMobile']           = getMobile;
		$obj['getBrowserVersion']   = getBrowserVersion;
		$obj['getRandom']           = md5(\microtime());
		$obj['assetsPath'] 		    = assetsPath();
		$obj['requestMethod'] 	    = $_SERVER['REQUEST_METHOD'];
		foreach (getRolesArray() as $key => $value) {
			$obj[$key] = $value;
		}

		return $this->response->setJSON(json_encode($obj, JSON_NUMERIC_CHECK));
	}
}