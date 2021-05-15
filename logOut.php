<?php
    session_start();
    /*unset($_SESSION["userloggedin"]);
    unset($_SESSION["id"]);
    $par = session_get_cookie_params();
    if(ini_get("session.use_cookies")){
        setcookie(session_name(), '', time() - 42000, $par["path"], $par["domain"], $par["secure"], $par["httponly"]);
    }*/
    session_destroy();
    /*if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
        $alert = $_SESSION["id"];
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }*/
    header("Location: index.php?choice=51");
?>


