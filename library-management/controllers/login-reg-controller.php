<?php

session_start();
require '../connections.php';
require '../models/tbl-login-account-model.php';
$accountModel = new AccountModel($pdo);


if (isset($_POST['action']) && $_POST['action'] == 'login_check') {

    try {
        //code...
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $checkUsername = $accountModel->findUsername($username);

        if (!$checkUsername) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Username not found.']);
            exit;
        }

        if (password_verify($password, $checkUsername['password'])) {
            $_SESSION['fullname'] = $checkUsername['firstname'] . ' ' . $checkUsername['lastname'];
            $_SESSION['role'] = $checkUsername['role'];
            $_SESSION['user_id'] = $checkUsername['id'];
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => $checkUsername['role']]);
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Password is incorrect.']);
            exit;
        }
    } catch (\Throwable $th) {
        //throw $th;
        echo "Error : " . $th;
        exit;
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'register_action') {
    try {

        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $conpassword = filter_var($_POST['conpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_id = time();
        if ($password != $conpassword) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Password not match.']);
            exit;
        }
        $checkUsername = $accountModel->findUsername($username);
        if ($checkUsername) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Username already exists.']);
            exit;
        }
        $createAccount = $accountModel->createNewAccount($user_id, $username, $hashed_password, $firstname, $lastname, 'user');


        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Registered successfully. You can now login with your account.']);
        exit;
    } catch (\Throwable $th) {
        //throw $th;

        echo "Error : " . $th;
        exit;
    }
}
