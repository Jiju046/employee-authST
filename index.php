<?php
// get employee details
    session_start();
    if (!isset($_SESSION['email'])){
        header("Location: ./authentication/login.php");
    }

    include "db.php";
    $email=$_SESSION['email'];
    $query="SELECT * FROM employee where email='$email'";
    $result=$connection -> query($query);

    if ($result -> num_rows==1){
        $row=$result -> fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <!-- head -->
        <h3 class="my-5">Welcome <?php echo $row['first_name']." ".$row['last_name']; ?>
        <a class="btn btn-danger float-end" href="./authentication/logout.php">Logout</a>
        </h3>
        
        <!-- Profile picture card-->
        <div class="card my-5 w-50 mx-auto border-0">
            <div class="card-header border-0 fw-bolder text-success">Profile Picture</div>
            <div class="card-body text-center">

                <!-- Profile picture view-->
                <img id="image" class="rounded-circle mb-2" src="./uploads/<?php echo $row['image']; ?>" alt="" width="150px">
                <div class="small font-italic text-muted mb-4">JPG,JPEG or PNG not larger than 2 MB</div>
                
                <!-- Profile picture form-->
                <form method="post" enctype="multipart/form-data" action="./update/updateProfile.php">
                <div class="mb-3">
                    <input class="form-control" type="file" id="image" name="file">
                </div>

                <button type="submit" class="btn btn-primary" id="submit">Update Profile Picture</button>
                </form>
                
                <p class="text-danger"><?php echo $_SESSION['warning']; ?></p>
            </div>
        </div>
                
        <!-- current employee details -->
        <div class="shadow p-5 mb-5 bg-body rounded">
            <table class="table table-striped my-4 border">
                <thead>
                    <tr>
                        <th class="text-success" scope="col">First Name</th>
                        <th class="text-success" scope="col">Last Name</th>
                        <th class="text-success" scope="col">Email</th>
                        <th class="text-success" scope="col">Address</th>
                    </tr>
                    <tr>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                    </tr>
                </thead>
            </table>
            <a class="btn btn-success my-3" href="./update/update.php">Update Details</a>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

</body>
</html>