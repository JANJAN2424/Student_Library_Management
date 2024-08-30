<?php require 'template/toptemplate.php' ?>
<?php
require '../../connections.php';
$sql = "SELECT * FROM tbl_borrowed_books
    JOIN tbl_login_account ON tbl_borrowed_books.borrower_id = tbl_login_account.id
    JOIN tbl_books_information ON tbl_borrowed_books.book_id = tbl_books_information.id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<div class="container">
<div class="container" style="max-width: 1000px; overflow-x: auto;">
      <table id="data_table" class="table table-striped">
         <thead>
            <tr>
               <th>Borrower Name</th>
               <th>Book Title</th>
               <th>Book Author</th>
               <th>Timestamp</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($result as $row) { ?>
               <tr>
                  <td><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></td>
                  <td><?php echo $row['book_title'] ?></td>
                  <td><?php echo $row['book_author'] ?></td>
                  <td><?php echo $row['timestamp'] ?></td>


               </tr>

            <?php } ?>

         </tbody>
      </table>
   </div>
</div>
<?php require 'template/bottomtemplate.php' ?>