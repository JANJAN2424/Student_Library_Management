<?php
session_start();
require '../../connections.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location='../../index.php'</script>";
}
$role = $_SESSION['role'];
if ($role != 'admin') {
    echo "<script>window.location='../../index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library Management</title>
    <link rel="stylesheet" href="<?php echo $env_basepath ?>assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $env_basepath ?>assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo $env_basepath ?>assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="<?php echo $env_basepath ?>assets/boxicons/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo $env_basepath; ?>assets/datatable/jquery.dataTables.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: 'Poppins', 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .sidebar {
            margin: 0;
            padding: 20px;
            width: 300px;
            background-color: #f1f1f1;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }

        .sidebar a.active {
            background-color: #04AA6D;
            color: white;
        }

        .sidebar a:hover:not(.active) {
            background-color: #555;
            color: white;
        }

        div.content {
            margin-left: 300px;
            padding: 1px 16px;
            height: 100vh;
        }

        .container {
            padding: 30px;
        }

        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar h4 {
                display: none;
            }

            .sidebar a {
                float: left;
            }

            div.content {
                margin-left: 0;
            }
        }

        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }
    </style>
</head>

<body>
    <?php require '../../assets/loader/loader.php'; ?>
    <div class="sidebar">
        <h4>School Library Management</h4>
        <a <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?> href="dashboard.php">
            <i class='bx bx-book-open'></i> Manage Books
        </a>
        <a <?php echo (basename($_SERVER['PHP_SELF']) == 'borrowed-books.php') ? 'class="active"' : ''; ?> href="borrowed-books.php">
            <i class='bx bx-user'></i> Borrowed Books
        </a>
        <a <?php echo (basename($_SERVER['PHP_SELF']) == 'all-transactions.php') ? 'class="active"' : ''; ?> href="all-transactions.php">
            <i class='bx bx-list-check'></i> All Transactions
        </a>
        <a href="#" onclick="confirmLogout()">
            <i class='bx bx-log-out'></i> Logout
        </a>
    </div>

    <div class="content">
        <!-- end of top content -->