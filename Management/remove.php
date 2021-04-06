<?php
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    if(isset($_GET['choice']) and isset($_GET['action'])){
        $id = $_GET['choice'];
        if($_GET['action'] == 'product'){

            $sql = $handler->prepare(" delete from Verkauft where f_p_id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            $sql = $handler->prepare(" delete from PF where f_p_id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            $sql = $handler->prepare("delete from Produkt where p_id = :id");
            $sql->bindParam(":id", $id);

        }else if ($_GET['action'] == "warehouse"){
            $sql = $handler->prepare(" delete from PF where pf_id = :id");
            $sql->bindParam(":id", $id);
        }else if($_GET['action'] == "sales") {
            $sql = $handler->prepare(" delete from Verkauft where v_id = :id");
            $sql->bindParam(":id", $id);
        }else if($_GET['action'] == "client") {
            $sql = $handler->prepare(" delete from Verkauft where f_k_id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            $sql = $handler->prepare(" delete from Kunde where k_id = :id");
            $sql->bindParam(":id", $id);
        }
        if ($sql->execute()) {
            $alert = "Removed";
            echo "<script type='text/javascript'>alert('$alert');</script>";
            header('Location: logged_in.php');
        }else{
            $alert = "Errror";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }

?>