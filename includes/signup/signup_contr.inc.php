<?php

declare(strict_types=1);

function is_inputs_empty(string $email, string $pwd, string $name): bool {
    return empty($email) || empty($pwd) || empty($name);
}

function is_email_invalid(string $email): bool {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_email_registred(object $pdo,string $email){
    return get_email( $pdo , $email );
}

function is_password_invalid(string $pwd){
    $regex = '/^(?=.*[A-Za-z])(?=.*\d).{8,}$/';
    return !preg_match($regex, $pwd);
}

function create_user(object $pdo,string $name,string $email,string $pwd){
    return set_user($pdo, $name, $email, $pwd);
}