<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/framework/User.php";
    User::directToContent();
    $_SESSION['mode'] = 'login';

    $user = new User(null);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Logowanie </title>
    <link rel="stylesheet" href="/public/styles/form.css">
</head>

<body>
    <?= $user->getUserTable()->getFormCreator()->build() ?>
</body>

</html>

<?php
    unset($_SESSION['mode']);
?>