<div class="box2">
    <form action="logged_in.php?choice=1" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Employee Name</span>
            <input type="text" class="form-control" name="e_name"
                   aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Employee Surname</span>
            <input type="text" class="form-control" name="e_sur"
                   aria-describedby="basic-addon1" required>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Phone</span>
            <input type="text" class="form-control" name="e_phone"
                   aria-describedby="basic-addon1" required>
        </div>


        <div class="input-group mb-3" id="bra">
            <span class="input-group-text" id="basic-addon1">Email</span>
            <input type="text" class="form-control" name="e_email"
                   aria-describedby="basic-addon1" required>
        </div>
        <div style="clear: both"></div>
        <div class="input-group mb-3" id="qua">
            <span class="input-group-text" id="basic-addon1">Address</span>
            <input type="text" class="form-control" name="e_add"
                   aria-describedby="basic-addon1" required>
        </div>

        <div class="input-group mb-3" id="bra">
            <span class="input-group-text" id="basic-addon1">PLZ</span>
            <input type="text" class="form-control" name="e_post"
                   aria-describedby="basic-addon1" required>
        </div>

        <div class="input-group mb-3" >
            <span class="input-group-text" id="basic-addon1">IBAN</span>
            <input type="text" class="form-control" name="e_iban"
                   aria-describedby="basic-addon1" required>
        </div>



        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Salary</span>
            <input type="text" class="form-control" name="e_salary"
                   aria-describedby="basic-addon1" required>
        </div>

        <div class="input-group mb-2" >
            <select name="brand" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>
                <option selected>Select Brand</option>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Filiale");
                $sql->execute();
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item" value="' . $result['f_id'] . '">' . $result['f_name'] .'</option>';
                }
                ?>
            </select>

        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="save" style="margin-top: 10px">Save</button>
    </form>
</div>

<?php
if (!empty($_POST['e_name']) and !empty($_POST['e_sur']) and !empty($_POST['e_phone']) and !empty($_POST['e_email']) and !empty($_POST['e_post']) and !empty($_POST['e_add'])  and !empty($_POST['e_salary']) and !empty($_POST['e_iban']) and !empty($_POST['brand'])) {
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
    $sql = "insert into Mitarbeiter(m_vorname, m_nachname, m_adresse, m_email, m_phone, m_plz, m_iban, m_gehalt, f_f_id) VALUES (:e_name, :e_sur, :e_add, :e_email, :phone, :plz, :e_iban, :salary, :brand)";

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
        $alert = "Your Employee was added";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    } else {
        $alert = "I am sorry! There was some error. Try again please.";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }
}
?>

