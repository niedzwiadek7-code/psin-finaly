<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/framework/Page/TableTemplate.php";

    $table = new TableTemplate();
    echo $table->build();