<?php

declare(strict_types=1);

function is_inputs_empty(string $email,string $pwd, string $name){
    if (empty($email) || empty($pwd) || empty($name)) {
        return true;
    }else{
        return false;
    }
}

function is_email_invalid(string $email){
    
    if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
        return false;
    }else{
        return true;
    }
}

function is_email_registred(object $pdo,string $email){
    if (get_email( $pdo , $email )) {
        return true;
    }else{
        return false;
    }
}

function is_password_invalid(string $pwd){
    $regex = '/^(?=.*[A-Za-z])(?=.*\d).{8,}$/';
    return !preg_match($regex, $pwd);
}

function create_user(object $pdo,string $name,string $email,string $pwd){
    return set_user($pdo, $name, $email, $pwd);
    
}