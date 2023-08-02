<?php
    session_start();
    include "../db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // empty validation and query
        if (empty($email) || empty($password)) {
            $warning = "Please enter both email and password.";
        } else {
            $sql = "SELECT email, password FROM employee WHERE email='$email'";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();

            if ($row) {
                if ($password === $row['password']) {
                    // Passwords match, login successful
                    $_SESSION['email'] = $row['email'];
                    header("Location: ../index.php");
                } else {
                    // Wrong password
                    $warning = "Wrong password!";
                }
            } else {
                // if both email and password are wrong
                $warning = "Invalid Credentials";
            }
        }
    }
    // if logged in takes home
    if (isset($_SESSION['email'])){
        header("Location: ../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5 w-50 shadow p-5 mb-5 bg-body rounded">
        <h3 class="my-3">Login</h3>
        <form method="post" action="">
            <div class="mb-3">
                <!-- email -->
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Registered Email">
            </div>
            <!-- password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
            </div>
            <button type="submit" class="btn btn-primary mb-4">Submit</button>
        </form>
        <!-- warning and register -->
            <p class="text-danger"><?php echo $warning; ?></p>
            <p>Don't have an account? Click Register</p>
            <a class="btn btn-success" href="./register.php">Register</a>            
    </div>
    
</body>
</html>