<?php
    session_start();
    unset($_SESSION["id"]);
    $par = session_get_cookie_params();
    if(ini_get("session.use_cookies")){
        setcookie(session_name(), '', time() - 42000, $par["path"], $par["domain"], $par["secure"], $par["httponly"]);
    }
    session_destroy();
    header("Location: ../index.php");
?>