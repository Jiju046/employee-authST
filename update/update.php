<?php
    session_start();

    include "../db.php";

    if (isset($_SESSION['email'])){
        // to show data
        $email= $_SESSION['email'];
        $query= "SELECT * FROM employee where email='$email'";
        $result= $connection -> query($query);

        if ($result -> num_rows == 1){
            $row= $result -> fetch_assoc();
            $fname= $row['first_name'];
            $lname= $row['last_name'];
            $address= $row['address'];
        }
        else {
            echo "failed to fetch data";
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST"){
            // to update data
            $inputFname= $_POST['fname'];
            $inputLname= $_POST['lname'];
            $inputAddress= $_POST['address'];

            $sql="UPDATE employee SET first_name='$inputFname', last_name='$inputLname', address='$inputAddress' WHERE email='$email'";

            if ($connection -> query($sql)){
                header("Location: ../index.php");
                exit();
            }
            else {
                echo "Error Updating:".$sql. $connection -> error;
            }

        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container my-3 shadow p-5 mb-5 bg-body rounded">
        <h3 class="my-3">Update Details</h3>
        <form method="post" action="">

            <!-- fname -->
            <div class="mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" placeholder="First Name">
            </div>

            <!-- lname -->
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $lname; ?>" placeholder="Last Name">
            </div>

            <!-- address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" rows="3" name="address" placeholder="Address"><?php echo $address; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Update</button>
        </form>
        <a class="btn btn-success my-3" href="../index.php">Back to Home</a>
    </div>
</body>
</html>