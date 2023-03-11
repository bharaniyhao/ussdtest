<?php
include('dbcon.php');
// Parse the payment callback data
$status = $_POST['status'];
$transaction_id = $_POST['transaction_id'];
$amount = $_POST['amount'];
$reference = $_POST['reference'];
$custom_data = json_decode($_POST['custom_data'], true);

// Update your database or take other actions based on the payment status
if ($status == 'success') {
    // Payment was successful, update your database and send a confirmation email
    $user_id = $custom_data['user_id'];
    // Update your database with the payment status and transaction ID
    // $db = new PDO('mysql:host=localhost;dbname=mydatabase', 'username', 'password');
    $stmt = $db->prepare('UPDATE payments SET status = :status, transaction_id = :transaction_id WHERE reference = :reference');
    $stmt->bindValue(':status', 'success');
    $stmt->bindValue(':transaction_id', $transaction_id);
    $stmt->bindValue(':reference', $reference);
    $stmt->execute();
    // Send a confirmation email to the user
} else {
    // Payment failed, update your database and notify the user
    // Update your database with the payment status and transaction ID
    // $db = new PDO('mysql:host=localhost;dbname=mydatabase', 'username', 'password');
    $stmt = $db->prepare('UPDATE payments SET status = :status, transaction_id = :transaction_id WHERE reference = :reference');
    $stmt->bindValue(':status', 'failed');
    $stmt->bindValue(':transaction_id', $transaction_id);
    $stmt->bindValue(':reference', $reference);
    $stmt->execute();
    // Notify the user that the payment failed
}

// Return a response to the payment gateway
echo 'OK';
