<?php 
	require('vendor/autoload.php');

	// eWAY Credentials
	$apiKey = '60CF3Ce97nRS1Z1Wp5m9kMmzHHEh8Rkuj31QCtVxjPWGYA9FymyqsK0Enm1P6mHJf0THbR';
	$apiPassword = 'API-P4ss';
	$apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;

	// Create the eWAY Client
	$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

	// Query the transaction result.
	$response = $client->queryTransaction($_GET['AccessCode']);


	$transactionResponse = $response->Transactions[0];

	// Display the transaction result
	if ($transactionResponse->TransactionStatus) {
		echo 'Payment successful! ID: ' .
		$transactionResponse->TransactionID;
	} else {
		$errors = split(', ', $transactionResponse->ResponseMessage);
		foreach ($errors as $error) {
			echo "Payment failed: " .
			\Eway\Rapid::getMessage($error)."
			";
		}
	}