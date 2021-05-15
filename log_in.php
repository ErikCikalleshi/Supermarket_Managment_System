<?php
    ob_start(); #The long-term answer is that all output from your PHP scripts should be buffered in variables. This includes headers and body output. Then at the end of your scripts do any output you need.
?>
<div class="container text-center" style="width: 250px; margin-top: 25vh">
    <main class="form-signin">
            <form method="post" action="index.php?choice=3">
                <img class="mb-4" src="logo.jpg" alt="" width="100px" height="100px">
                <h1 class="h3 mb-3 fw-normal">Please login</h1>
                <label for="inputUser" class="visually-hidden">username</label>
                <input name="username" type="text" id="inputUser" class="form-control" placeholder="Username"
                       required autofocus>
                <label for="inputPassword" class="visually-hidden">Password</label>
                <input name="pass" type="password" id="inputPassword" class="form-control" placeholder="Password"
                       required>
                <input class="w-100 btn btn-lg btn-primary" type="submit" name="login" value="Login"/>
            </form>
            <a href="index.php?choice=2">Sign in</a>
    </main>
</div>




<?php
if (!empty($_POST['username']) and !empty($_POST['pass'])) {
    try {
        $handler = new PDO('mysql:dbname=db_login;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    //check if user is in the db
    $userToSearch = $_POST['username'];
    $sql = "select b_user, bid, b_pass from Benutzer where b_user = :username";
    $stmt = $handler->prepare($sql);
    $stmt->bindParam(':username', $userToSearch);
    $stmt->execute();
    $row = $stmt->fetch();

    $id = $row["bid"];
    $username = $row['b_user'];
    $hashed_pass = $row['b_pass'];
    //if password is correct with the hashed than start session and redirect to the logged screen
    if (password_verify($_POST['pass'], $hashed_pass) && $_POST['username'] == 'admin') {

        $_SESSION['userloggedin'] = true;
        $_SESSION['id'] = $id;
        //header("Location: Management/logged_in.php?choice=21");
        header("location: index.php?choice=51");

    } else if (password_verify($_POST['pass'], $hashed_pass)){
        //session_start();
        $_SESSION['userloggedin'] = true;
        $_SESSION['id'] = $id;
        header("location: index.php?choice=51");
    }  else {

        $alert = "Something went wrong. Please Try Again.";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }
}
?>

