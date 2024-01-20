<?php

declare(strict_types=1);

function generateCSRFToken() {
    $_SESSION["token-expire"] = time() + 3600; // 1 HR from Now
    $_SESSION['_token'] = bin2hex(random_bytes(32));
    echo $_SESSION['_token'];
}

function printRegisteredData(string $type) {
    $registerData = $_SESSION["register_data"] ?? [];
    switch ($type) {
        case "name":
        case "email":
            echo $registerData[$type] ?? '';
            break;
        default:
            echo '';
    }
}

function printErrors() {
    $errors = $_SESSION["register_errors"] ?? [];
    foreach ($errors as $err) {
        echo '<p class="text-danger">' . $err . '</p>';
    }
}



function unsetSessVars(){
    unset($_SESSION["register_errors"]);
    unset($_SESSION["register_data"]);
}