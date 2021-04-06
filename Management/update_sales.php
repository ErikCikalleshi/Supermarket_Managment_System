<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
if (isset($_GET['id'])) {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $id = $_GET['id'];

    $stmt = $handler->prepare("Select * FROM Verkauft where v_id =" . $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $quantity = strval($result['v_menge']);
    $f_id = $result['f_f_id'];
    $p_id = $result['f_p_id'];
    $k_id = $result['f_k_id'];
}
?>
<div class="box2">
    <form action=<?php echo "update_sales.php?id=" . $id ?> method="post">
        <div class="input-group mb-3">
            <select name="selected_client" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Kunde where k_id = " . $k_id);
                $sql->execute();
                $res = $sql->fetch(PDO::FETCH_ASSOC);
                echo '<option value="'. $res['k_id'].'" class= "dropdown-item"  selected>' . $res['k_id'].': '. $res['k_vorname'] .' '. $res['k_nachname'] .'</option>';
                $sql = $handler->prepare("Select k_id, k_vorname, k_nachname FROM Kunde");
                $sql->execute();
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item"  value="' . $result['k_id'] . '">' . $result['k_id'] . ': ' . $result['k_nachname'] . ' ' . $result['k_vorname'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <select name="selected_product" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" id="mySelection" required>
                <option selected>Select Product</option>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Produkt where p_id = " . $p_id);
                $sql->execute();

                $res = $sql->fetch(PDO::FETCH_ASSOC);
                $price = (string) $res['p_preis'];
                echo '<option value="'. $res['p_id'].'" class= "dropdown-item"  selected>' . $res['p_name'] . '</option>';

                ?>
            </select>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Quantity</span>
            <input type="text" class="form-control" name="quantity" aria-label="quantity"
                   aria-describedby="basic-addon1" value="<?php echo $quantity; ?>" required>
        </div>
        <div class="input-group mb-2" id="bra">
            <span class="input-group-text" id="basic-addon1">Price per Item</span>
            <input type="text" class="form-control" name="price" aria-label="price"
                   aria-describedby="basic-addon1" id="price" value="<?php echo $price; ?>" disabled>
        </div>


        <div class="input-group mb-2">
            <select name="brand" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }

                $sql = $handler->prepare("Select * FROM Filiale where f_id = " . $f_id);
                $sql->execute();
                $res = $sql->fetch(PDO::FETCH_ASSOC);
                echo '<option value="'. $res['f_id'].'" class= "dropdown-item" selected>' . $res['f_name'] . '</option>';
                $sql = $handler->prepare("Select * FROM Filiale");
                $sql->execute();
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item" value="' . $result['f_id'] . '">' . $result['f_name'] . '</option>';
                }
                ?>
            </select>

        </div>

        <button type="submit" class="btn btn-primary" name="submit" value="update" style="margin-top: 10px">+</button>
        <button type="submit" class="btn btn-primary" name="submit" value="main" style="margin-top: 10px">Back
        </button>

    </form>

</div>
<?php
try {
    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
} catch (Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
if (isset($_POST['submit'])){
    if ($_POST['submit'] == 'update') {
        $quant = (int)$_POST['quantity'];
        $brand = (int)$_POST['brand'];
        $client = (int)$_POST['selected_client'];
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update Verkauft set v_menge = :quant, f_k_id = :client, f_f_id = :brand where v_id = ". (int)$id;
        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':quant', $param_quantity, PDO::PARAM_INT);
        $stmt->bindParam(':brand', $param_brand, PDO::PARAM_INT);
        $stmt->bindParam(':client', $param_client, PDO::PARAM_INT);

        $param_quantity = (int)$_POST['quantity'];
        $param_brand = (int)$_POST['brand'];
        $param_client = (int)$_POST['selected_client'];
        if ($stmt->execute()) {
            $alert = "Your sale was updated";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        } else {
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }else if($_POST['submit'] == 'main'){
        header("Location: logged_in.php");
    }

}
?>
<div class="table_items" style="width: 900px; justify-content: center;
    align-items: center;
    text-align: center;
    margin-top: 10px;
    margin-left: 28.5%;">
    <table class="table table-bordered border-dark sortable">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Client ID</th>
            <th scope="col">Item Name</th>
            <th scope="col">Brand</th>
            <th scope="col">Price per Item</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Cost</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
        } catch (Exception $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        $sql = $handler->prepare('select v_id, f_k_id, p_name, f_name, p_preis, v_menge, sum(p_preis * v_menge) as "Total Cost" from Kunde, Verkauft, Produkt,  Filiale where f_k_id = Kunde.k_id and f_p_id = Produkt.p_id and f_f_id = f_id group by v_id');
        $sql->execute();
        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo '<td>' . $result['v_id'] . '</td>';
            echo '<td>' . $result['f_k_id'] . '</td>';
            echo '<td>' . $result['p_name'] . '</td>';
            echo '<td>' . $result['f_name'] . '</td>';
            echo '<td>' . $result['p_preis'] . '</td>';
            echo '<td>' . $result['v_menge'] . '</td>';
            echo '<td>' . $result['Total Cost'] . '€</td>';
            echo "</tr>";
        }

        ?>

        </tbody>
    </table>
</div>


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
</body>
</html>