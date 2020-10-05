<?php
error_reporting(0);
$resources_link =  $_POST['resourses'];
$stock_link = $_POST['stock'];
$username = '************************';
$url1 = 'https://api.nordic-digital.com';

$curl_resource = curl_init();
$curl_stock = curl_init();

curl_setopt($curl_resource, CURLOPT_URL, $url1 . $resources_link);
curl_setopt($curl_stock, CURLOPT_URL, $url1 . $stock_link);
curl_setopt($curl_resource, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_stock, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_resource, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl_stock, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl_resource, CURLOPT_USERPWD, "$username");
curl_setopt($curl_stock, CURLOPT_USERPWD, "$username");
curl_setopt($curl_resource, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl_stock, CURLOPT_CUSTOMREQUEST, "GET");

$resources = curl_exec($curl_resource);
$stock = curl_exec($curl_stock);
curl_close($curl_resource);
curl_close($curl_stock);
$resources1 = json_decode($resources, true);
$stock1 = json_decode($stock, true);

$image = $resources1['resources']['images'][0]['url'];
$prices = $stock1['stock'][0]['prices']['rrp'];
$quantity = $stock1['stock'][0]['quantity'];

if (isset($image)) {
    echo '<img src="' . $image . '" width="100%" height="auto">';
} else {
    echo 'Pilt puudub!';
}

if (isset($prices)) {
    echo '<p>Hind: ' . $prices . '.-</p>';
} else {
    echo '<p>Hind: Hind puudub!</p>';
}

if (isset($quantity)) {
    echo '<p>Kogus: ' . $quantity . ' tk.</p>';
} else {
    echo '<p>Kogus: Kogus puudub!</p>';
}
