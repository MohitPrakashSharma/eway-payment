<?php

require('vendor/autoload.php');


// eWAY Credentials
$apiKey = '60CF3Ce97nRS1Z1Wp5m9kMmzHHEh8Rkuj31QCtVxjPWGYA9FymyqsK0Enm1P6mHJf0THbR';
$apiPassword = 'API-P4ss';
$apiEndpoint = 'Sandbox';

// Create the eWAY Client
$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);
// echo "http://$_SERVER[HTTP_HOST]" . dirname($_SERVER['REQUEST_URI']) . 'payment' . dirname($_SERVER['REQUEST_URI']) .'response.php';

// Transaction details - these would usually come from the application
$transaction = [
	'Customer' => [
		'FirstName' => 'John',
		'LastName' => 'Smith',
		'Street1' => 'Level 5',
		'Street2' => '369 Queen Street',
		'City' => 'Sydney',
		'State' => 'NSW',
		'PostalCode' => '2000',
		'Country' => 'au',
		'Email' => 'demo@example.org',
	],
		// These should be set to your actual website (on HTTPS of course)
		// 'RedirectUrl' => "http://$_SERVER[HTTP_HOST]" . dirname($_SERVER['REQUEST_URI']) . 'payment' . dirname($_SERVER['REQUEST_URI']) .'response.php',
		'RedirectUrl' => "http://localhost/payment/response.php",
		'CancelUrl' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
		'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE,
		'Payment' => [
		'TotalAmount' => 1000,
	]
];

// Submit data to eWAY to get a Shared Page URL
$response = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::RESPONSIVE_SHARED, $transaction);
 
// Check for any errors
if (!$response->getErrors()) {
	$sharedURL = $response->SharedPaymentUrl;
	header("Location: $sharedURL");

} else {
	foreach ($response->getErrors() as $error) {
		echo "Error: ".\Eway\Rapid::getMessage($error)." 
		";
	}
	die();
} 
