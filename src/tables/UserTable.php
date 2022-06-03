<?php
    require_once ROOTPATH . '/framework/Table/Table.php';
    require_once ROOTPATH . '/db/Connect.php';

    class UserTable extends Table
    {
        private Connect $conn;
        private array $join;
        private array $elements;
        private array $options;

        public function __construct($db, $branch, $query_options)
        {
            parent::__construct($db, $branch, $query_options);
        }

        public function getTableName(): string
        {
            return "Uzytkownik";
        }
    }