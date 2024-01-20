<?php

declare(strict_types=1);

function printErrors() {
    foreach ($_SESSION["errors_login"] ?? [] as $err) {
        echo '<p class="text-danger">' . $err . '</p>';
    }
}

function unsetSessVars() {
    unset($_SESSION["errors_login"]);
}