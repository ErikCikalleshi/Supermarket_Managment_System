<table class="table table-bordered border-dark sortable">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Type</th>
        <th scope="col">Cost</th>
        <th scope="col">Description</th>
        <th scope="col">Action</th>
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

    $sql = $handler->prepare("Select * FROM Produkt");
    $sql->execute();

    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo '<td>' . $result['p_id'] . '</td>';
        echo '<td>' . $result['p_name'] . '</td>';
        echo '<td>' . $result['p_typ'] . '</td>';
        echo '<td>' . $result['p_preis'] . '€</td>';
        echo '<td>' . $result['p_besch'] . '</td>';
        echo '<td>';
        echo "<a href='update.php?id={$result['p_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
        echo "<button type='button' onclick='delete_user({$result['p_id']});' class='btn btn-danger'>Delete</button>";
        echo "</tr>";

    }

    ?>
    <script>
        function delete_user(id) {
            window.location = 'remove.php?action=product&choice=' + id;
        }
    </script>
    </tbody>
</table>