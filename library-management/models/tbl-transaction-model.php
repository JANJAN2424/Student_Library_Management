<?php

class TransactionModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function createTransaction($borrower_id, $book_id, $type, $description)
    {
        $sql = "INSERT INTO tbl_transaction (borrower_id, book_id, type, description) VALUES (:borrower_id, :book_id, :type, :description)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':borrower_id', $borrower_id);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':description', $description);

        $stmt->execute();
    }
}
