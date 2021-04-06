<div class="table_items">
    <table class="table table-bordered border-dark sortable">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Client</th>
            <th scope="col">Item Name</th>
            <th scope="col">Price per Item</th>
            <th scope="col">Brand</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Cost</th>
            <th scope="col">Date</th>
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

        $sql = $handler->prepare('select *, sum(p_preis * v_menge) as "Total Cost" from Kunde, Verkauft, Produkt, Filiale where f_k_id = Kunde.k_id and f_p_id = Produkt.p_id and f_f_id = Filiale.f_id group by v_id');
        $sql->execute();
        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo '<td>' . $result['v_id'] . '</td>';
            echo '<td>' . $result['f_k_id'] . ': '. $result['k_vorname'].  ' ' . $result['k_nachname']. '</td>';
            echo '<td>' . $result['p_name'] . '</td>';
            echo '<td>' . $result['p_preis'] . '€</td>';
            echo '<td>' . $result['f_name'] . '</td>';
            echo '<td>' . $result['v_menge'] . 'x</td>';
            echo '<td>' . $result['Total Cost'] . '€</td>';
            echo '<td>' . $result['v_tag'] . '</td>';
            echo '<td>';
            echo "<a href='update_sales.php?id={$result['v_id']}' class='btn btn-primary m-r-1em'>Edit</a>";
            echo "<button type='button' onclick='delete_user({$result['v_id']});' class='btn btn-danger'>Delete</button>";
            echo "</tr>";
        }

        ?>
        <script>
            function delete_user(id) {
                window.location = 'remove.php?action=sales&choice=' + id;
            }
        </script>
        </tbody>
    </table>
</div>
