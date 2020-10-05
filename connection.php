<?php
$curl = curl_init();

$username = '*************************';
$dbPage = "?page=1";
$sort_perPage = "&sort=-created_at&per_page=1000";
$url = "https://api.nordic-digital.com/v1/product";

curl_setopt($curl, CURLOPT_URL, $url . $dbPage . $sort_perPage);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, "$username");
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");

$result = curl_exec($curl);
curl_close($curl);
$resulted = json_decode($result, true);

$result1 = isset($resulted['products']) ? $resulted['products'] : print_r("Ühendus puudub!!");
