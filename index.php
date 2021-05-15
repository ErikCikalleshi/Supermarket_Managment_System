<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>Yummy-Online-Shop</title>
    <!-- MDB icon -->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"/>
    <!-- Google Fonts Roboto -->
    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
    />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css"/>

</head>
<body>
<!-- Background image -->
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
        <div class="container-fluid">
            <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarExample01"
                    aria-controls="navbarExample01"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarExample01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="index.php?sort=all&choice=51">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item me-3 me-lg-0 dropdown">
                        <a
                                class="nav-link dropdown-toggle"
                                id="navbarDropdown"
                                role="button"
                                data-mdb-toggle="dropdown"
                                aria-expanded="false"
                        >
                            <i class="fas fa-user"></i>
                        </a>
                        <ul class=" dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="index.php?choice=3">Login</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="index.php?choice=2">Register</a>
                            </li>
                            <?php
                                if (isset($_SESSION['userloggedin'])) {
                                    echo '<li> <a class="dropdown-item" href="index.php?choice=52">Log Out</a> </li>';
                                }
                            ?>

                        </ul>
                    </li>
                    <!-- Icons -->
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href="index.php?choice=53">
                            <span class="badge badge-pill bg-danger">1</span>
                            <span><i class="fas fa-shopping-cart"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->


</header>
<?php
if (!isset($_GET['choice'])) {
    header( "Location: index.php?sort=all&choice=51");
}
if (!empty($_GET['choice'])) {
    if ($_GET['choice'] == 3) {
        include "log_in.php";
    } else if ($_GET['choice'] == 2) {
        include "sign_in.php";
    } else if ($_GET['choice'] == 1) {
        include "supermarket.php";
    } else if ($_GET['choice'] == 51) {
        include "display.php";
    }else if ($_GET['choice'] == 52) {
        include "logOut.php";
    }else if ($_GET['choice'] == 53) {
        include "checkout.php";
    }
    
}
if (isset($_POST["login"])) {
    if (empty($_POST["username"]) && empty($_POST["password"])) {
        echo '<label>All fields are required</label>';
    } else {
        try {
            $handler = new PDO('mysql:dbname=db_login;host=localhost', 'root', '');
        } catch (Exception $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>
</body>
</html>