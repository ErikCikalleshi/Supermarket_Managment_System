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
    };

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
        echo '<td>';
        echo "<a href='update_stock.php?id={$result['pf_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
        echo "<button type='button' onclick='delete_user({$result['pf_id']});' class='btn btn-danger'>Delete</button>";
        echo "</tr>";
    }

    ?>
    <script>
        function delete_user(id) {
            window.location = 'remove.php?action=warehouse&choice=' + id;
        }
    </script>
    </tbody>
</table>