<?php require 'template/toptemplate.php' ?>
<?php
require '../../connections.php';
$sql = "SELECT * from tbl_books_information where status != 'deleted'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>




<div class="container">
    <div class="container" style="max-width: 1000px; overflow-x: auto;">
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addBookModal">Add Books</button>
        </div>
        <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form inside the modal -->
                        <form id="addBookForm" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <label for="bookImage">Book Image</label>
                                <input type="file" onchange="validateFileInput()" class="form-control-file" id="bookImage" name="book_image" accept="image/png, image/jpeg, image/jpg" required>
                                <div class="image-error" style="color:red"></div>
                            </div>
                            <div class="form-group">
                                <label for="bookTitle">Book Title</label>
                                <input type="text" class="form-control" id="bookTitle" name="book_title" required>
                            </div>
                            <div class="form-group">
                                <label for="bookAuthor">Book Author</label>
                                <input type="text" class="form-control" id="bookAuthor" name="book_author" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="add_new_books_button" class="btn btn-primary">Add Book</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table id="data_table" class="table table-striped" >
            <thead>
                <tr>
                    <th>Book Image</th>
                    <th>Book Title</th>
                    <th>Book Author</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><img src="<?php echo $env_basepath ?>assets/book-image/<?php echo $row['book_img'] ?>" alt="Book Image" style="height: 100px; width: 100px;"></td>
                        <td><?php echo $row['book_title'] ?></td>
                        <td><?php echo $row['book_author'] ?></td>
                        <?php
                        $status = $row['status'];
                        $badgeClass = '';

                        switch ($status) {
                            case 'available':
                                $badgeClass = 'badge-success';
                                break;
                            case 'borrowed':
                                $badgeClass = 'badge-warning';
                                break;
                            case 'not available':
                                $badgeClass = 'badge-danger';
                                break;
                        }

                        ?>
                        <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span></td>
                        <td>
                            <?php if ($status == 'available') { ?>
                                <button class="btn btn-dark" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id'] ?>" data-title="<?php echo $row['book_title'] ?>" data-author="<?php echo $row['book_author'] ?>" onclick="editModal(event)">Edit</button>


                                <button class="btn btn-danger" data-id="<?php echo $row['id'] ?>" onclick="confirmDelete(event)">Delete</button>
                            <?php } else { ?>
                                <button class="btn btn-dark" onclick="cantDelete()">Edit</button>
                                <button class="btn btn-danger" onclick="cantDelete()">Delete</button>

                            <?php } ?>


                        </td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="editBookInfo">Image:</label>
                                <input type="file" class="form-control" onchange="validateFileInput()" id="editBookInfo" name="file-image">
                                <div class="image-error" style="color: red"></div>
                            </div>
                            <div class="form-group">
                                <label for="editTitle">Title:</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>

                                <input type="hidden" class="form-control" id="editId" name="book_id" required>
                            </div>
                            <div class="form-group">
                                <label for="editAuthor">Author:</label>
                                <input type="text" class="form-control" id="editAuthor" name="author" required>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveChanges" class="btn btn-primary">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require 'template/bottomtemplate.php' ?>



<script>
    function editModal(event) {

        var id = event.target.getAttribute('data-id');
        var title = event.target.getAttribute('data-title');
        var author = event.target.getAttribute('data-author');
        $('#editId').val(id);
        $('#editTitle').val(title);
        $('#editAuthor').val(author);
    }




    function confirmDelete(event) {
        var bookId = event.target.getAttribute('data-id');
        Swal.fire({
            title: 'Are you sure you want to delete this book?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, i want it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $('.loader-container').fadeIn();
                var formData = new FormData();
                formData.append("action", "delete_book");
                formData.append("book_id", bookId);


                $.ajax({
                    url: "../../controllers/books-controller.php",
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

    function validateFileInput() {
        var fileInput = $('#editBookInfo');
        var fileName = fileInput.val();
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 5 * 1024 * 1024; // 5 MB

        if (fileName.length > 0) {
            // Get file extension
            var fileExtension = fileName.split('.').pop().toLowerCase();

            // Check if the file extension is valid
            if ($.inArray(fileExtension, validExtensions) === -1) {
                $('.image-error').text('Invalid file type. Please select a valid image (png, jpeg, jpg).');
                fileInput.val(''); // Clear the input value
                return false;
            }

            // Check file size
            var fileSize = fileInput[0].files[0].size;
            if (fileSize > maxSize) {
                $('.image-error').text('File size exceeds the maximum limit (5 MB).');
                fileInput.val(''); // Clear the input value
                return false;
            }
        }

        // Clear previous error messages
        $('.image-error').text('');

        return true;
    }
</script>


<script>
    $("#add_new_books_button").click(function(e) {

        if ($("#addBookForm")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#addBookForm")[0]);
            formData.append("action", "add_new_books");

            $.ajax({
                url: "../../controllers/books-controller.php",
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


    function cantDelete() {
        Swal.fire({
            title: "Failed",
            text: "You can't edit or delete this book.",
            icon: "warning"
        });
    }
</script>


<script>
    $("#saveChanges").click(function(e) {

        if ($("#editForm")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#editForm")[0]);
            formData.append("action", "edit_books");

            $.ajax({
                url: "../../controllers/books-controller.php",
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
</script>