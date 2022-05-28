<?php
    class Connect {
        private $server;
        private $database;

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

        public function getConnectData() {
            return array(
                "Database" => $this->database,
                "CharacterSet" => "UTF-8"
            );
        }
    }
