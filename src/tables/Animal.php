<?php
    require_once '../../framework/Table.php';
    require_once '../../db/Connect.php';

    class Animal implements Table
    {
        private Connect $conn;
        private $join;

        public function __construct(Connect $conn)
        {
            $this->conn = $conn;
            $this->join = array(
                array(
                    "table" => "Klient",
                    "base_key" => "IdWlasciciel",
                    "join_key" => "IdKlient"
                ),
                array(
                    "table" => "Gatunek",
                    "base_key" => "IdGatunek",
                    "join_key" => "IdGatunek"
                )
            );
        }

        public function getTableName(): string
        {
            return "Zwierzatko";
        }

        public function queryValue($elements, $options)
        {
            $db = $this->getTableName();
            $query = "SELECT * FROM $db";
        }

        public function build($results) {
            return 'elo';
        }

        public function run($query) {
            return 'elo';
        }
    }