<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    // Insert Main Category
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);
    $image = ''; // Initialize image variable

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Handle image upload
        $target_dir = "images/uploads/"; // Change this directory based on your setup
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            // Allow certain file formats
            $allowed_formats = array("jpg", "jpeg", "png", "gif");
            if (in_array($imageFileType, $allowed_formats)) {
                // Move the uploaded file to the desired directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = $target_file;
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "Invalid file format. Allowed formats: " . implode(", ", $allowed_formats);
            }
        } else {
            echo "File is not an image.";
        }
    }

    // Insert data into tblmaincategory
    $insertQuery = "INSERT INTO tblmaincategory (mainCategoryNAME, mainCategoryIMAGE, status) 
                    VALUES ('$name', '$image', '$status')";

    $insertResult = mysqli_query($connect, $insertQuery);

    if ($insertResult) {
        // Insertion successful
        header('Location: dashboard.php');
        exit();
    } else {
        // Insertion failed
        echo "Error: " . mysqli_error($connect);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Update Main Category
    $update_id = mysqli_real_escape_string($connect, $_POST['update_id']);
    $update_name = mysqli_real_escape_string($connect, $_POST['update_name']);
    $update_status = mysqli_real_escape_string($connect, $_POST['update_status']);
    $update_image = ''; // Initialize image variable

    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] == 0) {
        // Handle image upload for update
        $target_dir = "images/uploads/"; // Change this directory based on your setup
        $target_file = $target_dir . basename($_FILES['update_image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['update_image']['tmp_name']);
        if ($check !== false) {
            // Allow certain file formats
            $allowed_formats = array("jpg", "jpeg", "png", "gif");
            if (in_array($imageFileType, $allowed_formats)) {
                // Move the uploaded file to the desired directory
                if (move_uploaded_file($_FILES['update_image']['tmp_name'], $target_file)) {
                    $update_image = $target_file;
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "Invalid file format. Allowed formats: " . implode(", ", $allowed_formats);
            }
        } else {
            echo "File is not an image.";
        }
    }

    // Update data in tblmaincategory
    $updateQuery = "UPDATE tblmaincategory 
                    SET mainCategoryNAME = '$update_name', mainCategoryIMAGE = '$update_image', status = '$update_status'
                    WHERE mainCategoryID = '$update_id'";

    $updateResult = mysqli_query($connect, $updateQuery);

    if ($updateResult) {
        // Update successful
        header('Location: dashboard.php');
        exit();
    } else {
        // Update failed
        echo "Error: " . mysqli_error($connect);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Delete Main Category
    $delete_id = mysqli_real_escape_string($connect, $_POST['delete_id']);

    // Delete data from tblmaincategory
    $deleteQuery = "DELETE FROM tblmaincategory WHERE mainCategoryID = '$delete_id'";

    $deleteResult = mysqli_query($connect, $deleteQuery);

    if ($deleteResult) {
        // Deletion successful
        header('Location: dashboard.php');
        exit();
    } else {
        // Deletion failed
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Category Display</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#insertModal">
            Add Main Category
        </button>
        <!-- Insert Modal -->
        <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel"
            aria-hidden="true">
            <!-- Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel">Insert Main Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Insert Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                    onchange="previewImage(this)">
                                <img id="imagePreview" src="#" alt="Image Preview"
                                    style="display:none; max-width: 100%; max-height: 200px; margin-top: 10px;">
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <input type="text" class="form-control" id="status" name="status" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="insert">Insert</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Category Table -->
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblmaincategory";
                $result = mysqli_query($connect, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['mainCategoryID'];
                        $name = $row['mainCategoryNAME'];
                        $image = $row['mainCategoryIMAGE'];
                        $status = $row['status'];

                        echo '<tr>';
                        echo '<th scope="row">' . $id . '</th>';
                        echo '<td>' . $name . '</td>';
                        echo '<td><img src="' . $image . '" alt="Image" class="img-thumbnail"></td>';
                        echo '<td>' . $status . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-primary" data-toggle="modal" data-target="#updateModal"
                            onclick="setUpdateModalData(\'' . $id . '\', \'' . $name . '\', \'' . $image . '\', \'' . $status . '\')">
                            Update
                            </button>';
                        echo '<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                            onclick="setDeleteModalData(\'' . $id . '\')">
                            Delete
                            </button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Update Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
            aria-hidden="true">
            <!-- Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Main Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Update Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group">
                                <label for="update_name">Name:</label>
                                <input type="text" class="form-control" id="update_name" name="update_name" required>
                            </div>
                            <div class="form-group">
                                <label for="update_image">Image:</label>
                                <input type="file" class="form-control" id="update_image" name="update_image"
                                    accept="image/*" onchange="previewUpdateImage(this)">
                                <img id="updateImagePreview" src="" alt="Image Preview"
                                    style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                            </div>
                            <div class="form-group">
                                <label for="update_status">Status:</label>
                                <input type="text" class="form-control" id="update_status" name="update_status" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <!-- Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Main Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Delete Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <p>Are you sure you want to delete this Main Category?</p>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('imagePreview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }

        function previewUpdateImage(input) {
            var preview = document.getElementById('updateImagePreview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        }

        function setUpdateModalData(id, name, image, status) {
            // Set data for the Update Modal
            document.getElementById('update_id').value = id;
            document.getElementById('update_name').value = name;
            document.getElementById('updateImagePreview').src = image;
            document.getElementById('update_status').value = status;
        }

        function setDeleteModalData(id) {
            // Set data for the Delete Modal
            document.getElementById('delete_id').value = id;
        }
    </script>
</body>

</html>
