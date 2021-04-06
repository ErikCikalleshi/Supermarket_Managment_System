<table class="table table-bordered border-dark sortable">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Surname</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Card</th>
        <th scope="col">Living Address</th>
        <th scope="col">Post Code</th>
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

    $sql = $handler->prepare("select k_id, k_vorname, k_nachname, k_email, k_phone, k_karteaddr, k_adresse, k_plz from Kunde");
    $sql->execute();
    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo '<td>' . $result['k_id'] . '</td>';
        echo '<td>' . $result['k_vorname'] . '</td>';
        echo '<td>' . $result['k_nachname'] . '</td>';
        echo '<td>' . $result['k_email'] . '</td>';
        echo '<td>' . $result['k_phone'] . '</td>';
        echo '<td>' . $result['k_karteaddr'] . '</td>';
        echo '<td>' . $result['k_adresse'] . '</td>';
        echo '<td>' . $result['k_plz'] . '</td>';
        echo '<td>';
        echo "<a href='update_client.php?id={$result['k_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
        echo "<button type='button' onclick='delete_user({$result['k_id']});' class='btn btn-danger'>Delete</button>";
        echo "</tr>";
    }

    ?>
    <script>
        function delete_user(id) {
            window.location = 'remove.php?action=client&choice=' + id;
        }
    </script>
    </tbody>
</table>