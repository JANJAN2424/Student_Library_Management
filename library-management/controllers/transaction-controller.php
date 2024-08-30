<?php

session_start();
require '../connections.php';
require '../models/tbl-login-account-model.php';
require '../models/tbl-books-information-model.php';
require '../models/tbl-transaction-model.php';
require '../models/tbl-borrowed-books-model.php';
$accountModel = new AccountModel($pdo);
$booksInformation = new BooksInformation($pdo);
$transactionModel = new TransactionModel($pdo);
$borrowedBooks = new BorrowedBooksModel($pdo);

if (isset($_POST['action']) && $_POST['action'] == 'borrow_this') {
    try {
        //code...
        $pdo->beginTransaction();
        $book_id = $_POST['book_id'];
        $user_id = $_SESSION['user_id'];
        $fullname = $_SESSION['fullname'];
        $type = "Borrow";
        $description = $fullname . " borrowed a book.";
        $book_status = "borrowed";

        $insertToborrow = $borrowedBooks->insert($user_id, $book_id);

        $insertToTransaction = $transactionModel->createTransaction($user_id, $book_id, $type, $description);
        $updateStatus = $booksInformation->updateStatusById($book_id, $book_status);

        $pdo->commit();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "Borrowed successfully."]);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        $pdo->rollBack();
        echo $th;
        exit;
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'return_this') {
    $book_id = $_POST['book_id'];
    $borrow_id = $_POST['borrow_id'];
    $user_id = $_SESSION['user_id'];
    $fullname = $_SESSION['fullname'];
    $type = "Return";
    $description = $fullname . " borrowed a book.";
    $book_status = "available";

    try {
        //code...
        $pdo->beginTransaction();

        $deleteFromBorrowedBooks = $borrowedBooks->delete($borrow_id);
        $insertToTransaction = $transactionModel->createTransaction($user_id, $book_id, $type, $description);
        $updateStatus = $booksInformation->updateStatusById($book_id, $book_status);
        $pdo->commit();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "Returned successfully."]);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        $pdo->rollBack();
        echo $th;
        exit;
    }
}
