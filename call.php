<?php
// API URL
/*
$url = 'http://localhost:3000/cancel';

// Create a new cURL resource
$ch = curl_init($url);

// Setup request to send json via POST
$data = array(
    'username' => 'codexworld',
    'password' => '123456'
);
$payload = json_encode(array (
    'intent' => 'sale',
    'payer' =>
        array (
            'payment_method' => 'paypal',
        ),
    'redirect_urls' =>
        array (
            'return_url' => 'http://localhost:3000/success',
            'cancel_url' => 'http://localhost:3000/cancel',
        ),
    'transactions' =>
        array (
            0 =>
                array (
                    'item_list' =>
                        array (
                            'items' =>
                                array (
                                    0 =>
                                        array (
                                            'name' => 'Red Sox',
                                            'sku' => '001',
                                            'price' => '25.00',
                                            'currency' => 'USD',
                                            'quantity' => 1,
                                        ),
                                ),
                        ),
                    'amount' =>
                        array (
                            'currency' => 'USD',
                            'total' => '25.00',
                        ),
                    'description' => 'This is the payment description.',
                ),
        ),
));

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

$data = file_get_contents('php://input')

echo '<script>alert('.$data.')</script>';
echo '<script>console.log('.$data.')</script>';

// Close cURL resource
curl_close($ch);*/
$url = "http://localhost:3000/create_order";
$cookie_data = stripslashes($_COOKIE['shopping_cart']);
$cart_data = json_decode($cookie_data, true);
$i = 0;
$total = 0;
$item = [];

foreach($cart_data as $keys => $values) {
    $data = array('name' => $values['item_name'], 'sku' => "00".$i."",
        'price' => $values['item_price'],   'currency' => 'EUR', 'quantity' => $values['item_quantity']
    );
    $total += $values['item_price'] * $values['item_quantity'];
    array_push($item, $data);
    $i++;
}

$content = json_encode(array (
    'intent' => 'sale',
    'payer' =>
        array (
            'payment_method' => 'paypal',
        ),
    'redirect_urls' =>
        array (
            'return_url' => 'http://localhost:3000/success',
            'cancel_url' => 'http://localhost:3000/cancel',
        ),
    'transactions' =>
        array (
            0 =>
                array (
                    'item_list' =>
                        array (
                            'items' => $item
                        ),
                    'amount' =>
                        array (
                            'currency' => 'EUR',
                            'total' => strval($total),
                        ),
                    'description' => 'This is the payment description.',
                ),
        ),
));

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER,
    array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}

header('Location: '. $json_response);

curl_close($curl);

$response = json_decode($json_response, true);

echo "<script>window.close();</script>";

