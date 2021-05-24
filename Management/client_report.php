<table class="table table-bordered border-dark sortable">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Surname</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Action</th>
        <th scope="col">Recent Delivery Address</th>
        <th scope="col">City</th>
        <th scope="col">Post Code</th>
        <th scope="col">Country</th>
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

    $sql = $handler->prepare("select * from Kunde, Kunde_Adresse, Lieferadresse where k_id = Kunde_Adresse.f_k_id and kl_id = Kunde_Adresse.f_kl_id;");
    $sql->execute();
    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo '<td>' . $result['k_id'] . '</td>';
        echo '<td>' . $result['k_vorname'] . '</td>';
        echo '<td>' . $result['k_nachname'] . '</td>';
        echo '<td>' . $result['k_email'] . '</td>';
        echo '<td>' . $result['k_payer_id'] . '</td>';
        echo '<td>';
        echo "<a href='update_client.php?id={$result['k_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
        echo "<button type='button' onclick='delete_user1({$result['k_id']});' class='btn btn-danger'>Delete</button>";
        echo "</td>";
        echo '<td>' . $result['kl_adresse'] . '</td>';
        echo '<td>' . $result['kl_stadt'] . '</td>';
        echo '<td>' . $result['kl_plz'] . '</td>';
        echo '<td>' . $result['kl_country_code'] . '</td>';
        echo '<td>';
        echo "<a href='update_client_address.php?id={$result['kl_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
        echo "<button type='button' onclick='delete_user2({$result['kl_id']});' class='btn btn-danger'>Delete</button>";
        echo "</tr>";
    }

    ?>
    <script>
        function delete_user1(id) {
            window.location = 'remove.php?action=client&choice=' + id;
        }

        function delete_user2(id) {
            window.location = 'remove.php?action=delivery_addr&choice=' + id;
        }
    </script>
    </tbody>
</table>