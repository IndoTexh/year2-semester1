<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    // Insert Image Type
    $name = mysqli_real_escape_string($connect, $_POST['name']);

    // Insert data into tblimagetype
    $insertQuery = "INSERT INTO tblimagetype (imageType) VALUES ('$name')";

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
    // Update Image Type
    $update_id = mysqli_real_escape_string($connect, $_POST['update_id']);
    $update_name = mysqli_real_escape_string($connect, $_POST['update_name']);

    // Update data in tblimagetype
    $updateQuery = "UPDATE tblimagetype SET imageType = '$update_name' WHERE imageTypeID = '$update_id'";

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
    // Delete Image Type
    $delete_id = mysqli_real_escape_string($connect, $_POST['delete_id']);

    // Delete data from tblimagetype
    $deleteQuery = "DELETE FROM tblimagetype WHERE imageTypeID = '$delete_id'";

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
    <title>Image Types Display</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#insertModal">
            Add Image Type
        </button>
        <!-- Insert Modal -->
        <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel"
            aria-hidden="true">
            <!-- Modal Content -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel">Insert Image Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Insert Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="form-group">
                                <label for="name">Image Type:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="insert">Insert</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Types Table -->
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image Type</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tblimagetype";
                $result = mysqli_query($connect, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['imageTypeID'];
                        $name = $row['imageType'];

                        echo '<tr>';
                        echo '<th scope="row">' . $id . '</th>';
                        echo '<td>' . $name . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-primary" data-toggle="modal" data-target="#updateModal"
                            onclick="setUpdateModalData(\'' . $id . '\', \'' . $name . '\')">
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
                        <h5 class="modal-title" id="updateModalLabel">Update Image Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Update Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group">
                                <label for="update_name">Image Type:</label>
                                <input type="text" class="form-control" id="update_name" name="update_name" required>
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
                        <h5 class="modal-title" id="deleteModalLabel">Delete Image Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Delete Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <p>Are you sure you want to delete this Image Type?</p>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setUpdateModalData(id, name) {
            // Set data for the Update Modal
            document.getElementById('update_id').value = id;
            document.getElementById('update_name').value = name;
        }

        function setDeleteModalData(id) {
            // Set data for the Delete Modal
            document.getElementById('delete_id').value = id;
        }
    </script>
</body>

</html>
