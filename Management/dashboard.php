<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style_dashboard.css">
</head>
<body>

<div class="cont">
    <div class="header">
        <div class="small-box">
            <h1>Sales revenue </h1>
            <h3>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }

                // the following tells PDO we want it to throw Exceptions for every error.
                // this is far more useful than the default mode of throwing php errors
                $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $handler->prepare('select sum(p_preis * v_menge) as "Profit" from Produkt, Verkauft where p_id = Verkauft.f_p_id');
                $sql->execute();
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                echo $result['Profit'] . "€";
                ?>
            </h3>
        </div>
        <div class="small-box">
            <h1>Customers</h1>
            <h3>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }

                // the following tells PDO we want it to throw Exceptions for every error.
                // this is far more useful than the default mode of throwing php errors
                $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $handler->prepare('select count(*) as "Customer" from Kunde;');
                $sql->execute();
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                echo $result['Customer'];
                ?>
            </h3>
        </div>
        <div class="small-box">
            <h1>Employees</h1>
            <h3>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }

                // the following tells PDO we want it to throw Exceptions for every error.
                // this is far more useful than the default mode of throwing php errors
                $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $handler->prepare('select count(*) as "Employee" from Mitarbeiter;');
                $sql->execute();
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                echo $result['Employee'];
                ?>
            </h3>
        </div>
        <div class="small-box" style="height: 97px">
            <h2>Products never sold</h2>
            <h3>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }

                $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = $handler->prepare('select p_name from Produkt where p_id not in ( select f_p_id from Verkauft);');
                $sql->execute();
                $arr = array();
                $i = 0;
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    $arr[$i] = $result['p_name'];
                    $i++;
                }
                for ($j = 0; $j < count($arr); $j++) {
                    if ($j + 1 >= count($arr)) {
                        echo $arr[$j] . " ";
                        break;
                    }
                    echo $arr[$j] . ", ";
                }
                ?>
            </h3>
        </div>
    </div>
    <div style="clear: both; width: 100%; height: 15px"></div>
    <script src="../chart.js"></script>
    <div class="charts" style="width: 600px;float: left; margin:5px">
        <h2>Top - Most Sold Item</h2>
        <canvas id="myChart"></canvas>
        <script>
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'],
                    labels: [<?php
                        try {
                            $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                        } catch (Exception $e) {
                            print "Error!: " . $e->getMessage() . "<br/>";
                            die();
                        }

                        $sql = $handler->prepare('select p_name, sum(v_menge) as "Sold pieces" from Verkauft, Produkt where p_id = Verkauft.f_p_id group by f_p_id order by `Sold pieces` desc');
                        $sql->execute();
                        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "'" . $result['p_name'] . "',";
                        }

                        ?>],
                    datasets: [{
                        label: '# Most Sold',
                        data: [<?php
                            try {
                                $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                            } catch (Exception $e) {
                                print "Error!: " . $e->getMessage() . "<br/>";
                                die();
                            }

                            $sql = $handler->prepare('select p_name, sum(v_menge) as "pieces" from Verkauft, Produkt where p_id = Verkauft.f_p_id group by f_p_id order by `pieces` desc');
                            $sql->execute();
                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                echo $result['pieces'] . ", ";
                            }

                            ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
    <div class="charts" style="width: 300px; float: left; margin: 5px">
        <h2>Sales by Brand in €</h2>
        <canvas id="secondChart"></canvas>
        <script>
            var ctx = document.getElementById('secondChart');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'],
                    labels: [<?php
                        try {
                            $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                        } catch (Exception $e) {
                            print "Error!: " . $e->getMessage() . "<br/>";
                            die();
                        }
                        ;
                        $sql = $handler->prepare('select f_name, sum(v_menge * p_preis) as "Cash" from Verkauft, Filiale, Produkt where f_id = Verkauft.f_f_id and f_p_id = Produkt.p_id group by f_f_id order by `Cash` desc');
                        $sql->execute();
                        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "'" . $result['f_name'] . "',";
                        }

                        ?>],
                    datasets: [{
                        label: '# Most Sold',
                        data: [<?php
                            try {
                                $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                            } catch (Exception $e) {
                                print "Error!: " . $e->getMessage() . "<br/>";
                                die();
                            }

                            $sql = $handler->prepare('select f_name, sum(v_menge * p_preis) as "cash" from Verkauft, Filiale, Produkt where f_id = Verkauft.f_f_id and f_p_id = Produkt.p_id group by f_f_id order by `cash` desc');
                            $sql->execute();
                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                echo $result['cash'] . ", ";
                            }
                            ?>],
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Sales by Brand in €'
                    }
                }
            });
        </script>
    </div>
    <div class="charts" style="width: 600px; margin: 5px; float: left">
        <h2>Clients during the year</h2>
        <canvas id="thirdChart"></canvas>
        <script>
            var ctx = document.getElementById('thirdChart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: '#clients',
                        data: [<?php
                            try {
                                $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                            } catch (Exception $e) {
                                print "Error!: " . $e->getMessage() . "<br/>";
                                die();
                            }

                            for ($i = 1; $i <= 12; $i++) {
                                $sql = $handler->prepare('select count(distinct f_f_id) as "clients" from Verkauft where v_tag BETWEEN "2021-' . $i . '-01 00:00:00" and "2021-' . $i . '-31 00:00:00"');
                                $sql->execute();
                                $result = $sql->fetch(PDO::FETCH_ASSOC);
                                echo $result['clients'] . ", ";


                            }




                            ?>],
                        borderColor: "#c45850",
                    }]
                },
                options: {
                    title: {
                        display: true,
                    }
                }
            });
        </script>
    </div>
    <div style="clear: both"></div>
    <div class="charts" style="width: 600px; margin: 5px; float: left">
        <h2>Cash during the year</h2>
        <canvas id="fourthChart"></canvas>
        <script>
            var ctx = document.getElementById('fourthChart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: '#Cash',
                        data: [<?php
                            try {
                                $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                            } catch (Exception $e) {
                                print "Error!: " . $e->getMessage() . "<br/>";
                                die();
                            }

                            for ($i = 1; $i <= 12; $i++) {
                                $sql = $handler->prepare('select sum(v_menge * Produkt.p_preis) as "cost" from Verkauft, Produkt where f_p_id = Produkt.p_id and v_tag BETWEEN "2021-' . $i . '-01 00:00:00" and "2021-' . $i . '-31 00:00:00"');
                                $sql->execute();
                                $result = $sql->fetch(PDO::FETCH_ASSOC);
                                if ($result['cost'] == null) {
                                    echo "0.1, ";
                                } else {
                                    echo $result['cost'] . ", ";
                                }

                            }
                            ?>],
                        borderColor: "#3cba9f",
                    }]
                },
                options: {
                    title: {
                        display: true,
                    }
                }
            });
        </script>
    </div>
    <div class="charts" style="width: 600px;float: left; margin:5px">
        <h2>Top - Clients</h2>
        <canvas id="fifthChart"></canvas>
        <script>
            var ctx = document.getElementById('fifthChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php
                        try {
                            $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                        } catch (Exception $e) {
                            print "Error!: " . $e->getMessage() . "<br/>";
                            die();
                        }

                        $sql = $handler->prepare('select k_id, k_nachname, k_vorname, count(*) as Count from Kunde, Verkauft where f_k_id = Kunde.k_id group by f_k_id order by `Count` DESC');
                        $sql->execute();
                        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                            echo "'(" . $result['k_id'] . ')'. $result['k_nachname']. ' '. $result['k_vorname'] . "',";
                        }

                        ?>],
                    datasets: [{
                        label: '# Most Sold',
                        data: [<?php
                            try {
                                $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                            } catch (Exception $e) {
                                print "Error!: " . $e->getMessage() . "<br/>";
                                die();
                            }

                            $sql = $handler->prepare('select k_id, k_nachname, k_vorname, count(*) as count from Kunde, Verkauft where f_k_id = Kunde.k_id group by f_k_id order by `count` DESC limit 5');
                            $sql->execute();
                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                echo "'". $result['count']. "',";
                            }

                            ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>

</div>

</body>
</html>