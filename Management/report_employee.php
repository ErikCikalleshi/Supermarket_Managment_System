<table class="table table-bordered border-dark sortable">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Surname</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Living Address</th>
        <th scope="col">Post Code</th>
        <th scope="col">IBAN</th>
        <th scope="col">Salary</th>
        <th scope="col">Brand</th>
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

    $sql = $handler->prepare("select * from Mitarbeiter");
    $sql->execute();
    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo '<td>' . $result['m_id'] . '</td>';
        echo '<td>' . $result['m_vorname'] . '</td>';
        echo '<td>' . $result['m_nachname'] . '</td>';
        echo '<td>' . $result['m_email'] . '</td>';
        echo '<td>' . $result['m_phone'] . '</td>';
        echo '<td>' . $result['m_adresse'] . '</td>';
        echo '<td>' . $result['m_plz'] . '</td>';
        echo '<td>' . $result['m_iban'] . '</td>';
        echo '<td>' . $result['m_gehalt'] . '</td>';
        echo '<td>' . $result['f_f_id'] . '</td>';
        echo '<td>';
        echo "<a href='update_employee.php?id={$result['m_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
        echo "<button type='button' onclick='delete_user({$result['m_id']});' class='btn btn-danger'>Delete</button>";
        echo "</tr>";
    }

    ?>
    <script>
        function delete_user(id) {
            window.location = 'remove.php?action=employee&choice=' + id;
        }
    </script>
    </tbody>
</table>