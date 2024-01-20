<?php

declare(strict_types=1);

function printErrors(){
    $errors = $_SESSION["errors_login"] ?? [];
    foreach ($errors as $err) {
        echo '<p class="text-danger">' . $err . '</p>';
    }
}

function unsetSessVars(){
    unset($_SESSION["errors_login"]);
}