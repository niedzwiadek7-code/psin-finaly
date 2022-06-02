<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/db/Connect.php";
    require_once ROOTPATH . "/src/tables/Animal.php";

    $_SESSION['mode'] = 'new';
    $animal = new Animal('nb8', 'main', null);

    if (isset($_GET['flag'])) {
        $animal->getDataManager();
    }

?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zwierzątka</title>
    <link rel="stylesheet" href="/public/styles/table.css">
    <link rel="stylesheet" href="/public/styles/form.css">
</head>
<body>
    <?= $animal->build() ?>

    <?= $animal->getFormCreator()->build() ?>
</body>
</html>

<?php
    unset($_SESSION['mode']);
    unset($_SESSION['object']);
?>