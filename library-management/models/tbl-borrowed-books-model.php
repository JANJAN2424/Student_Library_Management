<?php 

    class BorrowedBooksModel{
        private $pdo;

        public function __construct($pdo){
            $this->pdo = $pdo;
        }


        public function insert($borrower_id, $book_id) {
            $sql = "INSERT INTO tbl_borrowed_books (borrower_id, book_id) VALUES (:borrower_id, :book_id)";
        
            $stmt = $this->pdo->prepare($sql);
        
            $stmt->bindParam(':borrower_id', $borrower_id);
            $stmt->bindParam(':book_id', $book_id);

        
            $stmt->execute();
        }

        
        public function delete($borrow_id) {
            $sql = "delete from tbl_borrowed_books where id = :borrow_id";
        
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindParam(':borrow_id', $borrow_id);


        
            $stmt->execute();
        }
    }


?>