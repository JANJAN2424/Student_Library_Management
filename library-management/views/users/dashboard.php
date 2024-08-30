<?php require 'template/toptemplate.php'; ?>
<?php
require '../../connections.php';
$sql = "SELECT * from tbl_books_information where status = 'available'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Content Section -->
<div class="container">
<div class="row">

<?php
if (empty($result)) {
    // Display a message when no books are available
    echo '<div class="col-md-12 text-center"><p>No available books.</p></div>';
} else {
    // Iterate through the result if it's not empty
    foreach ($result as $row) {
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo $env_basepath ?>assets/book-image/<?php echo $row['book_img'] ?>" class="card-img-top img-fluid" alt="Book Image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['book_title'] ?></h5>
                    <p class="card-text">Author: <?php echo $row['book_author'] ?></p>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" book-id="<?php echo $row['id'] ?>" onclick="confirmBorrow(event)">Borrow this book</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>
</div>
</div>


<?php require 'template/bottomtemplate.php'; ?>
<script>
    function confirmBorrow(event) {
        var bookId = event.target.getAttribute('book-id');
        Swal.fire({
            title: 'Are you sure you want to borrow this book?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, i want it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $('.loader-container').fadeIn();
                var formData = new FormData();
                formData.append("action", "borrow_this");
                formData.append("book_id", bookId);


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


<script>
    $("#add_new_books_button").click(function(e) {

        if ($("#addBookForm")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#addBookForm")[0]);
            formData.append("action", "add_new_books");


        }
    });
</script>