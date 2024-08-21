<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beltei Tours</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body style="background-color:#7ba46a; font-family: Khmer OS Siemreap;">
    <div class="container my-5" style="background-color: white;">
        <div>
            <?php include("header.php"); ?>
            <hr />
        </div>
        <div class="row">
            <div class="col-md-2" style="border-right: 1px solid gray;">
                <?php include("leftside.php"); ?>
            </div>
            <div class="col-md-8" style="border-top: 1px dotted gray;">
                <?php
                include_once 'Connection.php';

                // Get the categoryID and subCategoryID from the query parameters
                $categoryid = isset($_GET["mainCategoryID"]) ? $_GET["mainCategoryID"] : null;
                $subCategoryID = isset($_GET["subcategoryID"]) ? $_GET["subcategoryID"] : null;

                // Check if subCategoryID is set, display content for subcategory
                if ($subCategoryID) {
                    $query = "SELECT * FROM tblinformation WHERE subcategoryID  = $subCategoryID";
                    $result = mysqli_query($connect, $query);


                    // Fetch the result into $row
                    $row = mysqli_fetch_assoc($result);

                    // Check if $row is not null before trying to access its elements
                    if ($row !== null) {
                        echo '<div class="container">';
                        echo $row['articleContent'];
                        echo '</div>';
                    } else {
                        // Handle the case where $row is null (no more rows)
                        echo '<div class="container">No content available</div>';
                    }
                } else {
                    // Check if mainCategoryID is 1, redirect to index.php
                    if ($categoryid == 1) {
                        echo '<script>window.location.href = "index.php";</script>';
                        exit();
                    }

                    // Display content for main category
                    $query = "SELECT * FROM tblmaincategory WHERE mainCategoryID = $categoryid";
                    $result = mysqli_query($connect, $query);

                    // Fetch the result into $row
                    $row = mysqli_fetch_assoc($result);
                    // Execute query and display content
                }

                // Rest of your code for displaying content based on category and subcategory
                ?>
            </div>
            <div class="col-md-2" style="border-left: 1px solid gray;">
                <?php include("rightside.php"); ?>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
</body>

</html>