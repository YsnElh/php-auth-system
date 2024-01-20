<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    require_once "../env.inc.php";
    $allowedOrigins = array(APP_URL, APP_URL);
    $origin = $_SERVER['HTTP_ORIGIN'];
    
    if (!in_array($origin, $allowedOrigins)) {
        http_response_code(403);
        die();
    }

    $login_idn = $_POST["email"];
    $password = $_POST["password"];
    
    try {
        
        require_once '../dbh.inc.php';
        require_once 'login_modal.inc.php';
        require_once 'login-contr.inc.php';

        //ERROR HANDLER
        $errors = [];

        $result = get_user($pdo, $login_idn);
        if (is_inputs_empty($login_idn, $password)) {
            $errors["empty_inputs"] = "Fill in the required fields (*)!";
        }else{
            if (is_login_idn_wrong($result) || is_password_wrong($password, $result['password'])) {
                $errors["login_incorrect"] = "Incorrect email or password!";
            }
        }
        
        require_once '../config_session.inc.php';
        

        if($errors){
            
           $_SESSION["errors_login"] = $errors;

           header("Location: ../../login.php");
           die();
        }

        //var_dump($result);

        $newSessionID = session_create_id();
        $sessionID = $newSessionID . "_" . $result['id'];
        session_id($sessionID);

        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_name'] = htmlspecialchars($result['name']);
        $_SESSION['user_email'] = $result['email'];
        
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