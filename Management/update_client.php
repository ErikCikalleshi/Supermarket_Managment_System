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
 * Load all the selected fields from the client
 */
if (isset($_GET['id'])) {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    };
    $id = $_GET['id'];

    $stmt = $handler->prepare("Select * FROM Kunde where k_id =" . $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="box2">
    <form action=<?php echo "update_client.php?id=" . $id ?> method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Client Name</span>
            <input type="text" class="form-control" name="c_name"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_vorname'] ?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Client Surname</span>
            <input type="text" class="form-control" name="c_sur"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_nachname'] ?>" required>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Phone</span>
            <input type="text" class="form-control" name="c_phone"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_phone'] ?>" required>
        </div>


        <div class="input-group mb-3" id="bra">
            <span class="input-group-text" id="basic-addon1">Email</span>
            <input type="text" class="form-control" name="c_email"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_email'] ?>" required>
        </div>
        <div style="clear: both"></div>
        <div class="input-group mb-3" id="qua">
            <span class="input-group-text" id="basic-addon1">Address</span>
            <input type="text" class="form-control" name="c_add"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_adresse'] ?>" required>
        </div>

        <div class="input-group mb-3" id="bra">
            <span class="input-group-text">Post Code</span>
            <input type="text" class="form-control" name="c_post"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_plz'] ?>" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Credit card</span>
            <input type="text" class="form-control" name="c_card"
                   aria-describedby="basic-addon1" value="<?php echo $result['k_karteaddr'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="update" style="margin-top: 10px">Update
        </button>
        <button type="submit" class="btn btn-primary" name="submit" value="back" style="margin-top: 10px">Back</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'update') {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    };
        $card = (int)$_POST['c_card'];
        $phone = (int)$_POST['c_phone'];
        $plz = (int)$_POST['c_post'];
        $sql = "update Kunde set k_vorname = :c_name, k_nachname = :c_sur, k_karteaddr = :card, k_email = :c_email, k_phone = :phone, k_adresse = :c_add, k_plz = :plz where k_id =" . $id;

        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':c_name', $param_name, PDO::PARAM_STR);
        $stmt->bindParam(':c_sur', $param_surname, PDO::PARAM_STR);
        $stmt->bindParam(':card', $param_card, PDO::PARAM_INT);
        $stmt->bindParam(':c_email', $param_email, PDO::PARAM_STR);
        $stmt->bindParam(':c_add', $param_add, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $param_phone, PDO::PARAM_INT);
        $stmt->bindParam(':plz', $param_plz, PDO::PARAM_INT);

        $param_name = $_POST['c_name'];
        $param_surname = $_POST['c_sur'];
        $param_card = (int)$_POST['c_card'];
        $param_phone = (int)$_POST['c_phone'];
        $param_add = $_POST['c_add'];
        $param_plz = (int)$_POST['c_post'];
        $param_email = $_POST['c_email'];

        if ($stmt->execute()) {
            $alert = "Your Client was updated";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        } else {
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    } else if ($_POST['submit'] == 'back') {
        header("Location: logged_in.php?choice=8");
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