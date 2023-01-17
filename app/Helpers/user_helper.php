<?php

function getUserFirms()
{
    $db     = \Config\Database::connect();
    $data   = $db->query("select perm_site from user where `id`='" . getSession('userId') . "'")->getRow();
    return strpos($data->perm_site, ",") > 0 ? explode(",", $data->perm_site) : [$data->perm_site];
}


function decodeUserId($hash)
{
    $db   = \Config\Database::connect();
    return $db->query("select id from user where hash_id='" . $hash . "'")->getRow()->id;
}

function getRoles()
{
    $db   = \Config\Database::connect();
    return $db->query("select id,name from user_role where isDelete<>1 order by `name` asc")->getResult();
}

function getRoleName($id)
{
    $db   = \Config\Database::connect();
    return $db->query("select `name` from user_role where id=$id")->getRow()->name;
}

function getAuth($id, $col)
{
    $db   = \Config\Database::connect();
    return $db->query("select `" . $col . "` from user_role where id=$id")->getRow()->$col;
}

function getRolesArray()
{
    $db         = \Config\Database::connect();
    $fields     = $db->getFieldNames('user_role');
    $array      = [];

    if (getSession('root') === false && getSession('role_id') > 0) {
        $perms      = $db->query("select * from user_role where id='" . getSession('role_id') . "'")->getResult();
        foreach ($perms as $perm) {
            foreach ($fields as $field) {
                if ($field != "id" && $field != "isDelete" && $field != "name") $array[$field] = $perm->$field == 1 ? 1 : 0;
            }
        }
    } elseif (getSession('root') === true) {

        foreach ($fields as $field) {
            if ($field != "id" && $field != "isDelete" && $field != "name") $array[$field] = true;
        }
    }

    return $array;
}