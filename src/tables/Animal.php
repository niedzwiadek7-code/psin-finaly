<?php
    require_once '../utils/Dependency.php';
    require_once '../../framework/Table/Table.php';
    require_once '../../db/Connect.php';

    class Animal extends Table
    {
        private Connect $conn;
        private Array $join;
        private Array $elements;
        private Array $options;

        public function __construct(Connect $conn, $join, $elements, $options)
        {
            parent::__construct($conn, $join, $elements, $options);
        }

        public function getTableName(): string
        {
            return "Zwierzatko";
        }
    }