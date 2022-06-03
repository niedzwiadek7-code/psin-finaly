<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/framework/Page/TableTemplate.php";
    require_once ROOTPATH . "/framework/User.php";

    $verifyRules = ["1", "2", "3"];
    User::verifyUser($verifyRules, '/psin-finaly/public/user/login.php');

    $table = new TableTemplate();
    echo $table->build();