<?php

class AccountModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findUsername($username)
    {
        $sql = "SELECT * from tbl_login_account where username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createNewAccount($id, $username, $password, $firstname, $lastname, $role)
    {
        $sql = "INSERT INTO tbl_login_account (id, username, password, firstname, lastname, role) VALUES (:id, :username, :password, :firstname, :lastname, :role)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':role', $role);

        $stmt->execute();
    }
}
