<?php
    try {
        $handler = new PDO('mysql:dbname=supermarket;host=localhost', 'root', '');
    } catch (Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    if(isset($_GET['action2'])) {

        if ($_GET['action2'] == 'addSub') {
            echo "<script>alert('dr');</script>";
            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
            $cart_data = json_decode($cookie_data, true);
            foreach($cart_data as $keys => $values) {
                if ($cart_data[$keys]["item_id"] == $_GET["id"]){
                    if ($_GET['op'] == "add") {
                        $cart_data[$keys]['item_quantity']  += 1;
                    } else if ($_GET['op'] == "sub") {
                        if( $cart_data[$keys]['item_quantity'] > 1){
                            $cart_data[$keys]['item_quantity']  -= 1;
                        }

                    }
                }
            }
            $item_data = json_encode($cart_data);
            setcookie('shopping_cart', $item_data, time() + (86400 * 30));

        }else if($_GET['action2'] == 'delete'){
            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
            $cart_data = json_decode($cookie_data, true);
            foreach($cart_data as $keys => $values) {
                if($cart_data[$keys]['item_id'] == $_GET["id"])
                {
                    unset($cart_data[$keys]);
                    $item_data = json_encode($cart_data);
                    setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                }
            }
        }
        header('Location: index.php?choice=53');
    }

    $count = 0;
    $dir = "..\media";

?>

<div class="container">

    <!--Section: Block Content-->
    <section class="mt-5 mb-4">

        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-lg-8">

                <!-- Card -->
                <div class="card wish-list mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">Cart (<span><?php
                                if(isset($_COOKIE['shopping_cart'])){
                                    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                                    $cart_data = json_decode($cookie_data, true);
                                    echo count($cart_data);
                                }else{
                                    echo "0";
                                }

                                //echo '<script>window.location.reload()</script>'
                                ?></span> items)</h5>
                        <?php
                        if(!empty($_COOKIE["shopping_cart"])) {
                            $total = 0;
                            $counter = 0;
                            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                            $cart_data = json_decode($cookie_data, true);
                            foreach ($cart_data as $keys => $values){
                                $sql = $handler->prepare('select * from Produkt');
                                $sql->execute();
                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                    if ($values["item_id"] == $result['p_id']){
                                        $counter++;
                                        $imagePath = $dir . $result['p_image'];
                                        echo
                                            '<div class="row mb-4">
                                                <div class="col-md-5 col-lg-3 col-xl-3">
                                                     <img src="'.$imagePath.'" alt="">
                                                </div>
                                                <div class="col-md-7 col-lg-9 col-xl-9">
                                                    <div>
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <h5>'.$values['item_name'].'</h5>
                                                                <p class="mb-3 text-muted text-uppercase small">'.$result['p_besch'].'</p>
                                                            </div>
                                                            <div>
                                                                <div class="def-number-input number-input safari_only mb-0 w-100">
                                                                  
                                                                   <button type="button" class="addBtn" id="'.$values['item_id'].'" value="'.$values['item_id'].'">+</button> 
                                                                    <small id="quantity'.$counter.'" class="form-text text-muted text-center">'.$values["item_quantity"].' Piece/s</small>
                                                                   <button type="button" class="subBtn" id="'.$values['item_id'].'" value="'.$values['item_id'].'" ">-</button> 
                                                                   
                                                                  
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-end" style="margin-top:90px">
                                                            <div 
                                      
                                                                <button type="button" class="rmvBtn card-link-secondary small text-uppercase mr-3" id="'.$values['item_id'].'" value="'.$values['item_id'].'"><i class="fas fa-trash-alt mr-1"></i> Remove item</button> 
                                                 
                                                                <a href="#!" type="button" class="card-link-secondary small text-uppercase"><i class="fas fa-heart mr-1"></i> Move to wish list </a>
                                                            </div>
                                                            <p class="mb-0"><span><strong>'.$values["item_price"].'€</strong></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <hr class="mb-4">';
                                        }}}}
                        ?>
                    </div>
                </div>
                <!-- Card -->

                <!-- Card -->
                <div class="card mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">Expected shipping delivery</h5>

                        <p class="mb-0"> Thu., 12.03. - Mon., 16.03.</p>
                    </div>
                </div>
                <!-- Card -->

                <!-- Card -->
                <div class="card mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">PayPal accepts</h5>

                        <img class="mr-2" src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg" alt="Visa" width="45px">
                        <img class="mr-2" src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg" alt="American Express" width="45px">
                        <img class="mr-2" src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg" alt="Mastercard" width="45px">
                    </div>
                </div>
                <!-- Card -->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-4">

                <!-- Card -->
                <div class="card mb-4">
                    <div class="card-body">

                        <h5 class="mb-3">The total amount of</h5>

                        <ul class="list-group list-group-flush">
                            <?php
                            if(isset($_COOKIE['shopping_cart'])){
                                $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                                $cart_data = json_decode($cookie_data, true);
                                $total_amount = 0;
                                foreach($cart_data as $keys => $values) {
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                        <?php echo $values['item_name'].'   '. $values['item_quantity']. 'x' ?>
                                        <span>
                                        <?php echo $values['item_quantity'] * $values['item_price'] ?>€</span>
                                    </li>


                            <?php
                                //$total_amount += $values['item_quantity'] * $values['item_price'];
                            }
                            }else {
                                echo "0";
                            }
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Shipping
                                <span>Gratis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>The total amount of</strong>
                                    <strong>
                                        <p class="mb-0">(including IVA)</p>
                                    </strong>
                                </div>
                                <span id="price"><strong><?php
                                        if(isset($_COOKIE['shopping_cart'])) {
                                            $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                                            $cart_data = json_decode($cookie_data, true);
                                            $total_amount = 0;
                                            foreach ($cart_data as $keys => $values) {
                                                $total_amount += $values['item_quantity'] * $values['item_price'];
                                            }
                                            echo number_format($total_amount, 2);
                                        }else{
                                            echo '0.00';
                                        }
                                        ?>€

                                       </strong></span>
                            </li>
                        </ul>
                      <!--  <div id="paypal-button" style="margin-left: 20px"></div>
                        <script src="https://www.paypalobjects.com/api/checkout.js"></script>-->
                        <form action="call.php" method="post">
                            <button type="submit" class="btn btn-rounded bt btn-primary btn-block btn-lg"><i class="fab fa-lg fa-paypal pr-6 pr" aria-hidden="true"></i> Paypal</button>
                        </form>

                        <script>

                                //var data = JSON.stringify({"email": "hey@mail.com", "password": "101010"});
                                /*xmlhttp.send(JSON.stringify({
                                     "intent": "sale",
                                     "payer": {
                                         "payment_method": "paypal"
                                     },
                                     "redirect_urls": {
                                         "return_url": "http://localhost:3000/success",
                                         "cancel_url": "http://localhost:3000/cancel"
                                     },
                                     "transactions": [{
                                         "item_list": {
                                             "items": [{
                                                 "name": "Red Sox",
                                                 "sku": "001",
                                                 "price": "25.00",
                                                 "currency": "USD",
                                                 "quantity": 1
                                             }]
                                         },
                                         "amount": {
                                             "currency": "USD",
                                             "total": "25.00"
                                         },
                                         "description": "This is the payment description."
                                     }]}));
                             }*/


                        </script>



                    </div>
                </div>
                <!-- Card -->



            </div>
            <!--Grid column-->

        <!--Grid row-->

    </section>
    <!--Section: Block Content-->

</div>
<script>
    var addElements = document.getElementsByClassName("addBtn");
    // loops els
    for(var i = 0; i < addElements.length; i++) {
        addElements[i].onclick = function(){
            proceed(this.value ,"add");
            //console.log("My index number is: " + this.value)
        }
    }
    var subElements = document.getElementsByClassName("subBtn");
    for(var j = 0; j < subElements.length; j++) {
        subElements[j].onclick = function(){
            proceed(this.value ,"sub");
            //console.log("My index number is: " + this.value)
        }
    }

    var rmvElements = document.getElementsByClassName("rmvBtn");
    for(var k = 0; k < rmvElements.length; k++) {
        rmvElements[k].onclick = function(){
            var form = document.createElement('form');
            form.setAttribute('method', 'post');

            form.setAttribute('action', "index.php?sort=all&choice=53&action2=delete&id="+this.id);
            form.style.display = 'hidden';
            document.body.appendChild(form)
            form.submit();

        }
    }


    function proceed (id, op) {
        var form = document.createElement('form');
        form.setAttribute('method', 'post');

        form.setAttribute('action', 'index.php?choice=53&action2=addSub&id='+id + '&op='+ op);
        form.style.display = 'hidden';
        document.body.appendChild(form)
        form.submit();

        /*var httpc = new XMLHttpRequest(); // simplified for clarity
        var url = 'index.php?choice=53&action2=addSub&id='+id + '&op='+ op;
        httpc.open("POST", url, true); // sending as POST
        httpc.onreadystatechange = function() { //Call a function when the state changes.
            if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
                for (let i = 1; i <= <?php echo $counter ?>; i++) {
                    $("#quantity"+i).load(" #quantity"+i);
                }
                $("#price").load(" #price");
            }
        };
        httpc.send();*/
    }

</script>