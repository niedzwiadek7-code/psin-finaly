<?php
    require_once ROOTPATH . '/framework/Table/Table.php';
    require_once ROOTPATH . '/db/Connect.php';

    class Animal extends Table
    {
        private Connect $conn;
        private array $join;
        private array $elements;
        private array $options;

        public function __construct($db, $branch)
        {
            parent::__construct($db, $branch);
        }

        public function getTableName(): string
        {
            return "Zwierzatko";
        }
    }