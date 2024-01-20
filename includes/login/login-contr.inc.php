<?php

declare(strict_types=1);


function is_inputs_empty(string $email, string $pwd): bool {
    return empty($email) || empty($pwd);
}

function is_login_idn_wrong(array|bool $res): bool {
    return !$res;
}

function is_password_wrong(string $pwd, string $hashedPwd): bool {
    return !password_verify($pwd, $hashedPwd);
}