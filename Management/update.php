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
/**
 * Load all the selected fields from the Products
 */
if(isset($_GET['id'])){
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $id = $_GET['id'];
    $stmt = $handler->prepare("Select * FROM Produkt where p_id =". $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="box2">
    <form action=<?php echo 'update.php?id='.$id ?> method="post">
        <h1>Update Item</h1>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Product Name</span>
            <input type="text" class="form-control" name="name" placeholder="Coca Cola" aria-label="Cola" aria-describedby="basic-addon1" value="<?php echo $result['p_name'] ?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Product Brand</span>
            <input type="text" class="form-control" name="brand" placeholder="Coca Cola" aria-label="Brand" aria-describedby="basic-addon1" value="<?php echo $result['p_marke'] ?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Price Per Item</span>
            <input type="text" class="form-control" name="price" placeholder="0.99" aria-label="Price" aria-describedby="basic-addon1" value="<?php echo $result['p_preis'] ?>"required>
        </div>
        <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="type" style="width: 100%" required>
                <option selected><?php echo $result['p_typ']?></option>
                <option value="Vegetables">Vegetables</option>
                <option value="Fruits">Fruits</option>
                <option value="Grains, legumes, nuts and seeds">Grains, legumes, nuts and seeds</option>
                <option value="Meat and poultry">Meat and poultry</option>
                <option value="Fish and seafood">Fish and seafood</option>
                <option value="Eggs">Eggs</option>
                <option value="Beverages">Beverages</option>
                <option value="Beer, Wine & Spiritss">Beer, Wine & Spiritss</option>
                <option value="Frozen Foods">Frozen Foods</option>
                <option value="Bread & Bakery">Bread & Bakery</option>
                <option value="Breakfast & Cereal">Breakfast & Cereal</option>
                <option value="Cookies, Snacks & Candy">Cookies, Snacks & Candy</option>
                <option value="Grains, Pasta & Sides">Grains, Pasta & Sides</option>
                <option value="Pharmacy">Pharmacy</option>
                <option value="Paper Products">Paper Products</option>
            </select>
        </div>
        <div class="form-floating">
            <textarea class="form-control" name="desc" placeholder="<?php echo $result['p_besch']?>" style="height: 100px"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="update" style="margin-top: 10px">Update</button>
        <button type="submit" class="btn btn-primary" name="submit" value="discard" style="margin-top: 10px">Back to main</button>
    </form>
</div>

<?php
    if(isset($_POST['submit'])) {
        if ($_POST['submit'] == 'update') {
            if (!empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['brand']) and !empty($_POST['type'])) {
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $pr = (double)$_POST["price"];
                $sql = "update produkt set p_name = :name, p_preis = :pr, p_besch = :desc, p_typ = :type, p_marke = :brand where p_id =". $_GET['id'];
                $stmt = $handler->prepare($sql);
                $stmt->bindParam(':name', $param_name, PDO::PARAM_STR);
                $stmt->bindParam(':type', $param_type, PDO::PARAM_STR);
                $stmt->bindParam(':brand', $param_brand, PDO::PARAM_STR);
                $stmt->bindParam(':pr', $param_pr, PDO::PARAM_STR);
                $stmt->bindParam(':desc', $param_desc, PDO::PARAM_STR);

                $param_name = $_POST["name"];
                $param_type = $_POST["type"];
                $param_pr = $_POST["price"];
                $param_desc = $_POST["desc"];
                $param_brand = $_POST["brand"];

                if (!$stmt->execute()) {
                    $alert = "I am sorry! There was some error. Try again please.";
                    echo "<script type='text/javascript'>alert('$alert');</script>";
                }else{
                    $alert = "Successfull";
                    echo "<script type='text/javascript'>alert('$alert');</script>";
                }
            }
        } else if($_POST['submit'] == 'discard'){
            header("Location: logged_in.php");
        }
    }


?>


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