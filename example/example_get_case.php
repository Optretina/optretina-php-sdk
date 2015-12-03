<?php
require_once('vendor/autoload.php');
require_once('../src/Optretina/Api/OAuth/OAuth2Provider.php');
require_once('../src/Optretina/Api/OAuth/ClientCredentialsGrant.php');
require_once('../src/Optretina/Api/Client.php');


define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_SECRET_XXX");
define("CASE_ID", "XXXX");

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);
$response = $client->getCase(CASE_ID);
/*
    Response:
    - success: true or false
    - content: if success = true -> Case object. Otherwise error message.
*/
if ($response->success) {
    echo "<pre>";
        var_dump($response->content);
    echo "</pre>";
} else {
    //Error
    echo $response->content;
}

