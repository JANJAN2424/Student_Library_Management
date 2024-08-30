<?php

class BooksInformation
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }



    public function insert($book_title, $book_author, $book_img)
    {
        $sql = "INSERT INTO tbl_books_information (book_title, book_author, book_img) VALUES (:book_title, :book_author, :book_img)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':book_title', $book_title);
        $stmt->bindParam(':book_author', $book_author);
        $stmt->bindParam(':book_img', $book_img);
        $stmt->execute();
    }

    public function checkTitleExists($book_title)
    {
        $sql = "SELECT * from tbl_books_information where book_title = :book_title and status != 'deleted'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':book_title', $book_title);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateStatusById($book_id, $status)
    {
        $sql = "UPDATE tbl_books_information set status = :status where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $book_id);
        $stmt->execute();
        return true;
    }

    public function findById($book_id)
    {
        $sql = "SELECT * from tbl_books_information where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $book_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateBook($book_id, $book_title, $book_author, $book_img)
    {
        $sql = "UPDATE tbl_books_information set book_title = :book_title, book_author = :book_author, book_img = :book_img where id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $book_id);
        $stmt->bindParam(':book_title', $book_title);
        $stmt->bindParam(':book_author', $book_author);
        $stmt->bindParam(':book_img', $book_img);
        $stmt->execute();
        return true;
    }
}
