<?php
require_once('vendor/autoload.php');
require_once('../src/Optretina/Api/OAuth/OAuth2Provider.php');
require_once('../src/Optretina/Api/OAuth/ClientCredentialsGrant.php');
require_once('../src/Optretina/Api/Client.php');


define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_ID_XXX");
define("CASE_ID", 'XXXX');

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);
$response = $client->getReport(CASE_ID);

/*
    Response:
    - success: true or false
    - content: if success = true -> File source decode in base64 . Otherwise error message.
*/
if ($response->success) {
    header('Content-Type: application/pdf');
    header('Cache-Control: public, must-revalidate, max-age=0');
    header('Pragma: public');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    echo base64_decode($response->content);
    die();
} else {
    echo $response->content;
}