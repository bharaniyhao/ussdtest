<?php

$connection = mysqli_connect("localhost", "root", "password", "choice");

if(!$connection){
    echo "could not connect to db".mysqli_error($connection);
    
}

?>