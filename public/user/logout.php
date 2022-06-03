<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/framework/User.php";
    require_once ROOTPATH . "/src/templates/Information.php";

    User::deleteUserFromSession();
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Wylogowano </title>
    <link rel="stylesheet" href="/public/styles/information.css">
</head>
<body>
    <?= Information::generateUserInformation("logout", "Pomyślnie wylogowano") ?>
</body>
</html>