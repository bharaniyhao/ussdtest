<?php 
// header("content-type:text/plain");
header('Content-Type: application/json');
// Get the parameters from the request
// $session_id = $_POST['sessionId'];
// $service_code = $_POST['serviceCode'];
$phone = $_GET['phoneNumber'];
$text = $_GET['text'];
// if (isset($_POST['phoneNumber'])) {
//     $phone = $_POST['phoneNumber'];
//   } else {
//     // handle case where phoneNumber is not set
//   }
  
//   if (isset($_POST['text'])) {
//     $text = $_POST['text'];
//   } 
include('dbcon.php');
include('bharani.php');

// Call the appropriate menu function based on the user's selection
$data = explode("*", $text);
$level = count($data);

$is_registered = check_user($phone);

if ($level == 0 || $level == 1) {
    // If user is at the main menu, call the appropriate function based on registration status
    $text = main_menu($phone,$data);
} else {
    // Otherwise, call the appropriate function based on the user's selection
    switch ($data[1]) {
        case 1:
            if (!$is_registered) {
                // If user selects registration option and is not registered, call the registration function
                customer_register($data, $phone);
            }  else {
              // If user is registered, display the other menu options
              $text = "Welcome back to Make Choices\nPlease Reply with \n2. My Account \n3. Purchase Item \n4. Make inquiries";
              ussd_proceed($text);
          }
            break;
        case 2:
          $text  = myAccount($data, $phone);
        // check_password($data, $phone);
        // checkBalance($data, $phone);
        // transfer($data, $phone);
        break;

        case 3:
          $text = purchaseItem($data);
        // check_password($data, $phone);

        break;

        case 4:
       $text = makeInquiries($data, $phone);
    
        break;

        default:
        $text = "Invalid text Input\nplease insert a valid menu option";
        ussd_stop($text);

    }
    $text = [
      "session_id" => $session_id,
      "service_code" => $service_code,
      // "msisdn" => $msisdn,
      "text" => $text,
      
    ];
}
