<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container my-3 shadow p-5 mb-5 bg-body rounded">
        <h3 class="my-3">Register</h3>
        <p class="text-danger">* are required.</p>

    <form id="registerForm">
        <!-- fname -->
        <div class="mb-3">
            <label for="fname" class="form-label">First Name</label><span class="text-danger">*</span>
            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" onblur="validateField(this)">
            <p id="fname-warning" class="text-danger" class="error-message"></p>
        </div>
        <!-- lname -->
        <div class="mb-3">
            <label for="lname" class="form-label">Last Name</label><span class="text-danger">*</span>
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" onblur="validateField(this)">
            <p id="lname-warning" class="text-danger" class="error-message"></p>
        </div>
        <!-- email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label><span class="text-danger">*</span>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" onblur="validateEmail(this)">
            <p id="email-warning" class="text-danger" class="error-message"></p>
        </div>
        <!-- password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label><span class="text-danger">*</span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" onblur="validatePassword(this)">
            <p id="password-warning" class="text-danger" class="error-message"></p>
        </div>
        <!-- confirm password -->
        <div class="mb-3">
            <label for="cnfPassword" class="form-label">Confirm Password</label><span class="text-danger">*</span>
            <input type="password" class="form-control" id="cnfPassword" name="cnfPassword" placeholder="Confirm Password" onblur="validatePasswordMatch()">
            <p id="cnf-warning" class="text-danger"></p>
        </div>
        <!-- address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label><span class="text-danger">*</span>
            <textarea class="form-control" id="address" rows="3" name="address" placeholder="Address" onblur="validateField(this)"></textarea>
            <p id="address-warning" class="text-danger" class="error-message"></p>
        </div>
            <button id="submit" type="submit" class="btn btn-primary mb-4">Submit</button>
            <p id="register-message"></p>
    </form>

    <a class="btn btn-success my-3" href="./login.php">Back to Login</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
    <!-- jq validation -->
    <script>
            let emailRegex= /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            let passwordRegex= /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

            
            function validateField(inputElement) {
                if (inputElement.value.trim() === "") {
                    $("#" + inputElement.id + "-warning").html("This field is required");
                    return false;
                } else {
                    $("#" + inputElement.id + "-warning").empty();
                    return true;
                }
            }

            function validateEmail(inputElement) {
                let email = inputElement.value.trim();
                if (!emailRegex.test(email)) {
                    $("#email-warning").html("Invalid Email");
                    return false;
                }
                else {
                    $("#email-warning").empty();

    // Check if the email exists using AJAX
                $.ajax({
                        type: 'POST',
                        url: "emailValid.php",
                        data: { email: email },
                        dataType: 'html',
                        success: function (response) {
                            if (response) {
                                $("#email-warning").html(response);
                            } 
                        },
                        error: function (error) {
                            alert("Error: " + error);
                        }
                        });
                        return true;
                    }
            }

            function validatePassword(inputElement) {
                let password = inputElement.value;
                if (!passwordRegex.test(password)) {
                    $("#password-warning").html("Password must contain Minimum eight characters, at least one letter and one number");
                    return false;
                } else {
                    $("#password-warning").empty();
                    return true;
                }
            }

            function validatePasswordMatch() {
                let password = $('#password').val();
                let cnfPassword = $('#cnfPassword').val();

                if (password !== cnfPassword) {
                    $("#cnf-warning").html("Password mismatch");
                    return false;
                }
                else if(password == ""){
                    $("#cnf-warning").html("This Field is required");
                    return false;
                }
                else {
                    $("#cnf-warning").empty();
                    return true;
                }
            }
            
            // submit
            $("#registerForm").submit(function(e){
                e.preventDefault();

                // validate when submitted
                let fnameVal=validateField(document.getElementById('fname'));
                let lnameVal=validateField(document.getElementById('lname'));
                let emailVal=validateEmail(document.getElementById('email'));
                let passwordVal=validatePassword(document.getElementById('password'));
                let cnfVal=validatePasswordMatch();
                let addressVal=validateField(document.getElementById('address'));

                    if(fnameVal && lnameVal && emailVal && passwordVal && cnfVal && addressVal){

                        $.ajax({
                            type:'POST',
                            url:"registerDb.php",
                            data:$('#registerForm').serialize(),
                            dataType:'json',
                            success:function(response){

                                if (response.status === 1) {
                                    alert(response.message);
                                    window.location.href = "./login.php";                           
                                }                               
                            },
                            error: function(error){
                                alert("Error:" + error);                        
                            }
                            })
                    }  
            });
            
    </script>

</body>
</html>