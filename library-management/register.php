<?php
session_start();


if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    if ($role == 'admin') {
        echo "<script>window.location='views/admin/dashboard.php'</script>";
    } else {
        echo "<script>window.location='views/users/dashboard.php'</script>";
    }
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library Management</title>
    <link rel="stylesheet" href="assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="assets/boxicons/boxicons.min.css">
    <style>
        .content {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #showPassword {
            position: absolute;
            opacity: 0;
        }

        #showConPassword {
            position: absolute;
            opacity: 0;
        }
    </style>
</head>

<body>
    <?php require 'assets/loader/loader.php'; ?>
    <div class="content">
        <div class="login-container">
            <form id="register_form" autocomplete="off">
                <div class="d-flex justify-content-center">
                    <h1>Register</h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">First name</label>
                        <input type="text" class="form-control" id="firstname" placeholder="First name" name="firstname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="lastname" placeholder="Last name" name="lastname" required>
                    </div>
                    <div class="col-md-12">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                            <div class="input-group-append">
                                <!-- Use a label as a clickable element for the hidden checkbox -->
                                <label for="showPassword" class="input-group-text">
                                    <input type="checkbox" id="showPassword">
                                    <i class='bx bx-low-vision'></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" oninput="checkPasswordMatch()" id="conpassword" placeholder="Confirm password" name="conpassword" required>
                            <div class="input-group-append">
                                <!-- Use a label as a clickable element for the hidden checkbox -->
                                <label for="showConPassword" class="input-group-text con">
                                    <input type="checkbox" id="showConPassword">
                                    <i class='bx bx-low-vision'></i>
                                </label>
                            </div>
                        </div>
                        <div class="error-conpass" style="color:red;"></div>
                    </div>
                </div>



                <div class="d-flex justify-content-center flex-column mt-3">
                    <button id="register_button" type="submit" class="btn btn-primary">Register</button>
                    <a href="index.php" class="text-center mt-3">Back to login page</a>
                </div>
            </form>
        </div>
    </div>


    <script src="assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/jsdelivr/popper.min.js"></script>
    <script src="assets/jsdelivr/bootstrap.min.js"></script>
    <script src="assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="assets/jquery/jquery-3.6.4.min.js"></script>
    <script>
        // JavaScript to toggle password visibility and change icons
        const showPasswordCheckbox = document.getElementById('showPassword');
        const passwordInput = document.getElementById('password');
        const iconElement = document.querySelector('.input-group-text .bx');

        showPasswordCheckbox.addEventListener('change', function() {

            passwordInput.type = this.checked ? 'text' : 'password';
            // Change icons based on checkbox state
            iconElement.classList.toggle('bx-show', this.checked);
            iconElement.classList.toggle('bx-low-vision', !this.checked);
        });
    </script>

    <script>
        // JavaScript to toggle password visibility and change icons
        const showConPasswordCheckbox = document.getElementById('showConPassword');
        const conpasswordInput = document.getElementById('conpassword');
        const coniconElement = document.querySelector('.input-group-text.con .bx');

        showConPasswordCheckbox.addEventListener('change', function() {
            conpasswordInput.type = this.checked ? 'text' : 'password';
            // Change icons based on checkbox state
            coniconElement.classList.toggle('bx-show', this.checked);
            coniconElement.classList.toggle('bx-low-vision', !this.checked);
        });


        function checkPasswordMatch() {
            const password = passwordInput.value;
            const conpassword = conpasswordInput.value;
            const errorConpassElement = document.querySelector('.error-conpass');

            if (password === conpassword) {
                errorConpassElement.textContent = ''; // Clear error message
            } else {
                errorConpassElement.textContent = 'Passwords do not match';
            }
        }
    </script>


    <script>
        $("#register_button").click(function(e) {

            if ($("#register_form")[0].checkValidity()) {
                e.preventDefault();

                $('.loader-container').fadeIn();
                var formData = new FormData($("#register_form")[0]);
                formData.append("action", "register_action");

                $.ajax({
                    url: "controllers/login-reg-controller.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        setTimeout(function() {
                            $('.loader-container').fadeOut();
                        }, 500);
                        if (response.status === "failed") {
                            Swal.fire({
                                title: 'Failed!',
                                text: response.message,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.status === "error") {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else if (response.status === "success") {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the error here
                        var errorMessage = 'An error occurred while processing your request.';
                        if (xhr.statusText) {
                            errorMessage += ' ' + xhr.statusText;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                location.reload();
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>