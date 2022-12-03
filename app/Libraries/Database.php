<?php 
namespace App\Libraries;
class mysqlSync
{
    function __construct()
    {
        $this->development     = \Config\Database::connect('development');
        $this->production      = \Config\Database::connect('production');
        $this->listTables['development'] = $this->development->listTables();
        $this->listTables['production']  = $this->production->listTables();
    }

    function init()
    {
        foreach ($this->listTables['development'] as $table)
        {
            if(!$this->production->tableExists($table))
            {
                $this->createTable($table);
            }else{

                foreach ($this->development->getFieldNames($table) as $field)
                {
                    if(!$this->production->fieldExists($field->field,$table))
                    {
                        $this->createField($field->field,$table);
                    }
                }
            }
        }


    }

    function createTable($table)
    {
        $cols=null;
        $keys=null;

        foreach ($this->development->getFieldData($table) as $field)
        {
            $cols       .= "`".$field->name."` ".$field->type.($field->max_length>0?"(".$field->max_length.")":"").($field->primary_key==1?" unsigned ":"").(!$field->nullable?" NOT ":" DEFAULT ").$field->default.($field->primary_key==1?" AUTO_INCREMENT ":"").",";
        }

        foreach ($this->development->getIndexData($table) as $key)
        {
            $keys       .= $key->type." KEY `".$key->name."` (`".$key->fields[0]."`), ";
        }

        $this->production->query("CREATE TABLE `".$table."` (".$cols.",".rtrim($keys.',').") ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;");

        if(\is_array($this->production->error()))
        {
            $error = $this->production->error();
            $this->development->query("insert into log_sync_error set code='".$error['code']."',error=".$this->development->escape($error['message']).", query=".$this->development->escape($this->development->getLastQuery()).", jsonData=".$this->development->escape(json_encode($error)).", timestamp=NOW()");
        }
    }

    function createField($field,$table)
    {
        foreach ($this->development->getFieldData($table) as $field)
        {
            if($field->name==$field)
            {
                $this->production->query("ALTER TABLE `".$table."` ADD COLUMN `".$field->name."` ".$field->type.($field->max_length>0?"(".$field->max_length.")":"").($field->primary_key==1?" unsigned ":"").(!$field->nullable?" NOT ":" DEFAULT ").$field->default.($field->primary_key==1?" AUTO_INCREMENT ":"").";");

                if(\is_array($this->production->error()))
                {
                    $error = $this->production->error();
                    $this->development->query("insert into log_sync_error set code='".$error['code']."',error=".$this->development->escape($error['message']).", query=".$this->development->escape($this->production->getLastQuery()).", jsonData=".$this->development->escape(json_encode($error)).", timestamp=NOW()");

                }
            }
       }
    }

} ?>