<?php
function getStrings()
{
    $db   = \Config\Database::connect();
    return $db->query("select * from def_string order by flag asc")->getResult();


}

function getString($flag,$controller,$method)
{
    $db   = \Config\Database::connect();

    $data  = $db->query("select * from def_string where flag='" . $flag . "' and controller='" . $controller . "' and method='" . $method . "'")->getRow();

    if (count((array)$data)==0) {
        $db->query("insert into def_string set flag='" . $flag . "', controller='" . $controller . "', method='" . $method . "'");
        return $db->query("select * from def_string where id=".$db->insertID())->getRow();
    } else {

        return $data;
    }
}

function stringNormalize($string)
{
    $find 	= array("I","Ğ","Ü","Ş","İ","Ö","Ç");
    $replace= array("ı","ğ","ü","ş","i","ö","ç");
    $string= str_replace($find, $replace, $string);
    $string= preg_replace('/[^A-Za-z0-9\ığşçöüİĞÜŞÖÇ]/', ' ', $string);
    $string= trim(preg_replace('/[\t\n\r\s]+/', ' ', $string));
    return mb_convert_case(mb_strtolower($string), MB_CASE_TITLE, 'UTF-8');
}

function userNameShort($name)
{
    $str = explode(" ", $name);

    if(count($str)>0)
    {
        $strNew = substr($str[0],0,1).substr($str[1],0,1);
    }else{
        $strNew = substr($str,0,1);
    }

    return strtoupper($strNew);
}