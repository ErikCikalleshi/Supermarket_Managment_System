
<div class="box">
    <form action="logged_in.php?choice=5" method="post">
        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">Old_Password</label>
            <input name="oPassword" style="width: 238.55px" type="text" class="form-control" id="validationCustom01" value="Test" required>
        </div>
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">New_Password</label>
            <input name="nPassword"style="width: 238.55px" type="text" class="form-control" id="validationCustom02" value="123" required>
        </div>
        <div class="col-12" style="margin-top: 10px">
            <input class="btn btn-primary" type="submit"/>
        </div>
    </form>
</div>

<?php

    try {
        $handler = new PDO('mysql:dbname=db_login;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    if (!empty($_POST['nPassword']) and !empty($_POST['oPassword'])) {

        $userToSearch = $_SESSION['id'];
        echo $userToSearch;
        $sql = "select bid, b_pass from Benutzer where bid = :id";
        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':id', $userToSearch, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();

        $hashed_pass = $row['b_pass'];
        if (password_verify($_POST['oPassword'], $hashed_pass)) {
            $sql = "UPDATE Benutzer SET b_pass = :nPassword WHERE bid = :id";
            $stmt = $handler->prepare($sql);
            $stmt->bindParam(":nPassword", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userToSearch, PDO::PARAM_STR);
            $param_password = password_hash($_POST["nPassword"], PASSWORD_DEFAULT);
            if($stmt->execute()){
                $alert = "Your password has been updated.";
                echo "<script type='text/javascript'>alert('$alert');</script>";
            } else{
                $alert = "I am sorry! There was some error. Try again please.";
                echo "<script type='text/javascript'>alert('$alert');</script>";
            }
        }else{
            $alert = "Your original Password is wrong";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }
?>