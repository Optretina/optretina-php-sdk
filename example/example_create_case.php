<?php
require_once('vendor/autoload.php');
require_once('../src/Optretina/Api/OAuth/OAuth2Provider.php');
require_once('../src/Optretina/Api/OAuth/ClientCredentialsGrant.php');
require_once('../src/Optretina/Api/Client.php');


define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_SECRET_XXX");


define("MALE", 0);
define("FEMALE", 1);

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);

$response = $client->createCase([
    'history_number' => 31415,
    'first_name' => 'API Name',
    'last_name' => 'Last Name',
    'gender' => FEMALE, // 0: MALE, 1: FEMALE
    'age' => 30,
    'diabetes' => 1, // 0: no, 1: yes
    'visit_date' => (new \DateTime('now'))->format('Y-m-d'), // A date accepted by PHP DateTime constructor
    'visit_reason' => 'Patient with regular headaches when reading',
    'ophthalmic_antecedents' => 'Relevant antecedents',
    'other_relevant_info' => 'Other',
    'retinologist_notes' => 'Internal notes for the retinologist',
    'od_iop' => 16,
    'od_va' => 0.5,
    'od_axis' => 15,
    'od_cylinder' => -1,
    'od_sphere' => -1.25,
    'od_add' => 3.5,
    'od_prism' => 0.5,
    'od_prism_base' => 0, // 0: down, 1: up
    'os_iop' => 16,
    'os_va' => 0.5,
    'os_axis' => 15,
    'os_cylinder' => -1,
    'os_sphere' => -1.25,
    'os_add' => 3.5,
    'os_prism' => 0.5,
    'os_prism_base' => 0,
    'callback_url' => 'http://localhost.com/optretina-php-sdk/example/callback.php', // POST CALL when case is reported or rejected
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
    $caso_id =  $response->content;
    echo "New case id: ". $caso_id;
} else {
    //Error
    echo $response->content;
}
