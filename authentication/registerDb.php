<?php
    include "../db.php";
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        // storing input in variables
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $address = $_POST["address"];

        // query to find if the input mail already exist
        $query = "SELECT * from employee WHERE email='$email'";
        $duplicate = $connection->query($query);

        // if query succeed
        if ($duplicate->num_rows == 1) {
            $response['status'] = 0;
        }
        else {
            // query to add
            $sql = "INSERT INTO employee (first_name,last_name,email,password,address,image)
                VALUES ('$fname','$lname','$email','$password','$address','default.jpg')";

            if ($connection->query($sql)) {
                $response['status'] = 1;
                $response['message'] = "Registered Successfully!";
            } 
            else {
                echo "error:" . $sql . "<br>" . $connection->error;
                $response['message'] = "Error: Registration failed.";
            }
        }

        // to get as response in register.php
        echo json_encode($response);
    
    }
    
?>