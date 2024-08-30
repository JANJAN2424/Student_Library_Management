<?php require 'template/toptemplate.php'; ?>
<?php
require '../../connections.php';
$user_id = $_SESSION['user_id'];


$sql = "SELECT * from tbl_transaction JOIN tbl_books_information on tbl_transaction.book_id = tbl_books_information.id where tbl_transaction.borrower_id = :user_id order by tbl_transaction.timestamp desc";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container" style="max-width: 90%; overflow-x: auto;">
<table id="data_table" class="table table-striped">
    <thead>
        <tr>
            <th>Book Image</th>
            <th>Book Title</th>
            <th>Book Author</th>
            <th>Type</th>
            <th>Description</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><img src="<?php echo $env_basepath ?>assets/book-image/<?php echo $row['book_img'] ?>" alt="Book Image" style="height: 100px; width: 100px;"></td>
                <td><?php echo $row['book_title'] ?></td>
                <td><?php echo $row['book_author'] ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['timestamp'] ?></td>

            </tr>

        <?php } ?>

    </tbody>
</table>
</div>
<?php require 'template/bottomtemplate.php'; ?>