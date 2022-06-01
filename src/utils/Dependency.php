<?php
    session_start();
    require_once "../../rootpath.php";

    class Dependency
    {
        public static string $path = ROOTPATH;

        static function encodeJSON($file) {
           return json_decode(file_get_contents($file), true);
        }
    }