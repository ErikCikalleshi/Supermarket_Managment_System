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
 * Load all the selected fields from the employees
 */
if (isset($_GET['id'])) {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    };
    $id = $_GET['id'];

    $stmt = $handler->prepare("Select * FROM Mitarbeiter where m_id =" . $_GET['id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="box2">
    <form action=<?php echo "update_employee.php?id=" . $id ?> method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Employee Name</span>
            <input type="text" class="form-control" name="e_name"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_vorname']?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Employee Surname</span>
            <input type="text" class="form-control" name="e_sur"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_nachname']?>" required>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Phone</span>
            <input type="text" class="form-control" name="e_phone"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_phone']?>" required>
        </div>


        <div class="input-group mb-3" id="bra">
            <span class="input-group-text" id="basic-addon1">Email</span>
            <input type="text" class="form-control" name="e_email"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_email']?>" required>
        </div>
        <div style="clear: both"></div>
        <div class="input-group mb-3" id="qua">
            <span class="input-group-text" id="basic-addon1">Address</span>
            <input type="text" class="form-control" name="e_add"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_adresse']?>" required>
        </div>

        <div class="input-group mb-3" id="bra">
            <span class="input-group-text" id="basic-addon1">PLZ</span>
            <input type="text" class="form-control" name="e_post"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_plz']?>" required>
        </div>

        <div class="input-group mb-3" >
            <span class="input-group-text" id="basic-addon1">IBAN</span>
            <input type="text" class="form-control" name="e_iban"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_iban']?>" required>
        </div>



        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Salary</span>
            <input type="text" class="form-control" name="e_salary"
                   aria-describedby="basic-addon1" value="<?php echo $result['m_gehalt']?>" required>
        </div>

        <div class="input-group mb-2" >
            <select name="brand" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Filiale where f_id = " . $result['f_f_id']);
                $sql->execute();
                $res = $sql->fetch(PDO::FETCH_ASSOC);
                echo '<option value="'. $res['f_id'].'" class= "dropdown-item" selected>' . $res['f_name'] . '</option>';
                $sql = $handler->prepare("Select * FROM Filiale");
                $sql->execute();
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item" type="button" value="' . $result['f_id'] . '">' . $result['f_name'] .'</option>';
                }
                ?>
            </select>

        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="update" style="margin-top: 10px">Update</button>
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
        $salary = (double)$_POST['e_salary'];
        $phone = (int)$_POST['e_phone'];
        $plz = (int)$_POST['e_post'];
        $brand = (int)$_POST['brand'];
        $sql = "update Mitarbeiter set m_vorname = :e_name, m_nachname = :e_sur, m_adresse = :e_add, m_email = :e_email, m_phone = :phone, m_plz = :plz, m_iban = :e_iban, m_gehalt = :salary , f_f_id = :brand where m_id =" .$id;

        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':e_name', $param_name, PDO::PARAM_STR);
        $stmt->bindParam(':e_sur', $param_surname, PDO::PARAM_STR);
        $stmt->bindParam(':e_iban', $param_iban, PDO::PARAM_STR);
        $stmt->bindParam(':salary', $param_salary, PDO::PARAM_INT);
        $stmt->bindParam(':e_email', $param_email, PDO::PARAM_STR);
        $stmt->bindParam(':e_add', $param_add, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $param_phone, PDO::PARAM_INT);
        $stmt->bindParam(':plz', $param_plz, PDO::PARAM_INT);
        $stmt->bindParam(':brand', $param_brand, PDO::PARAM_INT);

        $param_name = $_POST['e_name'];
        $param_surname = $_POST['e_sur'];
        $param_iban = $_POST['e_iban'];
        $param_phone = (int)$_POST['e_phone'];
        $param_add = $_POST['e_add'];
        $param_plz = (int)$_POST['e_post'];
        $param_email = $_POST['e_email'];
        $param_salary = (double)$_POST['e_salary'];
        $param_brand = (int)$_POST['brand'];

        if ($stmt->execute()) {
            $alert = "Your Employee was updated";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        } else {
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    } else if ($_POST['submit'] == 'back') {
        header("Location: logged_in.php?choice=2");
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