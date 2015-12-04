![](http://www.optretina.com/wp-content/uploads/2014/11/logo-optretina.png)

The OPTRETINA REST API  package is meant to provide you, the developer, with a set of tools to help you easily and quickly build your own system based in our API. Remember the the API still won't cover all situations and features that our platform offers.

# Features

This package provides tools for the following:

- Retrieve a list of cases
- Get a single case
- Get a report for a specific case
- Create a new case

## Installation

Install the latest version with

```bash
$ composer require optretina/optretina-php-sdk
```

# Documentation

## List of cases
Retrieve all cases.

### Request

- Requires authentication
- HTTP Method: GET
- URL: https://api.optretina.com/cases

### Example

```
#!php

define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_SECRET_XXX");

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);
$response = $client->getCases();

```

## Get case
Get a particular case

### Request

- Requires authentication
- HTTP Method: GET
- URL: https://api.optretina.com/cases/{id}

### Example

```
#!php

define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_SECRET_XXX");
define("CASE_ID", "XXXX");

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);
$response = $client->getCase(CASE_ID);

```

## Get a report
Get a report for a specific case. Output as code string in base64.

### Request

- Requires authentication
- HTTP Method: GET
- URL: https://api.optretina.com/cases/report/{id}

### Example

```
#!php


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
}


```

## Create case
Create a new case. 

### Request

- Requires authentication
- HTTP Method: POST
- URL: https://api.optretina.com/cases

### Example

```
#!php

define("CLIENT_ID", "CLIENT_ID_XXX");
define("CLIENT_SECRET", "CLIENT_SECRET_XXX");


define("MALE", 0);
define("FEMALE", 1);

$client = new Optretina\Api\Client(CLIENT_ID, CLIENT_SECRET);

$response = $client->createCase([
    'history_number' => 31415,
    'first_name' => 'API Name',
    'last_name' => 'Last Name',
    'secondary_last_name' => 'Third Name',
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

```

## Callback and notifications

A good way to get informed about different case status is to use a callback URL when case is created.

All notifications come in as a POST request.

### Available notifications.

- When a case is informed
- When a case is informed but the report has been modified.
- When a case is rejected

```
#!php
$_POST['status'] contains the new status, could be "reported" or "reject"
$_POST['caso'] contains the caso id.
```

## Getting Help

We've done our best to write the OPTRETINA API documentation to make integrating
with it as simple as possible. Should you have questions, [contact us](mailto:info@optretina.com).

## Help us make it better

Please tell us how we can make the API better. If you have a specific feature
request or if you found a bug, please use GitHub issues.
