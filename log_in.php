<div class="test">
    <main class="form-signin">
        <form method="post">
            <img class="mb-4" src="logo.jpg" alt="" width="100" height="100">
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
        <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
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
    if (password_verify($_POST['pass'], $hashed_pass)) {
        session_start();
        $_SESSION['userloggedin'] = true;
        $_SESSION['id'] = $id;
        header("location: Management/logged_in.php?choice=21");
    } else {
        $alert = "Something went wrong. Please Try Again.";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }
}
?>

