<?php
include_once 'Connection.php';
// Import the file where we defined the connection to Database.      
$query = "SELECT * FROM tblimages Where imageType=4";
$rs_result = mysqli_query($connect, $query);
?>

<html>

<body>
    <div>
        <img src="images/RightSide/Top/change_languages.gif" style="width: 100%;" usemap="#image-map">
        <map name="image-map">
            <area target="" alt="Khmer" title="Khmer" href="#" coords="85,57,8,1" shape="rect">
            <area target="" alt="English" title="English" href="#" coords="189,57,111,1" shape="rect">
        </map>
    </div>
</body>

</html>

<?php
while ($row = mysqli_fetch_array($rs_result)) {
    // Check if the image is active
    $isActive = ($row['status'] == 1);

    // Output the image with or without a link accordingly
    if ($isActive) {
        echo '<a href="' . $row['imgSource'] . '">';
        echo '<img src="images/' . $row["imageURL"] . '" style="width: 100%;">';
        echo '</a>';
    } else {
        echo '<img src="images/' . $row["imageURL"] . '" style="width: 100%;">';
    }

    echo '<br>';
};
?>

<p style="color: blue;">
    យើងមាន ភ្ញៀវ 72 នាក់កំពុងបើកមើល
</p>
<br />
<p style="color: blue;">
    ចំនួនអ្នកមើល 375805
</p>