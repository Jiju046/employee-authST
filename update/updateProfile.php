<?php 
    session_start();


    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        unset($_SESSION['warning']);
        $file= $_FILES['file'];
        $email= $_SESSION['email'];

        // storing array into variables
        $fileName= $file['name'];
        $fileTempName= $file['tmp_name'];
        $fileErr= $file['error'];
        $fileSize= $file['size'];

        // take file name extension
        $fileExt= explode(".",$fileName);
        $actualExt= strtolower(end ($fileExt));
        $allowed= array('jpg','png','jpeg');


        // if the extension is in allowed
        if (in_array($actualExt,$allowed)){
            // ensure there is no error
            if ($fileErr == 0){
                if ($fileSize <= 2097152){  //2 mb
                    $fileNameNew= uniqid("IMG-",true).".".$actualExt;
                    
                    $fileDestination= '../uploads/'.$fileNameNew;
                    
                    move_uploaded_file($fileTempName,$fileDestination); // move from temp to desired folder
                    
                    include "../db.php";

                    $sql= "UPDATE employee SET image='$fileNameNew' where email='$email'";
                    mysqli_query($connection,$sql);
                } 
            }
            else{
                // more than 2mb
                $_SESSION['warning']= "Max limit is 2mb!";
            }

        }
        else{
            // empty or wrong file
            $_SESSION['warning']= "Please choose a valid image!";
        }
    header("Location: ../index.php");
    }

