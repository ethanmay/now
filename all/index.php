<?php

$userGuid = "49b192ae-ac72-452a-8a94-0b096524c9a5";
$apiKey = "49b192ae-ac72-452a-8a94-0b096524c9a5:STaiZOPCSj+ldR7+/8J7QlXTHlg0wzoulud2/O+HkWOtplNF/R6wkqV7XPn/4shWfg/gMT2XbQse/gjicxUpAw==";

// Issues a query request to import.io
function query($connectorGuid, $input, $userGuid, $apiKey) {

	$url = "http://query.import.io/store/connector/" . $connectorGuid . "/_query?_user=" . urlencode($userGuid) . "&_apikey=" . urlencode($apiKey);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-Type: application/json",
		"import-io-client: import.io PHP client",
		"import-io-client-version: 2.0.0"
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode(array("input" => $input)));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$result = curl_exec($ch);
	curl_close($ch);

	return json_decode($result);
}

// Query for tile ABC News
$result = query("590a4436-2be2-4e6b-9686-b17e8db00b29", array(
  "webpage/url" => "http://abcnews.go.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Aljazeera America
$result = query("6c05b191-b04c-458d-aa58-ec6f0b023d75", array(
  "webpage/url" => "http://america.aljazeera.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile BBC News
$result = query("0d6d38e8-c537-428f-82d4-28ea5716abf5", array(
  "webpage/url" => "http://www.bbc.com/news",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile CNN
$result = query("c6d0891f-9c20-4fe8-aba4-c7b870af899f", array(
  "webpage/url" => "http://www.cnn.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Fox News
$result = query("f675c84d-6805-4e5f-86c1-06c77fae846d", array(
  "webpage/url" => "http://www.foxnews.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile GoogleNews
$result = query("56104162-a61e-4656-810f-1ff839e0f6cf", array(
  "webpage/url" => "http://news.google.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Frontline
$result = query("216ad870-d7af-400e-812b-bc6f19b8b79c", array(
  "webpage/url" => "http://www.pbs.org/wgbh/pages/frontline/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile New Republic
$result = query("eb09b2ab-d56a-4820-8eb7-58fc6a1e8e3c", array(
  "webpage/url" => "http://www.newrepublic.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Huffington Post
$result = query("1643e164-c2d8-4e32-a28c-bc1cbd34f11e", array(
  "webpage/url" => "http://www.huffingtonpost.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile New York Times
$result = query("52fad557-8a42-4213-85f8-6ef99e0fb272", array(
  "webpage/url" => "http://www.nytimes.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile NPR
$result = query("4c4f7281-0e4e-4048-b0ed-97ffbf60ec8c", array(
  "webpage/url" => "http://www.npr.org/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Reddit
$result = query("f516096f-4d02-4aab-84bb-1e2f7687360d", array(
  "webpage/url" => "http://www.reddit.com/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Reddit Top
$result = query("24db1886-24be-488e-a803-877b8fe056f4", array(
  "webpage/url" => "http://www.reddit.com/top/",
), $userGuid, $apiKey, false);
var_dump( $result );

// Query for tile Wired
$result = query("dea122bd-4535-473e-959a-604f9398d57c", array(
  "webpage/url" => "http://www.wired.com/",
), $userGuid, $apiKey, false);
var_dump( $result );