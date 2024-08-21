<?php
include 'connection.php';

// Insert Subcategory
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    // Sanitize user input to prevent SQL Injection
    $mainid = mysqli_real_escape_string($connect, $_POST['mainid']);
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);

    // Handle image upload
    $image = ''; // Initialize image variable

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Check if the file was uploaded without errors
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

    // Insert data into tblsubcategory
    $insertQuery = "INSERT INTO tblsubcategory (mainCategoryID, subName, subcategoryIMAGE, status) 
                    VALUES ('$mainid', '$name', '$image', '$status')";

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

// Update Subcategory
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Sanitize user input to prevent SQL Injection
    $update_id = mysqli_real_escape_string($connect, $_POST['update_id']);
    $update_mainid = mysqli_real_escape_string($connect, $_POST['update_mainid']);
    $update_name = mysqli_real_escape_string($connect, $_POST['update_name']);
    $update_status = mysqli_real_escape_string($connect, $_POST['update_status']);

    // Handle image upload
    $update_image = ''; // Initialize image variable

    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] == 0) {
        // Check if the file was uploaded without errors
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

    // Update data in tblsubcategory
    $updateQuery = "UPDATE tblsubcategory 
                    SET mainCategoryID = '$update_mainid', subName = '$update_name', subcategoryIMAGE = '$update_image', status = '$update_status'
                    WHERE subcategoryID = '$update_id'";

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

// Delete Subcategory
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Sanitize user input to prevent SQL Injection
    $delete_id = mysqli_real_escape_string($connect, $_POST['delete_id']);

    // Delete data from tblsubcategory
    $deleteQuery = "DELETE FROM tblsubcategory WHERE subcategoryID = '$delete_id'";

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
    <title>Subcategories Display</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#insertModal">
            Add Subcategory
        </button>
        <!-- Insert Modal -->
        <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel"
            aria-hidden="true">
            <!-- Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel">Insert Subcategory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Insert Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="mainid">Main Category:</label>
                                <select class="form-control" id="mainid" name="mainid" required>
                                    <?php
                                    $mainCategoryQuery = "SELECT * FROM tblmaincategory";
                                    $mainCategoryResult = mysqli_query($connect, $mainCategoryQuery);

                                    if ($mainCategoryResult) {
                                        while ($mainCategoryRow = mysqli_fetch_assoc($mainCategoryResult)) {
                                            $mainCategoryID = $mainCategoryRow['mainCategoryID'];
                                            $mainCategoryName = $mainCategoryRow['mainCategoryNAME'];

                                            echo '<option value="' . $mainCategoryID . '">' . $mainCategoryName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
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

        <!-- Update Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
            aria-hidden="true">
            <!-- Update Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Subcategory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Update Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group">
                                <label for="update_mainid">Main Category:</label>
                                <select class="form-control" id="update_mainid" name="update_mainid" required>
                                    <?php
                                    $mainCategoryQuery = "SELECT * FROM tblmaincategory";
                                    $mainCategoryResult = mysqli_query($connect, $mainCategoryQuery);

                                    if ($mainCategoryResult) {
                                        while ($mainCategoryRow = mysqli_fetch_assoc($mainCategoryResult)) {
                                            $mainCategoryID = $mainCategoryRow['mainCategoryID'];
                                            $mainCategoryName = $mainCategoryRow['mainCategoryNAME'];

                                            echo '<option value="' . $mainCategoryID . '">' . $mainCategoryName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
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
                                <input type="text" class="form-control" id="update_status" name="update_status"
                                    required>
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
            <!-- Delete Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Subcategory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Delete Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <p>Are you sure you want to delete this Subcategory?</p>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subcategories Table -->
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Main Category ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblsubcategory";
                $result = mysqli_query($connect, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['subcategoryID'];
                        $mainid = $row['mainCategoryID'];
                        $name = $row['subName'];
                        $image = $row['subcategoryIMAGE'];
                        $status = $row['status'];

                        echo '<tr>';
                        echo '<th scope="row">' . $id . '</th>';
                        echo '<td>' . $mainid . '</td>';
                        echo '<td>' . $name . '</td>';
                        echo '<td><img src="' . $image . '" alt="Image" class="img-thumbnail"></td>';
                        echo '<td>' . $status . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-primary" data-toggle="modal" data-target="#updateModal" onclick="setUpdateModalData(\'' . $id . '\', \'' . $mainid . '\', \'' . $name . '\', \'' . $image . '\', \'' . $status . '\')">';
                        echo 'Update';
                        echo '</button>';
                        echo '<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteModalData(\'' . $id . '\')">';
                        echo 'Delete';
                        echo '</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
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

        function setUpdateModalData(id, mainid, name, image, status) {
            // Set data for the Update Modal
            document.getElementById('update_id').value = id;
            document.getElementById('update_mainid').value = mainid;
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