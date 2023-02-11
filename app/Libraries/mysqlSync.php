<?php

namespace App\Libraries;

class mysqlSync
{
    function __construct()
    {
        $this->development = \Config\Database::connect('development');
        $this->production = \Config\Database::connect('production');
    }

    function init()
    {
        $this->getTables['development'] = $this->development->listTables();
        $this->getTables['production']  = $this->production->listTables();
        echo '<li>databeses sync start ....... source: development target: production</li>';
        echo '<li>check table development tables ....... </li>';

        foreach ($this->getTables['development'] as $table) {
            echo '<li>check table ....... `' . $table . "`</li>";
            if (!$this->production->tableExists($table)) {
                echo '<li><b>create</b> table ....... `' . $table . "`</li>";
                $this->createTable($table);
            } else {
                echo '<li>check table development table fields ....... </li>';
                foreach ($this->development->getFieldNames($table) as $field) {
                    echo '<li>check table `' . $table . '` field ....... `' . $field . "`</li>";
                    if (!$this->production->fieldExists($field, $table)) {
                        echo "<li><b>create</b> table `" . $table . "` field ....... `" . $field . "`</li>";
                        $this->createField($field, $table);
                    }
                }

                foreach ($this->production->getFieldNames($table) as $field) {
                    echo '<li>check table development tables removed fields ....... </li>';
                    if (!$this->development->fieldExists($field, $table)) {
                        echo "<li><b>remove</b> table `" . $table . "` field ....... `" . $field . "`</li>";
                        $this->dropField($field, $table);
                    }
                }
            }
        }

        echo '<li style="color:green">databeses sync end ....... source: development target: production</li>';
    }

    function createTable($table)
    {
        $cols = null;
        $keys = null;

        foreach ($this->development->getFieldData($table) as $field) {
            $cols .= "`" . $field->name . "` " . $field->type . ($field->max_length > 0 ? "(" . $field->max_length . ")" : "") . ($field->type == 'text' || $field->type == 'varchar' ? " CHARACTER SET utf8 COLLATE utf8_general_ci " : "") . ($field->primary_key == 1 ? " unsigned " : "") . (!$field->nullable ? " NOT " : " DEFAULT ") . (!empty($field->default) ? " " . $field->default . " " : " NULL ") . ($field->primary_key == 1 ? " AUTO_INCREMENT " : "") . ",";
        }

        foreach ($this->development->getIndexData($table) as $key) {
            $keys .= $key->type . " KEY `" . $key->name . "` (`" . $key->fields[0] . "`),";
        }

        $query = "CREATE TABLE `" . $table . "` (" . $cols . rtrim($keys, ',') . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        echo "<b>query:</b> " . $query . "</li>";
        $this->production->query($query);

        if (\is_array($this->production->error())) {
            $error = $this->production->error();
            $this->development->query("insert into log_sync_error set code='" . $error['code'] . "',error=" . $this->development->escape($error['message']) . ", query=" . $this->development->escape($this->development->getLastQuery()) . ", jsonData=" . $this->development->escape(json_encode($error)) . ", timestamp=NOW()");
        }
    }

    function createField($fieldName, $table)
    {
        foreach ($this->development->getFieldData($table) as $field) {
            if ($field->name == $fieldName) {
                $query = "ALTER TABLE `" . $table . "` ADD COLUMN `" . $field->name . "` " . $field->type . ($field->max_length > 0 ? "(" . $field->max_length . ")" : "") . ($field->type == 'text' || $field->type == 'varchar' ? " CHARACTER SET utf8 COLLATE utf8_general_ci " : "") . ($field->primary_key == 1 ? " unsigned " : "") . (!$field->nullable ? " NOT " : " DEFAULT ") . (!empty($field->default) ? " " . $field->default . " " : " NULL ") . ($field->primary_key == 1 ? " AUTO_INCREMENT " : "") . ";";
                echo "<b>query:</b> " . $query . "</li>";
                $this->production->query($query);

                if (\is_array($this->production->error())) {
                    $error = $this->production->error();
                    $this->development->query("insert into log_sync_error set code='" . $error['code'] . "',error=" . $this->development->escape($error['message']) . ", query=" . $this->development->escape($this->production->getLastQuery()) . ", jsonData=" . $this->development->escape(json_encode($error)) . ", timestamp=NOW()");
                }
            }
        }
    }

    function dropField($field, $table)
    {
        $query = "ALTER TABLE `" . $table . "` DROP `" . $field . "`;";
        echo "<li><b>query:</b> " . $query . "</li>";
        $this->production->query($query);

        if (\is_array($this->production->error())) {
            $error = $this->production->error();
            $this->development->query("insert into log_sync_error set code='" . $error['code'] . "',error=" . $this->development->escape($error['message']) . ", query=" . $this->development->escape($this->production->getLastQuery()) . ", jsonData=" . $this->development->escape(json_encode($error)) . ", timestamp=NOW()");
        }
    }
}