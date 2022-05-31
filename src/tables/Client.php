<?php
require_once ROOTPATH . '/framework/Table/Table.php';
require_once ROOTPATH . '/db/Connect.php';

class Client extends Table
{
    private Connect $conn;
    private Array $join;
    private Array $elements;
    private Array $options;

    public function __construct($db, $branch)
    {
        parent::__construct($db, $branch);
    }

    public function getTableName(): string
    {
        return "Klient";
    }
}