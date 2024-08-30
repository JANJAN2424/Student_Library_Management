<?php require 'template/toptemplate.php'; ?>
<?php
require '../../connections.php';
$user_id = $_SESSION['user_id'];


$sql = "SELECT tbl_borrowed_books.id as borrow_id, tbl_borrowed_books.*, tbl_books_information.* from tbl_borrowed_books JOIN tbl_books_information on tbl_borrowed_books.book_id = tbl_books_information.id where tbl_borrowed_books.borrower_id = :user_id";
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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><img src="<?php echo $env_basepath ?>assets/book-image/<?php echo $row['book_img'] ?>" alt="Book Image" style="height: 100px; width: 100px;"></td>
                <td><?php echo $row['book_title'] ?></td>
                <td><?php echo $row['book_author'] ?></td>
                <td><button class="btn btn-primary" borrow-id="<?php echo $row['borrow_id'] ?>" book-id="<?php echo $row['book_id'] ?>" onclick="returnBook(event)">Return this</button></td>
            </tr>

        <?php } ?>

    </tbody>
</table>
</div>
<?php require 'template/bottomtemplate.php'; ?>
<script>
    function returnBook(event) {
        var bookId = event.target.getAttribute('book-id');
        var borrowId = event.target.getAttribute('borrow-id');
        Swal.fire({
            title: 'Are you sure you want to return this book?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, i want it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader-container').fadeIn();
                var formData = new FormData();
                formData.append("action", "return_this");
                formData.append("book_id", bookId);
                formData.append("borrow_id", borrowId);


                $.ajax({
                    url: "../../controllers/transaction-controller.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        setTimeout(function() {
                            $('.loader-container').fadeOut();
                        }, 500);
                        if (response.status === "failed") {
                            Swal.fire({
                                title: 'Failed!',
                                text: response.message,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.status === "error") {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else if (response.status === "success") {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the error here
                        var errorMessage = 'An error occurred while processing your request.';
                        if (xhr.statusText) {
                            errorMessage += ' ' + xhr.statusText;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                location.reload();
                            }
                        });
                    }
                });
            }
        });
    }
</script>