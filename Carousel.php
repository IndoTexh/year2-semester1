<!-- <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/Center/Travel/image1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/Center/Travel/image2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/Center/Travel/image3.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
</div> -->

<?php
include_once 'Connection.php';

// Assuming you have a table named 'carousel_images' with columns 'image_url' and 'active'
$query = "SELECT imageURL FROM tblimages WHERE imageType = 2";
$rs_result = mysqli_query($connect, $query);
?>

<div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $firstItem = true; // To track the first item for setting it as active
        while ($row = mysqli_fetch_array($rs_result)) {
            $activeClass = $firstItem ? 'active' : ''; // Set active class for the first item
            ?>
            <div class="carousel-item <?php echo $activeClass; ?>">
                <img src="<?php echo $row['imageURL']; ?>" class="d-block w-100" alt="...">
            </div>
            <?php
            $firstItem = false; // Set to false after the first item
        }
        ?>
    </div>
</div>