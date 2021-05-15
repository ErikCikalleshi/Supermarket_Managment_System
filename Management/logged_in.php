<?php
session_start();
global $choice;
$choice = "0"
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Supermarket</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Supermarket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="../style.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow sticky-top flex-md-nowrap">
    <div class="container-fluid">
        <a class="navbar-brand" href="logged_in.php?choice=21">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Employee Management
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="logged_in.php?choice=1">Add Employee</a></li>
                        <li><a class="dropdown-item" href="logged_in.php?choice=2">Employee Report</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Item Management
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="logged_in.php?choice=3">Add Item</a></li>
                        <li><a class="dropdown-item" href="logged_in.php?choice=4">Item Report</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Stock Management
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="logged_in.php?choice=5">Add Item to Stock</a></li>
                        <li><a class="dropdown-item" href="logged_in.php?choice=6">Stock Report</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sales Management
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="logged_in.php?choice=11">Add Sale</a></li>
                        <li><a class="dropdown-item" href="logged_in.php?choice=12">Sale Report</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Client Management
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="logged_in.php?choice=7">Add Client</a></li>
                        <li><a class="dropdown-item" href="logged_in.php?choice=8">Client Report</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logged_in.php?choice=9"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logged_in.php?choice=10">Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../logOut.php">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script src="../sorttable.js"></script>

<?php

if (!empty($_GET['choice'])) {
    if ($_GET['choice'] == 10) {
        include "ChangePass.php";
    } else if ($_GET['choice'] == 3) {
        include "add_item.php";
    } else if ($_GET['choice'] == 1) {
        include "add_employee.php";
    }else if ($_GET['choice'] == 4) {
        include "report_item.php";
    }else if ($_GET['choice'] == 5) {
        include "add_item_to_stock.php";
    }else if ($_GET['choice'] == 6) {
        include "report_stock.php";
    }else if ($_GET['choice'] == 7 || $choice == 7) {
        include "add_client.php";
    }else if ($_GET['choice'] == 11) {
        include "add_sale.php";
    }else if ($_GET['choice'] == 8) {
        include "client_report.php";
    }else if ($_GET['choice'] == 12) {
        include "report_sales.php";
    }else if ($_GET['choice'] == 2) {
        include "report_employee.php";
    }else if ($_GET['choice'] == 21) {
        include "dashboard.php";
    }


}
?>
</body>
</html>
