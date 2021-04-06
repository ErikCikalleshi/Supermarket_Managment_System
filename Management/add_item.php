<div class="box2">
    <form action="logged_in.php?choice=3" method="post">
        <h1>Add Item</h1>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Product Name</span>
            <input type="text" class="form-control" name="name" placeholder="Coca Cola" aria-label="Cola" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Product Brand</span>
            <input type="text" class="form-control" name="brand" placeholder="Coca Cola" aria-label="Brand" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Price Per Item</span>
            <input type="text" class="form-control" name="price" placeholder="0.99" aria-label="Price" aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="type" style="width: 100%">
                <option selected>Select Type</option>
                <option value="Vegetables">Vegetables</option>
                <option value="Fruits">Fruits</option>
                <option value="Grains, legumes, nuts and seeds">Grains, legumes, nuts and seeds</option>
                <option value="Meat and poultry">Meat and poultry</option>
                <option value="Fish and seafood">Fish and seafood</option>
                <option value="Eggs">Eggs</option>
                <option value="Beverages">Beverages</option>
                <option value="Beer, Wine & Spiritss">Beer, Wine & Spiritss</option>
                <option value="Frozen Foods">Frozen Foods</option>
                <option value="Bread & Bakery">Bread & Bakery</option>
                <option value="Breakfast & Cereal">Breakfast & Cereal</option>
                <option value="Cookies, Snacks & Candy">Cookies, Snacks & Candy</option>
                <option value="Grains, Pasta & Sides">Grains, Pasta & Sides</option>
                <option value="Pharmacy">Pharmacy</option>
                <option value="Paper Products">Paper Products</option>
            </select>
        </div>
        <div class="form-floating">
           <textarea class="form-control" name="desc" placeholder="Description" style="height: 100px"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="submit" style="margin-top: 10px">Submit</button>
    </form>
</div>

<?php
    if (!empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['brand']) and  !empty($_POST['type']) and !empty($_POST['desc'])) {
        try {
            $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
        } catch (Exception $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        $pr = (double)$_POST["price"];
        $sql = "insert into Produkt(p_name, p_typ, p_marke, p_preis, p_besch) VALUES (:name, :type, :brand, :pr, :desc)";
        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':name', $param_name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $param_type, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $param_brand, PDO::PARAM_STR);
        $stmt->bindParam(':pr', $param_pr, PDO::PARAM_STR);
        $stmt->bindParam(':desc', $param_desc, PDO::PARAM_STR);

        $param_name = $_POST["name"];
        $param_type = $_POST["type"];
        $param_pr = $_POST["price"];
        $param_desc = $_POST["desc"];
        $param_brand = $_POST["brand"];

        if(!$stmt->execute()){
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }
?>
