<?php

session_start();
require '../connections.php';
require '../models/tbl-login-account-model.php';
require '../models/tbl-books-information-model.php';
$accountModel = new AccountModel($pdo);
$booksInformation = new BooksInformation($pdo);


if (isset($_POST['action']) && $_POST['action'] == 'add_new_books') {
    header('Content-Type: application/json');
    $book_title = filter_var($_POST['book_title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $book_author = filter_var($_POST['book_author'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Check if the file is uploaded successfully
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/book-image/';

        // Generate a unique filename using time() and the original file extension
        $timestampedFilename = time() . '.' . pathinfo($_FILES['book_image']['name'], PATHINFO_EXTENSION);
        $uploadPath = $uploadDir . $timestampedFilename;

        // Move the uploaded file to the destination folder
        if (!(move_uploaded_file($_FILES['book_image']['tmp_name'], $uploadPath))) {
            // File upload successful
            echo json_encode(['status' => 'error', 'message' => 'Failed to move the uploaded file.']);
            exit;
        }

        $checkTitle = $booksInformation->checkTitleExists($book_title);
        if ($checkTitle) {
            unlink($uploadPath);
            echo json_encode(['status' => 'failed', 'message' => 'Title already exists.']);
            exit;
        }

        $insertBook = $booksInformation->insert($book_title, $book_author, $timestampedFilename);

        echo json_encode(['status' => 'success', 'message' => 'Added successfully.']);
        exit;
    } else {
        // No file uploaded or an error occurred during upload
        echo json_encode(['status' => 'error', 'message' => 'Error uploading the file.']);
        exit;
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'delete_book') {
    header('Content-Type: application/json');
    $book_id = $_POST['book_id'];
    $status = 'deleted';

    $deleteBook = $booksInformation->updateStatusById($book_id, $status);

    echo json_encode(['status' => 'success', 'message' => 'Deleted successfully.']);
    exit;
}


if (isset($_POST['action']) && $_POST['action'] == 'edit_books') {
    try {
        //code...
        header('Content-Type: application/json');
        $book_id = $_POST['book_id'];
        $author = $_POST['author'];
        $title = $_POST['title'];


        $findInfo = $booksInformation->findById($book_id);

        $imagefilename = $findInfo['book_img'];

        if (isset($_FILES['file-image']) && !empty($_FILES['file-image']['name'])) {
            $uploadDir = '../assets/book-image/';

            // Generate a unique filename using time() and the original file extension
            $imagefilename = time() . '.' . pathinfo($_FILES['file-image']['name'], PATHINFO_EXTENSION);
            $uploadPath = $uploadDir . $imagefilename;

            // Move the uploaded file to the destination folder
            if (!(move_uploaded_file($_FILES['file-image']['tmp_name'], $uploadPath))) {
                // File upload successful
                echo json_encode(['status' => 'error', 'message' => 'Failed to move the uploaded file.']);
                exit;
            }
        }

        if ($findInfo['book_title'] == $title) {
            $title = $findInfo['book_title'];
        } else {
            $title = $title;
        }

        $updateInfo = $booksInformation->updateBook($book_id, $title, $author, $imagefilename);






        echo json_encode(['status' => 'success', 'message' => 'Edited successfully.']);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
        exit;
    }
}
