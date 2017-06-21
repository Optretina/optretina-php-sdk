<?php
require_once('vendor/autoload.php');
require_once('../src/Optretina/Api/OAuth/OAuth2Provider.php');
require_once('../src/Optretina/Api/OAuth/ClientCredentialsGrant.php');
require_once('../src/Optretina/Api/Client.php');


define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_SECRET_XXX");
define("CASO_ID", 'XXXXXX');

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);

$response = $client->uploadImages(CASO_ID,[
    'images' => array(
        './images/2.jpg', //Local path
    )
]);

/*
    Response:
    - success: true or false
    - content: if success = true -> id value. Otherwise error message.
*/
if ($response->success) {
    echo $response->content;
} else {
    //Error
    echo $response->content;
}
