<div class="box2">
    <form action="logged_in.php?choice=11" method="post">
        <div class="input-group mb-3">
            <select name="selected_client" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" required>
                <option selected>Select Client</option>
                <?php
                try {
                    $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
                } catch (Exception $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                $sql = $handler->prepare("Select k_id, k_vorname, k_nachname FROM Kunde");
                $sql->execute();
                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option class="dropdown-item" type="button" value="' . $result['k_id'] . '">' . $result['k_id'] . ': '. $result['k_nachname'] . ' '. $result['k_vorname'] .'</option>';
                }
                ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <select name="selected_product" class="form-select" aria-label="Default select example"
                    style="width: 100%; height: 50px" id="mySelection" required>
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
                    echo '<option class="dropdown-item" type="button" value="' . $result['p_id'] . '|'.  $result['p_preis']. '">' . $result['p_name'] . '</option>';
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
            <span class="input-group-text" id="basic-addon1">Price per Item</span>
            <input type="text" class="form-control" name="price" aria-label="price"
                   aria-describedby="basic-addon1" id="price" disabled>
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
                    echo '<option class="dropdown-item" type="button" value="' . $result['f_id'] . '">' . $result['f_name'] .'</option>';
                }
                ?>
            </select>

        </div>

        <button type="submit" class="btn btn-primary" name="submit" value="save" style="margin-top: 10px">Add</button>

    </form>

</div>
<?php
if (!empty($_POST['selected_product']) and !empty($_POST['selected_client']) and !empty($_POST['quantity']) and !empty($_POST['brand'])) {

    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    if ($_POST['submit'] == 'save') {
        $quant = (int)$_POST['quantity'];
        $brand = (int)$_POST['brand'];
        $client = (int)$_POST['selected_client'];
        $split = explode("|",$_POST['selected_product']);
        $prod = (int)$split[0];
        //$sql = "insert into Verkauft(v_tag, v_menge, f_k_id, f_p_id, f_f_id) VALUES (now(), :quant, :client, :prod, :brand);";
        $sql = "CALL insert_sales(:quant, :brand, :prod, :client)";
    }
    $stmt = $handler->prepare($sql);
    $stmt->bindParam(':quant', $param_quantity, PDO::PARAM_INT);
    $stmt->bindParam(':brand', $param_brand, PDO::PARAM_INT);
    $stmt->bindParam(':prod', $param_product, PDO::PARAM_INT);
    $stmt->bindParam(':client', $param_client, PDO::PARAM_INT);

    $param_quantity = (int)$_POST['quantity'];
    $param_brand = (int)$_POST['brand'];
    $param_client = $_POST['selected_client'];
    $param_product = (int)$split[0];

    if ($stmt->execute()) {
        $alert = "Your Item was added into the Sales";
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
            <th scope="col">ID</th>
            <th scope="col">Client ID</th>
            <th scope="col">Item Name</th>
            <th scope="col">Price per Item</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Cost</th>
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

        $sql = $handler->prepare('select v_id, f_k_id, p_name,p_preis, v_menge, sum(p_preis * v_menge) as "Total Cost" from Kunde, Verkauft, Produkt where f_k_id = Kunde.k_id and f_p_id = Produkt.p_id group by v_id');
        $sql->execute();
        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo '<td>' . $result['v_id'] . '</td>';
            echo '<td>' . $result['f_k_id'] . '</td>';
            echo '<td>' . $result['p_name'] . '</td>';
            echo '<td>' . $result['p_preis'] . '€</td>';
            echo '<td>' . $result['v_menge'] . '</td>';
            echo '<td>' . $result['Total Cost'] . '€</td>';
            echo "</tr>";
        }

        ?>

        </tbody>
    </table>
</div>
<script>
    let mySele = document.getElementById("mySelection");
    document.getElementById("mySelection").onchange = function(){
        let split = mySele.value.split("|");
        console.log(split[1])
        document.getElementById("price").value = split[1];
    }
</script>