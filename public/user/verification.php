<?php
    require_once "../../src/utils/Dependency.php";
    require_once ROOTPATH . "/framework/User.php";
    require_once ROOTPATH . "/src/templates/Information.php";
    User::checkRequest();

    $_SESSION['mode'] = 'login';

    $user = new User(array(
        'email' => $_POST['email']
    ));

    $successful_login = $user->login();
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Weryfikacja </title>
    <link rel="stylesheet" href="/public/styles/information.css">
</head>
<body>
    <?= $successful_login ?
        Information::generateUserInformation('success', 'Pomyślnie zalogowano') :
        Information::generateUserInformation('failure', 'Niepoprawny email lub hasło')
    ?>
</body>
</html>

<?php
    unset($_SESSION['mode']);
?>