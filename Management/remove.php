<?php
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    };
    $sql = null;
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
            $choice = 4;
        }else if ($_GET['action'] == "warehouse"){
            $sql = $handler->prepare(" delete from PF where pf_id = :id");
            $sql->bindParam(":id", $id);
            $choice = 6;
        }else if($_GET['action'] == "sales") {
            $sql = $handler->prepare(" delete from Verkauft where v_id = :id");
            $sql->bindParam(":id", $id);
            $choice = 12;
        }else if($_GET['action'] == "client") {
            $sql = $handler->prepare(" delete from Verkauft where f_k_id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            $sql = $handler->prepare(" delete from Kunde where k_id = :id");
            $sql->bindParam(":id", $id);
            $choice = 8;
        }else if($_GET['action'] == "employee") {
            $sql = $handler->prepare(" delete from Mitarbeiter where m_id = :id");
            $sql->bindParam(":id", $id);
            $choice = 2;
        }else if($_GET['action'] == "delivery_addr") {
            $sql = $handler->prepare(" delete from Kunde_Adresse where f_kl_id = :id");
            $sql->bindParam(":id", $id);
            $choice = 8;
        }
        if ($sql->execute()) {
            $alert = "Removed";
            echo "<script type='text/javascript'>alert('$alert');</script>";
            header('Location: logged_in.php?choice='.$choice);
        }else{
            $alert = "Errror";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }

