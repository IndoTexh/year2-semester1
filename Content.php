<?php
include 'connection.php';

// Insert Article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    // Sanitize user input to prevent SQL Injection
    $mainid = mysqli_real_escape_string($connect, $_POST['mainid']);
    $subid = mysqli_real_escape_string($connect, $_POST['subid']);
    $content = mysqli_real_escape_string($connect, $_POST['tiny']);

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

    // Insert data into tblInformation
    $insertQuery = "INSERT INTO tblInformation (mainCategoryID, subcategoryID, articleContent, articleImage) 
                    VALUES ('$mainid', '$subid', '$content', '$image')";

    $insertResult = mysqli_query($connect, $insertQuery);

    if ($insertResult) {
        // Insertion successful
        header('Location: Content.php');
        exit();
    } else {
        // Insertion failed
        echo "Error: " . mysqli_error($connect);
    }
}

// Update Article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Sanitize user input to prevent SQL Injection
    $update_id = mysqli_real_escape_string($connect, $_POST['update_id']);
    $update_mainid = mysqli_real_escape_string($connect, $_POST['update_mainid']);
    $update_subid = mysqli_real_escape_string($connect, $_POST['update_subid']);
    $update_content = mysqli_real_escape_string($connect, $_POST['update_content']);

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

    // Update data in tblInformation
    $updateQuery = "UPDATE tblInformation 
                    SET mainCategoryID = '$update_mainid', subcategoryID = '$update_subid', articleContent = '$update_content', articleImage = '$update_image'
                    WHERE articleID = '$update_id'";

    $updateResult = mysqli_query($connect, $updateQuery);

    if ($updateResult) {
        // Update successful
        header('Location: Content.php');
        exit();
    } else {
        // Update failed
        echo "Error: " . mysqli_error($connect);
    }
}

// Delete Article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Sanitize user input to prevent SQL Injection
    $delete_id = mysqli_real_escape_string($connect, $_POST['delete_id']);

    // Delete data from tblInformation
    $deleteQuery = "DELETE FROM tblInformation WHERE articleID = '$delete_id'";

    $deleteResult = mysqli_query($connect, $deleteQuery);

    if ($deleteResult) {
        // Deletion successful
        header('Location: Content.php');
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
    <title>Articles Display</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="js/tinymce/tinymce.min.js">
    <link rel="stylesheet" href="js/tinymce/skins/ui/oxide/skin.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- ... (your previous code) ... -->
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
    <div class="container my-5">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#insertModal">
            Add Article
        </button>
        <a href="dashboard.php" class="btn btn-danger mb-3">Go back!</a>
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
                <label for="subid">Subcategory:</label>
                <select class="form-control" id="subid" name="subid" required>
                    <?php
                    $subcategoryQuery = "SELECT * FROM tblsubcategory";
                    $subcategoryResult = mysqli_query($connect, $subcategoryQuery);

                    if ($subcategoryResult) {
                        while ($subcategoryRow = mysqli_fetch_assoc($subcategoryResult)) {
                            $subCategoryID = $subcategoryRow['subcategoryID'];
                            $subCategoryName = $subcategoryRow['subName'];

                            echo '<option value="' . $subCategoryID . '">' . $subCategoryName . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="tinymce-editor" name="tiny">
              </textarea><!-- End TinyMCE Editor -->
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width: 100%; max-height: 200px; margin-top: 10px;">
            </div>
            <button type="submit" class="btn btn-primary" name="insert">Insert</button>
        </form>

        <!-- Update Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <!-- Update Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Article</h5>
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
                                <label for="update_subid">Subcategory:</label>
                                <select class="form-control" id="update_subid" name="update_subid" required>
                                    <?php
                                    $subcategoryQuery = "SELECT * FROM tblsubcategory";
                                    $subcategoryResult = mysqli_query($connect, $subcategoryQuery);

                                    if ($subcategoryResult) {
                                        while ($subcategoryRow = mysqli_fetch_assoc($subcategoryResult)) {
                                            $subCategoryID = $subcategoryRow['subcategoryID'];
                                            $subCategoryName = $subcategoryRow['subName'];

                                            echo '<option value="' . $subCategoryID . '">' . $subCategoryName . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="update_content">Content:</label>
                                <textarea class="tinymce-editor" name="update_content"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="update_image">Image:</label>
                                <input type="file" class="form-control" id="update_image" name="update_image" accept="image/*" onchange="previewUpdateImage(this)">
                                <img id="updateImagePreview" src="" alt="Image Preview" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <!-- Delete Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Article</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Delete Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <p>Are you sure you want to delete this Article?</p>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles Table -->
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Main Category ID</th>
                    <th scope="col">Subcategory ID</th>
                    <th scope="col">Content</th>
                    <th scope="col">Image</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblInformation";
                $result = mysqli_query($connect, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['articleID'];
                        $mainid = $row['mainCategoryID'];
                        $subid = $row['subcategoryID'];
                        $content = $row['articleContent'];
                        $image = $row['articleImage'];

                        echo '<tr>';
                        echo '<th scope="row">' . $id . '</th>';
                        echo '<td>' . $mainid . '</td>';
                        echo '<td>' . $subid . '</td>';
                        echo '<td>' . $content . '</td>';
                        echo '<td><img src="' . $image . '" alt="Image" class="img-thumbnail"></td>';
                        echo '<td>';
                        echo '<button class="btn btn-primary" data-toggle="modal" data-target="#updateModal" onclick="setUpdateModalData()">';
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

            reader.onloadend = function() {
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

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        }

        function setUpdateModalData(id, mainid, subid, content, image) {
            // Set data for the Update Modal
            document.getElementById('update_id').value = id;
            document.getElementById('update_mainid').value = mainid;
            document.getElementById('update_subid').value = subid;
            tinymce.get('update_content').setContent(content);
            document.getElementById('updateImagePreview').src = image;
        }

        function setDeleteModalData(id) {
            // Set data for the Delete Modal
            document.getElementById('delete_id').value = id;
        }
    </script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>