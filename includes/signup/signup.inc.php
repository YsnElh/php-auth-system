<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    require_once "../env.inc.php";
    require_once '../config_session.inc.php';
        
    $allowedOrigins = [APP_URL, APP_URL];
    $origin = $_SERVER['HTTP_ORIGIN'];
        
    if (!in_array($origin, $allowedOrigins)) {
        http_response_code(403);
        die();
    }
    
    if (!isset($_POST['_token'], $_SESSION['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
        die('Access Forbidden - Token Mismatch or not set');
    }
    
    if (time() >= $_SESSION["token-expire"]) {
        die('Token expired, Reload the form');
    }
    
    unset($_SESSION['_token'], $_SESSION['token-expire']);
    
      
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    try {
        require_once '../dbh.inc.php';
        require_once 'signup_modal.inc.php';
        require_once 'signup_contr.inc.php';
        //ERROR HANDLER
        $errors = [];
        if(is_inputs_empty($email,$password,$name)){
            $errors["empty_inputs"] = "Fill in the required fields (*)!";
        }

        if (!empty($email) && is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid Email used!";
        }
        
        if(is_email_registred($pdo,$email)){
            $errors["email_registred"] = "Email already registred!";
        }

        if (!empty($password) && is_password_invalid($password)) {
            $errors["password_invalid"] = "Password is weak!";
        }
        
        if ($errors) {
            $_SESSION["register_errors"] = $errors;
            $_SESSION["register_data"] = ["name" => $name, "email" => $email];
                
            header("Location: ../../signup.php");
            die();
        }
        // INSERT NEW USER
        $newUser = create_user($pdo, $name, $email, $password);
        
        // Handle session ID
        $newSessionID = session_create_id();
        $sessionID = $newSessionID . "_" . $newUser['id'];
        session_id($sessionID);

        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['user_name'] = htmlspecialchars($newUser['name']);
        $_SESSION['user_email'] = $newUser['email'];
        $_SESSION['last_regeneration'] = time();

        header("Location: ../../account.php");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Query Faild: " . $e->getMessage());
    }finally{
        $pdo = null;
        $stmt = null;
    }
    
}else{
    header("Location: ../../index.php");
    die();
}