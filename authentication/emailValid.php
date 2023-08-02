<?php
    include "../db.php";
    // storing input in variables
    $email = $_POST["email"];

    // query to find if the input mail already exist
    $query = "SELECT * from employee WHERE email='$email'";
    $duplicate = $connection->query($query);

    // if query succeed
    if ($duplicate->num_rows == 1) {
        echo "Email Already Exist Please Login or Use Another!";
    }
?>