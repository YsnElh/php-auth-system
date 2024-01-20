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

function set_user(object $pdo,string $name, string $email,string $pwd){
    $query = "INSERT INTO users(name,email,password,created_at) VALUES(:name, :email, :password, NOW())";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hachedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    $stmt->bindParam(":name" , $name);
    $stmt->bindParam(":email" , $email);
    $stmt->bindParam(":password" , $hachedPwd);
    
    $stmt->execute();

    //Get the new user infos
    $userId = $pdo->lastInsertId();

    $selectQuery = "SELECT * FROM users WHERE id = :id";
    $selectStmt = $pdo->prepare($selectQuery);
    $selectStmt->bindParam(":id", $userId);
    $selectStmt->execute();

    return $selectStmt->fetch(PDO::FETCH_ASSOC);
}