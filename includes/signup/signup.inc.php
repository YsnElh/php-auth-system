<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    require_once "../env.inc.php";
    $allowedOrigins = array(APP_URL, APP_URL);
    $origin = $_SERVER['HTTP_ORIGIN'];
    
    if (in_array($origin, $allowedOrigins)) {
        header('Access-Control-Allow-Origin: ' . $origin);
    } else {
        header('HTTP/1.1 403 Forbidden');
        die();
    }

    require_once '../config_session.inc.php';

    if (!isset($_POST['_token']) && !isset($_SESSION['_token'])) {
        header('HTTP/1.1 403 Forbidden');
        echo 'Access Forbidden - token not set';
        die();
    }
    
    if ($_POST['_token'] == $_SESSION['_token']) {
        if (time() >= $_SESSION["token-expire"]) {
            die('Token expired, Reload the form');
        }
        unset($_SESSION['_token']);
        unset($_SESSION['token-expire']);
    }else{
        header('HTTP/1.1 403 Forbidden');
        echo 'Access Forbidden - token Mismatch';
        die();
    }
    
      
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
        if(!empty($email)){
            if(is_email_invalid($email)){
                $errors["invalid_email"] = "Invalid Email used!";
            }
        }
        if(is_email_registred($pdo,$email)){
            $errors["email_registred"] = "Email already registred!";
        }
        if(!empty($password)){
            if(is_password_invalid($password)){
                $errors["password_invalid"] = "Password is weak!";
            }
        }
        if($errors){
           $_SESSION["register_errors"] = $errors;
           $registerData = [
                "name" => $name,
                "email" => $email,
            ];
           $_SESSION["register_data"] = $registerData;
           header("Location: ../../signup.php");
           die();
        }
        // INSERT NEW USER
        $newUser = create_user($pdo, $name, $email, $password);
        // handle session ID

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
    }
}else{
    header("Location: ../../index.php");
    die();
}