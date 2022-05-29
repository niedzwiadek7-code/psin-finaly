<?php
    class Connect {
        private string $server;
        private string $database;

        public function __construct($db) {
            $this->server = "DESKTOP-HHPQOE4\WINCCPLUSMIG2014";
            $this->database = $db;
        }

        public function getConnection() {
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
