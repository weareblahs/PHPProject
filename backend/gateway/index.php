<?php

require_once 'config.php';

$curl = curl_init();
$product_name = $_POST['ticketID'];
$ticketEmail = $_POST['ticketEmail'];
$product_name_order = "Order " . $product_name;
$price = $_POST['amount'];
$email = $_POST['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$vendorName = $firstName . " " . $lastName;
$preferredProtocol = "http";
$port = ":8000";
function callAPI($api_url = '', $method = 'GET', $formdata = [], $headers = [])
{
    // init curl
    $curl = curl_init();

    // assign it to curl props
    $curl_props = [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FAILONERROR => true,
        CURLOPT_CUSTOMREQUEST => $method
    ];

    // if $formdata is not empty, then we'll add in a new key called "CURLOPT_POSTFIELDS"
    if (!empty($formdata)) {
        $curl_props[CURLOPT_POSTFIELDS] = json_encode($formdata);
    }

    // if $headers is not empty, then we'll add in a new key called "CURLOPT_HTTPHEADER"
    if (!empty($headers)) {
        $curl_props[CURLOPT_HTTPHEADER] = $headers;
    }

    // setup curl
    curl_setopt_array($curl, $curl_props);

    // execute curl
    $response = curl_exec($curl);

    // var_dump($response);
    // die();



    // catch error
    $error = curl_error($curl);

    // close curl
    curl_close($curl);

    if ($error)
        return 'API not working';

    return json_decode($response);
}
$data = callAPI(
    BILLPLZ_API_URL . 'v3/bills', // https://www.billplz-sandbox.com/api/v3/bills
    'POST',
    [
        'collection_id' => BILLPLZ_COLLECTION_ID,
        'email' => $email,
        'name' => $vendorName,
        'amount' => $price * 100,
        'callback_url' => $preferredProtocol . "://" . $_SERVER['SERVER_NAME'] . $port . "/backend/gateway/postProcessing",
        'description' => $product_name_order,
        'redirect_url' => $preferredProtocol . "://" . $_SERVER['SERVER_NAME'] . $port . "/backend/gateway/postProcessing",
    ],
    [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(BILLPLZ_API_KEY . ':')
    ]
);

if (isset($data)) {
    // Use the id property for redirection
    $redirect_url = $data->url;
    header('Location: ' . $redirect_url);
    exit();
} else {
    // Handle error appropriately
    echo 'Failed to create bill. Please try again.';
}
