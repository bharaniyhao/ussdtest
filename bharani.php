<?php
function main_menu($phone) {
    // Check if user is registered
    $is_registered = check_user($phone);
    

    if (!$is_registered) {
        // If user is not registered, display the registration option
        $text = "Welcome to Make Choices\nPlease Reply with \n1. Register\n2. Make inquiries";
        
    } else {
        // If user is registered, display the other menu options
        $text = "Welcome back to Make Choices\nPlease Reply with \n2. My Account \n3. Purchase Item \n4. Make inquiries";
    }

    ussd_proceed($text);
}

//yhao0266212420
function customer_register($data,$phone) {
    global $connection;
    if (count($data) == 2){
        $text = "Enter your firstName";
        ussd_proceed($text);
    }
    if (count($data) == 3){
        $text = "Enter your middleName";
        ussd_proceed($text);
    }
    if (count($data) == 4){
        $text = "Enter your lastName";
        ussd_proceed($text);
    }
    if (count($data) == 5){
        $text = "Enter your gender(Male/Female)";
        ussd_proceed($text);
    }
    if (count($data) == 6){
        $text = "Enter your ID number";
        ussd_proceed($text);
    }
    if (count($data) == 7){
        $text = "Enter your Email address";
        ussd_proceed($text);
    }
    if (count($data) == 8){
        $text = "Enter your password";
        ussd_proceed($text);
    }
    if (count($data) == 9){
        $phone = $_GET['phoneNumber'];
        $firstName = $data[2];
        $middleName = $data[3];
        $lastName = $data[4];
        $gender = $data[5];
        $idNumber = $data[6];
        $email = $data[7];
        $password = $data[8];
        
        // check if phone number already exists in the database
        $check_phone = "SELECT * FROM customer WHERE phoneNumber = '$phone'";
        $result = mysqli_query($connection, $check_phone);
        if (mysqli_num_rows($result) > 0) {
            $text = "This phone number is already registered. Please try again with a different number.";
            ussd_stop($text);
        } else {
            $sql = "insert into customer(phoneNumber, firstName, lastName, middleName, gender, idNumber, email, password, registerDate) values ('$phone','$firstName','$lastName',' $middleName','$gender','$idNumber','$email','$password', Now())";
            $result = mysqli_query($connection, $sql) or die ("There was an error".mysqli_error($connection));
            if($result == 1){
                $text = "You have Successfully registered";
                ussd_stop($text);
            }
        }
    }
}

//exite customer_register

function check_user($phone) {
    global $connection;
    
    // If phone number is empty, prompt the user to enter a valid phone number
    if (!empty($phone)) {
        $text = "Please enter your phone number in the format 0xxxxxxxxx or +233xxxxxxxxx:";
        ussd_proceed($text);
        return false;
    }
    
    // Validate phone number format
    if(!preg_match("/^(?:\+233|0)[\d]{9}$/", $phone)) {
        $text = "Invalid phone number format. Please enter a valid Ghanaian phone number in the format 0xxxxxxxxx or +233xxxxxxxxx:";
        ussd_proceed($text);
        return false;
    }
    
    // Check if user is registered
    $select = "SELECT * FROM customer WHERE phoneNumber ='$phone'";
    $query = mysqli_query($connection, $select);

    if (mysqli_num_rows($query) > 0) {
        return true;
    }else
        if (!function_exists('customer_register')) {
            function customer_register($data) {
                // function code here
                function customer_register($data) {
                    global $connection;
                    if (count($data) == 2){
                        $text = "Enter your firstName";
                        ussd_proceed($text);
                    }
                    if (count($data) == 3){
                        $text = "Enter your middleName";
                        ussd_proceed($text);
                    }
                    if (count($data) == 4){
                        $text = "Enter your lastName";
                        ussd_proceed($text);
                    }
                    if (count($data) == 5){
                        $text = "Enter your gender(Male/Female)";
                        ussd_proceed($text);
                    }
                    if (count($data) == 6){
                        $text = "Enter your ID number";
                        ussd_proceed($text);
                    }
                    if (count($data) == 7){
                        $text = "Enter your Email address";
                        ussd_proceed($text);
                    }
                    if (count($data) == 8){
                        $text = "Enter your password";
                        ussd_proceed($text);
                    }
                    if (count($data) == 9){
                        $phone = $_GET['phoneNumber'];
                        $firstName = $data[2];
                        $middleName = $data[3];
                        $lastName = $data[4];
                        $gender = $data[5];
                        $idNumber = $data[6];
                        $email = $data[7];
                        $password = $data[8];
                        
                        // check if phone number already exists in the database
                        $check_phone = "SELECT * FROM customer WHERE phoneNumber = '$phone'";
                        $result = mysqli_query($connection, $check_phone);
                        if (mysqli_num_rows($result) > 0) {
                            $text = "This phone number is already registered. Please try again with a different number.";
                            ussd_stop($text);
                        } else {
                            $sql = "insert into customer(phoneNumber, firstName, lastName, middleName, gender, idNumber, email, password, registerDate) values ('$phone','$firstName','$lastName',' $middleName','$gender','$idNumber','$email','$password', Now())";
                            $result = mysqli_query($connection, $sql) or die ("There was an error".mysqli_error($connection));
                            if($result == 1){
                                $text = "You have Successfully registered";
                                ussd_stop($text);
                            }
                        }
                    }
                }
            }
        }}


//reference
function referenceNumber($lenght){
    $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($chars), 0, $lenght);
}
    function myAccount($data){
        global $connection;
        if(count($data) == 2){ 
            $text = "My Account\nPlease Reply with\n 1. Check Balance \n 2. Deposit \n 3. Pending Approval ";
        ussd_proceed($text);
        } else if (count($data) ==3){
            switch ($data[2]){
                case 1:
                    $phone = $_GET['phoneNumber'];
                   // get user's balance from the database
                $query = "SELECT balance FROM account WHERE phoneNumber = '$phone '" ;
                // -- .$data[2]."'";
                $result = mysqli_query($connection, $query) or die ("There was an error".mysqli_error($connection));
// echo $data;
//  print_r($data);
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $balance = $row['balance'];
            $text = "Your balance is $balance.";
        }else{
            $text = "No balance found with this phone number";
        }
        ussd_proceed($text);
        break;
        case 2:
            if(count($data)==3){
                $text = "Please Enter the amount\nyou wish to Deposit";
                ussd_proceed($text);
            }
        if (count($data)==4){
            $phoneNumber = $_GET['phoneNumber'];
            $balance = $data[2];
            $referenceNumber = "TB".referenceNumber(2);

            if($balance > $balance){
                $text = "you have insufficient balance\nyour balance is $balance";
                ussd_stop($text);
            }
        if($balance < 5){
            $text = "you cant Deposit less than 5 ";
            ussd_stop($text);
        }
        else{
        $sql = "insert into account(phoneNumber,balance,referenceNumber,dateTime) values('$phoneNumber','$balance','$referenceNumber', Now())";
        $result = mysqli_query($connection, $sql) or die ("There was an error".mysqli_error($connection));
        if($result == 1)
                {
                    $text = "you have successfully Deposit $balance ";
                    ussd_stop($text);
                }
            } break;
        }
    }
            
}
}

function check_password($data, $password){
    global $connection;
    if(count($data) == 2 ){
        $text = "Please Enter your Password";
        ussd_proceed($text);
        
    }
    if(count($data) == 3){
        $phone = $_GET['phoneNumber'];
        $password = $data[2];
        $statement = "select * from customer where phoneNumber= '$phone' and password= '$password'";
        $result = mysqli_query($connection, $statement)  or die ("There was an error".mysqli_error($connection));
        $check = mysqli_num_rows($result);

        if($check>0 ){
            return true;
        }else{
            $text ="Please check your password or contact Yao";
            ussd_stop($text);
        }
    }
    }
    
    function makeInquiries($data){
        if(count($data) == 2){
        $text = "Welcome to Make Choices\nPlease Reply with\n1. Contact Detials\n2. Term & Conditions";
        ussd_proceed($text);
    } else if (count($data) == 3){
            switch ($data[2]){
                case 1:
                    if(count($data)==3){
                        $text = "Reach out  to us at +233 303 962 897";
                        ussd_proceed($text);
                    }
                    break;
                case 2:
                    if(count($data)==3){
                        $text = "Kindly visit http://makechoicesgh.com for our terms and conditions. Thank you";
                        ussd_proceed($text);
                    }
                }
            }
        }
    

function updatePassword($data, $phone){  
    global $connection;
if(count($data) == 2){
    $text = "Please enter your password";
    ussd_proceed($text);
}
 if(count($data)== 3){
    $phone = $_GET['phoneNumber'];
    $password = $data[2];

    $password = md5($password);

    $sql = "UPDATE customer SET password = '$password' WHERE phoneNumber = '$phone'";
    $result = mysqli_query($connection, $sql);

    if($result == 1){
        $text = "You Have successfully update your password";
        ussd_stop($text);
    }
 }
}


function ussd_proceed($text){
    header('Content-Type: application/json');
    echo "CON ".$text;
}

function ussd_stop($text){
    header('Content-Type: application/json');
    echo "END ".$text;
    exit(0); 

}
