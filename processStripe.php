<?php


try {
	require_once( $_SERVER['DOCUMENT_ROOT'] . '/stripe-php/init.php' );
	$sk = 'sk_live_****';
	\Stripe\Stripe::setAppInfo( "Club Deise Stripe Pay", "1.0", "https://www.xyz.com" );
	\Stripe\Stripe::setApiKey( $sk );
	\Stripe\Stripe::$apiBase = "https://api-tls12.stripe.com";
	$token = $_POST['stripeToken'];
	\Stripe\Charge::create( array(
		'source' => $token,
		'amount' => $amount,
		'currency' => "EUR",
		"metadata" => array(
			"Customer Name" => $name,
			"Customer Email" => $email
		)
	) );
	echo "Thank you for your payment";

	//send emails etc

	
}catch (\Stripe\Error\Card $e) {

	// Since it's a decline, \Stripe\Error\Card will be caught

	$body = $e->getJsonBody();

	$err = $body['error'];

	print('Status is:' . $e->getHttpStatus() . "\n");

	print('Type is:' . $err['type'] . "\n");

	print('Code is:' . $err['code'] . "\n");

	// param is '' in this case

	print('Param is:' . $err['param'] . "\n");

	print('Message is:' . $err['message'] . "\n");

} catch (\Stripe\Error\RateLimit $e) {

	echo '<pre><div class="alert alert-danger">Too many requests made to the API too quickly<br/>' . $e . '</div></pre>';

} catch (\Stripe\Error\InvalidRequest $e) {

	echo '<pre><div class="alert alert-danger">Invalid parameters were supplied to Stripes API<br/>' . $e . '</div></pre>';

	// Invalid parameters were supplied to Stripe's API

} catch (\Stripe\Error\Authentication $e) {

	echo '<pre><div class="alert alert-danger">Authentication with Stripes API failed<br/>' . $e . '</div></pre>';

	// Authentication with Stripe's API failed

	// (maybe you changed API keys recently)

} catch (\Stripe\Error\ApiConnection $e) {

	echo '<pre><div class="alert alert-danger">Network communication with Stripe failed<br/>' . $e . '</div></pre>';

	// Network communication with Stripe failed

} catch (\Stripe\Error\Base $e) {

	echo '<pre><div class="alert alert-danger"><br/>' . $e . '</div></pre>';

	// Display a very generic error to the user, and maybe send

	// yourself an email

} catch (Exception $e) {

	echo '<pre><div class="alert alert-danger"><br/>' . $e . '</div></pre>';

	// Something else happened, completely unrelated to Stripe

}



?>