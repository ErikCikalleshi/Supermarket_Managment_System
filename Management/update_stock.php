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

    $stmt = $handler->prepare("Select * FROM PF where pf_id =" . $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $quantity = strval($result['pf_menge']);
    $f_id = $result['f_f_id'];
}
?>

<div class="box2">
    <form action=<?php echo "update_stock.php?id=" . $id ?> method="post">
        <div class="input-group mb-3">
            <select name="selected_product" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>

                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Produkt where p_id = " . $result['f_p_id']);
                $sql->execute();
                $res = $sql->fetch(PDO::FETCH_ASSOC);
                echo '<option value="'. $res['p_id'].'" class= "dropdown-item" type="button" selected>' . $res['p_name'] . '</option>';
                ?>
            </select>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Quantity</span>
            <input type="text" class="form-control" name="quantity" aria-label="quantity"
                   aria-describedby="basic-addon1" value="<?php echo $quantity ?>" required>
        </div>

        <div class="input-group mb-2" id="bra">
            <select name="brand" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 100%" required>
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
                echo '<option value="'. $res['f_id'].'" class= "dropdown-item" type="button" selected>' . $res['f_name'] . '</option>';
                $sql = $handler->prepare("Select * FROM Filiale");
                $sql->execute();
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item" type="button" value="' . $result['f_id'] . '">' . $result['f_name'] . '</option>';

                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="submit" value="update" style="margin-top: 10px">Update
        </button>
        <button type="submit" class="btn btn-primary" name="submit" value="back" style="margin-top: 10px">Back to main
            menu
        </button>

    </form>

</div>
<?php
if(isset($_POST['submit'])){
    if($_POST['submit'] == 'update'){
        $quant = (int)$_POST['quantity'];
        $brand = (int)$_POST['brand'];
        $prod = (int)$_POST['selected_product'];
        $alert = $quant ." " . $brand . " ". $prod;
        echo "<script type='text/javascript'>alert('$alert');</script>";
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update pf set pf_menge = :quant, f_f_id = :brand, f_p_id = :prod where pf_id = ". $id;
        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':quant', $param_quantity, PDO::PARAM_INT);
        $stmt->bindParam(':brand', $param_brand, PDO::PARAM_INT);
        $stmt->bindParam(':prod', $param_product, PDO::PARAM_INT);

        $param_quantity = (int)$_POST['quantity'];
        $param_brand = (int)$_POST['brand'];
        $param_product = (int)$_POST['selected_product'];
        if ($stmt->execute()) {
            $alert = "Your Item was updated into the Stock";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        } else {
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }else if ($_POST['submit'] == 'back') {
        header("Location: logged_in.php");
    }
}
?>

}

<div class="table_items" style="width: 900px; justify-content: center;
    align-items: center;
    text-align: center;
    margin-top: 10px;
    margin-left: 28.5%;">
    <table class="table table-bordered border-dark sortable">
        <thead>
        <tr>
            <th scope="col">Code</th>
            <th scope="col">Brand</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Amount</th>

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

        // the following tells PDO we want it to throw Exceptions for every error.
        // this is far more useful than the default mode of throwing php errors
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $handler->prepare("select pf_id, f_name, p_name, p_typ, pf_menge from PF, Filiale, Produkt where f_f_id = Filiale.f_id and p_id = PF.f_p_id");
        $sql->execute();
        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo '<td>' . $result['pf_id'] . '</td>';
        echo '<td>' . $result['f_name'] . '</td>';
        echo '<td>' . $result['p_name'] . '</td>';
        echo '<td>' . $result['p_typ'] . '</td>';
        echo '<td>' . $result['pf_menge'] . 'x</td>';
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