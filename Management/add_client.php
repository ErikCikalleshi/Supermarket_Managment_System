
<div class="box2">
    <h5>Function temporarily disabled - <br> Client is automatically added during the payment with PayPal</h5>
    <form action="logged_in.php?choice=7" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Client Name</span>
            <input type="text" class="form-control" name="c_name"
                       aria-describedby="basic-addon1" disabled>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Client Surname</span>
            <input type="text" class="form-control" name="c_sur"
                   aria-describedby="basic-addon1" required>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Phone</span>
            <input type="text" class="form-control" name="c_phone"
                   aria-describedby="basic-addon1" disabled>
        </div>


        <div class="input-group mb-3" id="bra">
            <span class="input-group-text" id="basic-addon1">Email</span>
            <input type="text" class="form-control" name="c_email"
                   aria-describedby="basic-addon1" disabled>
        </div>
        <div style="clear: both"></div>
        <div class="input-group mb-3" id="qua">
            <span class="input-group-text" id="basic-addon1">Address</span>
            <input type="text" class="form-control" name="c_add"
                   aria-describedby="basic-addon1" disabled>
        </div>

        <div class="input-group mb-3" id="bra">
            <span class="input-group-text">Post Code</span>
            <input type="text" class="form-control" name="c_post"
                   aria-describedby="basic-addon1" disabled>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Credit card</span>
            <input type="text" class="form-control" name="c_card"
                   aria-describedby="basic-addon1" disabled>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="save" style="margin-top: 10px">Save</button>
    </form>
</div>

<?php
if (!empty($_POST['c_name']) and !empty($_POST['c_sur']) and !empty($_POST['c_phone']) and !empty($_POST['c_email']) and !empty($_POST['c_post']) and !empty($_POST['c_add']) and !empty($_POST['c_card'])) {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    };
    $card = (int)$_POST['c_card'];
    $phone = (int)$_POST['c_phone'];
    $plz = (int)$_POST['c_post'];
    $sql = "insert into Kunde(k_vorname, k_nachname, k_karteaddr, k_email, k_phone, k_adresse, k_plz) VALUES (:c_name, :c_sur, :card, :c_email, :phone, :c_add, :c_post)";

    $stmt = $handler->prepare($sql);
    $stmt->bindParam(':c_name', $param_name, PDO::PARAM_STR);
    $stmt->bindParam(':c_sur', $param_surname, PDO::PARAM_STR);
    $stmt->bindParam(':card', $param_card, PDO::PARAM_INT);
    $stmt->bindParam(':c_email', $param_email, PDO::PARAM_STR);
    $stmt->bindParam(':c_add', $param_add, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $param_phone, PDO::PARAM_INT);
    $stmt->bindParam(':c_post', $param_plz, PDO::PARAM_INT);

    $param_name = $_POST['c_name'];
    $param_surname = $_POST['c_sur'];
    $param_card = (int)$_POST['c_card'];
    $param_phone = (int)$_POST['c_phone'];
    $param_add = $_POST['c_add'];
    $param_plz = (int)$_POST['c_post'];
    $param_email = $_POST['c_email'];

    if ($stmt->execute()) {
        $alert = "Your Client was added";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    } else {
        $alert = "I am sorry! There was some error. Try again please.";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }
}
?>

