<div class="box2">
    <!-- enctype="multipart/form-data is similar to application/json-->
    <form action="logged_in.php?choice=3" method="post" enctype="multipart/form-data">
        <h1>Add Item</h1>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Product Name</span>
            <input type="text" class="form-control" name="name" placeholder="Coca Cola" aria-label="Cola"
                   aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Product Brand</span>
            <input type="text" class="form-control" name="brand" placeholder="Coca Cola" aria-label="Brand"
                   aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Price Per Item</span>
            <input type="text" class="form-control" name="price" placeholder="0.99" aria-label="Price"
                   aria-describedby="basic-addon1" required>
        </div>
        <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="type" style="width: 100%" required>
                <option>Select Type</option>
                <option value="Vegetables">Vegetables</option>
                <option value="Fruits">Fruits</option>
                <option value="Meat and poultry">Meat</option>
                <option value="Fish and seafood">Fish</option>
                <option value="Eggs">Eggs</option>
                <option value="Beverages">Beverages</option>
                <option value="Alcohol">Alcohol</option>
                <option value="Frozen Foods">Frozen Foods</option>
                <option value="Bread & Bakery">Bread</option>
                <option value="Breakfast & Cereal">Breakfast & Cereal</option>
                <option value="Cookies, Snacks & Candy">Cookies, Snacks & Candy</option>
                <option value="Grains, Pasta & Sides">Grains, Pasta & Sides</option>
                <option value="Pharmacy">Pharmacy</option>
                <option value="Paper Products">Paper Products</option>
            </select>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" name="desc" placeholder="Description" style="height: 100px"></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Import Image</span>
            <input type="file" class="form-control" name="image">
        </div>
        <button type="submit" class="btn btn-primary" id="submit" style="margin-top: 10px">Submit</button>
    </form>
</div>

<?php
if (!empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['brand']) and !empty($_POST['type']) and !empty($_POST['desc']) and !empty($_FILES["image"])) {
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    $pr = (double)$_POST["price"];


    $fileName = $_FILES["image"]["name"];
    $type = $_FILES["image"]["type"];
    $size = $_FILES["image"]["size"];
    $target_dir = "..\..\media";
    $isImage = false;
    $targetFilePath = $target_dir . $fileName;
    list($width, $height) = getimagesize($_FILES["image"]["tmp_name"]);

    $sql = "insert into Produkt(p_name, p_typ, p_marke, p_preis, p_besch, p_image) VALUES (:name, :type, :brand, :pr, :desc, :fileName)";

    $stmt = $handler->prepare($sql);
    $stmt->bindParam(':name', $param_name, PDO::PARAM_STR);
    $stmt->bindParam(':type', $param_type, PDO::PARAM_STR);
    $stmt->bindParam(':brand', $param_brand, PDO::PARAM_STR);
    $stmt->bindParam(':pr', $param_pr, PDO::PARAM_STR);
    $stmt->bindParam(':desc', $param_desc, PDO::PARAM_STR);
    $stmt->bindParam(':fileName', $param_img, PDO::PARAM_STR);

    if ($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" || $type == "image/gif") {
        if ($width <= 800) {
            if ($size < 5000000) {
                move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
                $isImage = true;
            } else {
                $alert = "Your File is too large. Over 5MB.";
                echo "<script type='text/javascript'>alert('$alert');</script>";
            }
        } else {
            $alert = "Image must be 500x500";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    } else {
        $alert = "Format Image not supported";
        echo "<script type='text/javascript'>alert('$alert');</script>";
    }

    $param_name = $_POST["name"];
    $param_type = $_POST["type"];
    $param_pr = $_POST["price"];
    $param_desc = $_POST["desc"];
    $param_brand = $_POST["brand"];
    $param_img = $fileName;

    if ($isImage) {

        if ($stmt->execute()) {
            $alert = "Your Item was added";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        } else {
            $alert = "I am sorry! There was some error. Try again please.";
            echo "<script type='text/javascript'>alert('$alert');</script>";
        }
    }

}
?>
