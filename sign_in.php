<div class="box">
    <form action="index.php?choice=2" method="post">

        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">First name</label>
            <input name="fName" style="width: 238.55px" type="text" class="form-control" id="validationCustom01" value="Test" required>
        </div>
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">Last name</label>
            <input name="lName" style="width: 238.55px" type="text" class="form-control" id="validationCustom02" value="123" required>
        </div>
        <div class="col-md-4">
            <label for="validationCustomUsername" class="form-label">Username</label>
            <div class="input-group has-validation" style="width: 238.55px">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input name="username" type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input name="pass" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <select name="selected" class="form-select" aria-label="Default select example" style="margin-bottom: 20px" required>
            <?php
                try {
                    $handler = new PDO('mysql:dbname=db_login;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Rolle");
                $sql->execute();
                $i = 1;
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    echo '<option class="dropdown-item" value="'.$i.'">'.$result['r_sqluser'].'</option>';
                    $i++;
                }
            ?>
        </select>
        <div class="col-12">
            <input class="btn btn-primary" type="submit"/>
        </div>
    </form>
</div>

<?php

    if(!empty($_POST['fName']) and !empty($_POST['lName']) and !empty($_POST['username']) and !empty($_POST['pass']) and !empty($_POST['selected'])){
        $index = (int)$_POST['selected'];
        $sql = "insert into Benutzer(b_vorname, b_nachname, b_user, b_pass, b_rid) values (:fname, :lName, :username, :pass, :index)";
        $stmt = $handler->prepare($sql);
        $stmt->bindParam(":fname", $param_first_name, PDO::PARAM_STR);
        $stmt->bindParam(":lName", $param_last_name, PDO::PARAM_STR);
        $stmt->bindParam(":username", $param_user_name, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $param_password, PDO::PARAM_STR);
        $stmt->bindParam(":index", $param_index, PDO::PARAM_INT);

        $param_first_name = $_POST["fName"];
        $param_last_name = $_POST["lName"];
        $param_user_name = $_POST["username"];
        $param_password = password_hash($_POST["pass"], PASSWORD_DEFAULT);
        $param_index = $_POST["selected"];
        if($stmt->execute()){
            $alert = "Your account has been created.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        } else{
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }
?>
