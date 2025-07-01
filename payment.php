<?php
require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51QkLSx4QnYzdtWM2YjeudojDbhIWsdQwDLGNNeFdOlXuivbInJDrhWssECZMoKI7pN0ChimAFgHI5edQXkRccFkj005uBcYgre";
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Check if the total price is set and is a valid number
if (isset($_POST['totalPrice']) && is_numeric($_POST['totalPrice'])) {
    // Convert to integer (cents)
    $totalPrice = intval($_POST['totalPrice']) * 100; // Multiply by 100 to convert to cents
} else {
    die("Invalid total price.");
}

try {
    // Create a Stripe Checkout session
    $checkout_session = \Stripe\Checkout\Session::create([
        "payment_method_types" => ["card"], // Specify payment methods
        "mode" => "payment",
        "success_url" => "http://localhost/tms/success.php", // Redirect after successful payment
        "cancel_url" => "http://localhost/tms/cancel.php",   // Redirect if payment is canceled
        "locale" => "en", // Change the language of the payment page
        "line_items" => [[
            "quantity" => 1,
            "price_data" => [
                "currency" => "myr",
                "unit_amount" => $totalPrice, // Use the dynamic total price in cents
                "product_data" => [
                    "name" => "Travel Package", // You can customize this name
                ]
            ]
        ]]
    ]);

    // Redirect to Stripe Checkout page
    http_response_code(303);
    header("Location: " . $checkout_session->url);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error: " . $e->getMessage();
}
?>
