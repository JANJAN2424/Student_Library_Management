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
    <title>SLM</title>
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
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #showPassword {
            position: absolute;
            opacity: 0;
        }
    </style>
</head>

<body>
    <?php require 'assets/loader/loader.php'; ?>
    <div class="content">
        <div class="login-container">
            <form id="login_form" autocomplete="off">
                <div class="d-flex justify-content-center">
                    <h1>Login</h1>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                </div>
                <div class="mb-3">
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
                <div class="d-flex justify-content-center flex-column">
                    <button id="login_button" type="submit" class="btn btn-primary">Login</button>
                    <a href="register.php" class="text-center mt-3">Don't have an account?</a>
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
        $("#login_button").click(function(e) {

            if ($("#login_form")[0].checkValidity()) {
                e.preventDefault();

                $('.loader-container').fadeIn();
                var formData = new FormData($("#login_form")[0]);
                formData.append("action", "login_check");

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
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();

                                }
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
                            if (response.message == 'admin') {
                                window.location.href = "views/admin/dashboard.php";
                            } else {
                                window.location.href = "views/users/dashboard.php";
                            }
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