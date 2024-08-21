<?php
include_once 'Connection.php';

// Import the file where we defined the connection to Database.
$queryMainCategory = "SELECT * FROM tblmaincategory";
$mainCategories = mysqli_query($connect, $queryMainCategory);

$querySubCategory = "SELECT * FROM tblsubcategory";
$subCategories = mysqli_query($connect, $querySubCategory);

$queryImages = "SELECT * FROM tblimages WHERE imageType=3";
$rs_result = mysqli_query($connect, $queryImages);
?>

<style>
    /* Remove the default list style */
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
</style>

<ul>
    <?php
    while ($mainRow = mysqli_fetch_array($mainCategories)) {
        echo '<li>';

        // Check if main category is clickable based on status
        if ($mainRow['status'] == 1) {
            echo '<a href="listcategory.php?mainCategoryID=' . $mainRow['mainCategoryID'] . '">';
        }

        echo '<img src="' . $mainRow["mainCategoryIMAGE"] . '" alt="Main Category" style="width: 100%; display: block;">';

        // Display subcategories under the main category
        mysqli_data_seek($subCategories, 0); // Reset pointer to the beginning
        while ($subRow = mysqli_fetch_array($subCategories)) {
            if ($subRow['mainCategoryID'] == $mainRow['mainCategoryID']) {

                // Check if subcategory is clickable based on status
                if ($subRow['status'] == 1) {
                    echo '<a href="listcategory.php?subcategoryID=' . $subRow['subcategoryID'] . '">';
                }

                echo '<img src="' . $subRow["subcategoryIMAGE"] . '" alt="Subcategory" style="width: 100%; display: block;">';

                // Close subcategory link if it was opened
                if ($subRow['status'] == 1) {
                    echo '</a>';
                }
            }
        }

        // Close main category link if it was opened
        if ($mainRow['status'] == 1) {
            echo '</a>';
        }

        echo '</li>';
    }
    ?>
</ul>

<?php
while ($row = mysqli_fetch_array($rs_result)) {
    // Check if the image is active
    $isActive = ($row['status'] == 1);

    // Get the image source from the "imgSource" column
    $imgSource = $row['imgSource'];

    // Output the image and make it clickable or unclickable accordingly
    if ($isActive) {
        echo '<a href="' . $imgSource . '"><img src="images/' . $row["imageURL"] . '" style="width: 100%;" alt="Image"></a>';
    } else {
        echo '<img src="images/' . $row["imageURL"] . '" style="width: 100%;" alt="Image">';
    }
    echo '<br>';
}
?>