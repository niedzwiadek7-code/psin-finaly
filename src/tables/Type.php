<?php
    require_once ROOTPATH . '/framework/Table/Table.php';
    require_once ROOTPATH . '/db/Connect.php';

    class Type extends Table
    {
        private Connect $conn;
        private Array $join;
        private Array $elements;
        private Array $options;

        public function __construct($db, $branch, $query_options)
        {
            parent::__construct($db, $branch, $query_options);
        }

        public function getTableName(): string
        {
            return "Gatunek";
        }
    }