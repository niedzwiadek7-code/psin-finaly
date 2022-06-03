<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/framework/User.php";

    $verifyRules = ["1", "2", "3"];
    User::verifyUser($verifyRules, '/psin-finaly/public/user/login.php');
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Strona administratora </title>
</head>
<body>
<ul>
    <li>
        <a href="generate.php?mode=new&stage=during&table=Animal"> Zarządzaj tabelą zwierzątek </a>
    </li>
</ul>
</body>
</html>