<?php

declare(strict_types=1);


function get_email(object $pdo, string $email){
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email" , $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $name, string $email, string $pwd) {
    $options = ['cost' => 12];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $query = "
        INSERT INTO users (name, email, password, created_at)
        VALUES (:name, :email, :password, NOW())
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPwd,
    ]);

    // Get the new user info
    $userId = $pdo->lastInsertId();

    $selectQuery = "SELECT * FROM users WHERE id = :id";
    $selectStmt = $pdo->prepare($selectQuery);
    $selectStmt->execute([':id' => $userId]);

    return $selectStmt->fetch(PDO::FETCH_ASSOC);
}