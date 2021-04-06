<div class="box2">
    <form action="logged_in.php?choice=5" method="post">
        <div class="input-group mb-3">
            <select name="selected_product" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>
                <option selected>Select Product</option>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select * FROM Produkt");
                $sql->execute();

                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item" type="button" value="' . $result['p_id'] . '">' . $result['p_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="input-group mb-2" id="qua">
            <span class="input-group-text" id="basic-addon1">Quantity</span>
            <input type="text" class="form-control" name="quantity" aria-label="quantity"
                   aria-describedby="basic-addon1" required>
        </div>

        <div class="input-group mb-2" id="bra">
            <select name="brand" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 100%" required>
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
                    echo '<option class="dropdown-item" type="button" value="' . $result['f_id'] . '">' . $result['f_name'] . '</option>';

                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="submit" value="save" style="margin-top: 10px">Save</button>
        <button type="submit" class="btn btn-primary" name="submit" value="update" style="margin-top: 10px">Update
        </button>

    </form>

</div>
<?php
if (!empty($_POST['selected_product']) and !empty($_POST['quantity']) and !empty($_POST['brand'])) {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    if ($_POST['submit'] == 'save') {
        $quant = (int)$_POST['quantity'];
        $brand = (int)$_POST['brand'];
        $prod = (int)$_POST['selected_product'];
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into PF(pf_menge, f_f_id, f_p_id) SELECT :quant, :brand, :prod from DUAL where not exists(SELECT :brand, :prod from PF where f_f_id = :brand and f_p_id = :prod)";

    } else if ($_POST['submit'] == 'update') {
        $quant = (int)$_POST['quantity'];
        $brand = (int)$_POST['brand'];
        $prod = (int)$_POST['selected'];
        $sql = "update PF set pf_menge = :quant where f_f_id = :brand and f_p_id = :prod";
    }
    $stmt = $handler->prepare($sql);
    $stmt->bindParam(':quant', $param_quantity, PDO::PARAM_INT);
    $stmt->bindParam(':brand', $param_brand, PDO::PARAM_INT);
    $stmt->bindParam(':prod', $param_product, PDO::PARAM_INT);

    $param_quantity = (int)$_POST['quantity'];
    $param_brand = (int)$_POST['brand'];
    $param_product = (int)$_POST['selected_product'];
    if ($stmt->execute()) {
        $alert = "Your Item was added into the Stock";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    } else {
        $alert = "I am sorry! There was some error. Try again please.";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }
}
?>
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
