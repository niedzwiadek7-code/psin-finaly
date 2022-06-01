<?php
    class Connect {
        private string $server;
        private string $database;
        private $connection;

        public function __construct($db) {
            $this->server = "DESKTOP-HHPQOE4\WINCCPLUSMIG2014";
            $this->database = $db;
            $this->connection = $this->createConnection();
        }

        public function __destruct() {
            $this->connection = null;
        }

        public function getConnection() {
            return $this->connection;
        }

        public function createConnection() {
            try {
                $conn = new PDO("sqlsrv:server=$this->server;Database=$this->database", "", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
                return $conn;
            }
            catch(Exception $e) {
                die(print_r($e));
            }
        }

        public function getConnectData(): array {
            return array(
                "Database" => $this->database,
                "CharacterSet" => "UTF-8"
            );
        }
    }
