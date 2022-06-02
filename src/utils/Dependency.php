<?php
    session_start();
    require_once "../../rootpath.php";

    class Dependency
    {
        // TODO: stworzenie strony z przekierowaniami dla błędów
        public static string $path = ROOTPATH;

        static function encodeJSON($file) {
           return json_decode(file_get_contents($file), true);
        }

        static function getId(): string {
            return $_GET['id'];
        }
    }