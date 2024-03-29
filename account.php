<?php
    require_once "./includes/config_session.inc.php";
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        die();
    }
    require_once "./includes/account/account_view.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Account</title>
</head>

<body>
    <?php include_once("./Components/header.php") ?>
    <?php print_infos() ?>
    <form action="./includes/login/logout.inc.php" method="post">
        <button class="btn btn-outline-primary m-2" type="submit">LOG OUT</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>