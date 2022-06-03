<?php

class Header
{
    public static function generateTable($table)
    {
        return '<!doctype html>
                <html lang="pl">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title> ' . $table . '</title>
                    <link rel="stylesheet" href="/public/styles/table.css">
                    <link rel="stylesheet" href="/public/styles/form.css">
                    <link rel="stylesheet" href="/public/styles/information.css">
                    <link rel="stylesheet" href="/public/styles/header.css">
                </head>
                <body>
                    <header class="header">
                        <a href="/psin-finaly/public/user/logout.php" class="button"> Wyloguj </a>
                    </header>
                ';
    }
}