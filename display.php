<script>

</script>
<?php

if(isset($_POST["add_to_cart"])){
    if(isset($_COOKIE["shopping_cart"])){
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        //search in array for specific value
        //if item not added into shopping cart
    }else{
         $cart_data = array();
    }
    $item_id_list = array_column($cart_data, 'item_id');
    if(!in_array($_GET["id"], $item_id_list)){
        $item_array = array(
            'item_id' => $_GET['id'],
            'item_name' => $_POST['hidden_name'],
            'item_price' => $_POST['hidden_price'],
            'item_quantity' => $_POST['quantity'],
        );
        $cart_data[] = $item_array;
    }else{
        foreach($cart_data as $keys => $values) {
            if ($cart_data[$keys]["item_id"] == $_GET["id"]){
                $cart_data[$keys]['item_quantity'] += $_POST['quantity'];
            }
        }
    }
    //string to json
    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 30));
    echo '<script>
        window.onload = function() {
           var y = document.getElementById("scrollTo'.$_GET['id'].'");
           var x = y.parentNode;
            
            location.href = "#"+x.id;
            window.scrollBy(0,x.getBoundingClientRect().top - 150);
        };
    </script>';
    echo '<script>  $("#n_shopping_cart").load(location.href + " #n_shopping_cart");</script>';
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach($cart_data as $keys => $values) {
            if($cart_data[$keys]['item_id'] == $_GET["id"])
            {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                echo '<script>alert("Item Removed")</script>';
            }
        }
    }
}
?>

<!-- Background image -->
<div class="bg-image shadow-1-strong"
     style=" background-image: url('https://lp-cms-production.imgix.net/2019-06/881738c6ddbbf952596fcef03364b9546adf2bb21572edee5357edf494aad3fc.jpg'); height: 95vh;">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="align-items-center" style="margin-top: 35vh">
            <div class="d-flex justify-content-center align-items-center">
                <img class="align-items-center" src="Logo1.png" alt="">
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="align-items-center"><img src="Logo2.png" alt=""></div>
            </div>
            <div class="d-flex justify-content-center align-items-center" style="margin-top: 10%">
                <a class="btn btn-outline-light btn-lg" href="#shop" role="button"
                >Shop</a>
            </div>
        </div>
    </div>
</div>
<!-- Background image -->
<main class="mt-5">
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light mb-4" id="shop">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <strong class="text-dark mr-2">Categories: </strong>

                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?sort=all&type=all&choice=51#shop">All</a>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="navbarDropdownMenuLink"
                                role="button"
                                data-mdb-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Food
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a class="dropdown-item" href="index.php?sort=all&type=fv&choice=51#shop">Fruit & Veggies</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?sort=all&type=d&choice=51#shop">Dairy & Eggs</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Meat & Fish</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Bread</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Pantry</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Sweet and Savory</a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?sort=all&&type=beverages&choice=51#shop">Beverages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?sort=beverages&choice=51#shop">Drugstore</a>
                        </li>
                        <li>
                            <div class="d-flex flex-wrap">

                                <!-- Sorting -->

                                <select class="form-select" id="filter" aria-label="Default select example">
                                    <?php
                                        if($_GET['sort'] == 'all'){
                                            echo '  <option value="0" selected>None</option> <option value="1">Lowest Price</option><option value="2">Highest Price</option>';
                                        }else if($_GET['sort'] == 'max'){
                                            echo '  <option value="0" >None</option> <option value="1" >Lowest Price</option><option value="2" selected>Highest Price</option>';
                                        }else  if($_GET['sort'] == 'min'){
                                            echo '  <option value="0" >None</option> <option value="1" selected>Lowest Price</option><option value="2" >Highest Price</option>';

                                        }
                                    ?>

                                </select>

                                <!-- Sorting -->

                            </div>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->

                <!-- Right elements -->
                <div class="d-flex align-items-center">

                        <input id="search"
                            type="text"
                            class="form-control rounded"
                            placeholder="Search"
                            aria-label="Search"
                            aria-describedby="search-addon"
                        />
                        <span class="input-group-text border-0" id="search-addon"><i class="fas fa-search"></i></span>

                </div>
                <!-- Container wrapper -->
                <script>
                    document.getElementById('search').addEventListener("keyup", function (event) {
                        if(event.key === 'Enter'){
                            window.location.href = 'index.php?sort=all&type=all&choice=51&search='+document.getElementById('search').value+'#shop';
                        }
                    });
                </script>
            </div>
        </nav>
        <!-- Products section -->
        <section class="text-center mb-4">
            <script>
                var sel = document.getElementById('filter');
                sel.onchange = function (){
                    if(sel.value == '0'){
                        window.location.href = "index.php?sort=all&type=<?php echo $_GET['type']?>&choice=51#shop"
                    }else if (sel.value == '1'){
                        sel.innerText = "Lowest Price"
                        window.location.href = "index.php?sort=min&type=<?php echo $_GET['type']?>&choice=51#shop"
                    }else {
                        sel.innerText = "Highest Price"
                        window.location.href = "index.php?sort=max&type=<?php echo $_GET['type']?>&choice=51#shop"
                    }

                }
            </script>
            <?php
            try {
                $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
            } catch (Exception $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            if (isset($_GET['type'])) {
                $sortStyle = "";
                if($_GET['sort'] == 'min'){
                    $sortStyle = "ASC";
                } else if($_GET['sort'] == 'max') {
                    $sortStyle = "DESC";
                }
                $type = array();
                $sql = null;
                $outer_count = 0;
                switch ($_GET['type']) {
                    case 'beverages':
                        $type[0] = "Beverages";
                        break;
                    case 'fv':
                        $type[0] = "Fruits";
                        $type[1] = "Vegetables";
                        break;
                    default:
                        $type[0] = "all";

                }



                $count = 0;
                $dir = "..\media";

                while($outer_count < count($type)){
                    if(!isset($_GET['search'])){
                        if($_GET['sort'] == 'all') {
                            $sql = $handler->prepare('select * from Produkt');
                        }else {
                            $sql = $handler->prepare('select * from Produkt order by p_preis '. $sortStyle);
                        }
                    }else{
                        $sql = $handler->prepare('select * from Produkt where p_name like "'. $_GET['search'].'%"');
                    }


                    $sql->execute();
                    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                        if($result['p_typ'] != $type[$outer_count] && $type[$outer_count] != "all") continue;

                        $imagePath = $dir . $result['p_image'];
                        if ($count == 0) {
                            echo ' <div class="row" id="'.$count.'"> ';
                        } else if ($count % 3 == 0) {
                            echo ' <div class="row" id="'.$count.'"> ';
                        }
                        echo ' <div class="col-lg-4 col-md-12 mb-5" id="scrollTo'. $result['p_id'].'">
                                    <form method="post" action="index.php?sort=all&type='.$_GET['type'].'&choice=51&action=add&id='. $result['p_id'].'">
                                    <div class="card">
                                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                            <img
                                                    src="' . $imagePath . '"
                                                    class="img-fluid" style="width: 200px; height: 200px"
                                            />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title" id="'. $result['p_name'].'">' . $result['p_name'] . '</h5>
                                            <h6>' . number_format($result['p_preis'] , 2) . '€</h6>
                                            <p class="card-text">
                                                Some quick example text to build on the card title and make up the bulk of the
                                                cards content
                                            </p>
                                            <input type="text" name="quantity" class="form-control" style="width: 60%; margin-left: 20%; text-align: center" value="1">
                                            <input type="hidden" name="hidden_name" value="'.$result['p_name'].'">
                                            <input type="hidden" name="hidden_price" value="'.number_format($result['p_preis'] , 2).'">
                                          
                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-rounded" style="margin-top: 10px;"><i class="fas fa-shopping-cart mr-2"></i> Add to Cart</button>
                                            <!--<input type="submit" name="add_to_cart" style="margin-top: 5px" class="btn btn-success" value="Add to Cart">-->
                                            
                                        </div>
                                        </form>
                                    </div>
                            </div>';
                        $count++;
                    }
                    $outer_count++;
                }

            }

            ?>

        </section>
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-circle d-flex justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <!-- Navbar -->

</main>
<!-- Footer -->
<footer class="bg-dark text-center text-white">
    <!-- Grid container -->
    <div class="container p-4">
        <!-- Section: Social media -->
        <section class="mb-4">
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
            ><i class="fab fa-facebook-f"></i
                ></a>

            <!-- Twitter -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
            ><i class="fab fa-twitter"></i
                ></a>

            <!-- Google -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
            ><i class="fab fa-google"></i
                ></a>

            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
            ><i class="fab fa-instagram"></i
                ></a>

            <!-- Linkedin -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
            ><i class="fab fa-linkedin-in"></i
                ></a>

            <!-- Github -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
            ><i class="fab fa-github"></i
                ></a>
        </section>
        <!-- Section: Social media -->

        <!-- Section: Form -->
        <section class="">
            <form action="">
                <!--Grid row-->
                <div class="row d-flex justify-content-center">
                    <!--Grid column-->
                    <div class="col-auto">
                        <p class="pt-2">
                            <strong>Sign up for our newsletter</strong>
                        </p>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-5 col-12">
                        <!-- Email input -->
                        <div class="form-outline form-white mb-4">
                            <input type="email" id="form5Example2" class="form-control"/>
                            <label class="form-label" for="form5Example2">Email address</label>
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-auto">
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-outline-light mb-4">
                            Subscribe
                        </button>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </form>
        </section>
        <!-- Section: Form -->

        <!-- Section: Text -->
        <section class="mb-4">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt distinctio earum
                repellat quaerat voluptatibus placeat nam, commodi optio pariatur est quia magnam
                eum harum corrupti dicta, aliquam sequi voluptate quas.
            </p>
        </section>
        <!-- Section: Text -->

        <!-- Section: Links -->
        <section class="">
            <!--Grid row-->
            <div class="row">
                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>

                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Link 1</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 2</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 3</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 4</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>

                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Link 1</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 2</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 3</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 4</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>

                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Link 1</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 2</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 3</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 4</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>

                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Link 1</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 2</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 3</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Link 4</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </section>
        <!-- Section: Links -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020 Copyright:
        <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

<!-- Background image -->
<!-- MDB -->
<script type="text/javascript" src="js/mdb.min.js"></script>
