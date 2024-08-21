<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="components/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="components/jquery-3.7.1.min.js"></script>
</head>
<style>
    #OneTime {
        text-decoration: none;
    }

    #OneTime:hover {
        text-decoration: underline;
    }
</style>

<body>

    <?php
    include_once 'Connection.php';
    // Import the file where we defined the connection to Database.      
    $query = "SELECT * FROM tblimages Where imageType=7";
    $rs_result = mysqli_query($connect, $query);
    $querycategory = "SELECT * FROM tblcategory";
    $category = mysqli_query($connect, $querycategory);
    ?>

    <div>
        <?php
        while ($row = mysqli_fetch_array($rs_result)) {
            // Display each field of the records.    
            ?>
            <img src="images/Center/<?php echo $row["imageURL"] ?>" style="width: 100%;">
            <br><br>
            <?php
        }
        ;
        ?>
    </div>
    <div class="row">
        <div class="col-lg-6 p-3">
            <a href="#"><img src="images/Center/tour_facebook.png" width="100%"></a>
        </div>
        <div class="col-lg-6 p-3">
            <a href="#"><img src="images/Center/beltei_youtube.png" width="100%"></a>
        </div>
    </div>
    <br />
    <div style="font-family: Khmer OS Siemreap;">
        <center>
            <p style="color: green; font-size: 20px;">
                ដំណើរទស្សនកិច្ចចុងសប្តាហ៍របស់ ថ្នាក់ដឹកនាំ ប៊ែលធី គ្រុប
            </p>
            <p style="color: green; font-size: 20px;">
                ទៅកាន់ខេត្តព្រះសីហនុ ធ្វើដំណើរតាមផ្លូវល្បឿនលឿន
            </p>
            <p style="color: green; font-size: 20px;">
                ​​ថ្ងៃ​ទី០២ ខែតុលា ឆ្នាំ​២០២២​
            </p>
            <a href="#" id="OneTime">
                <p style="font-size: 20px;">សូម​ចុចលើ​រូប​ សម្រាប់​ព័ត៌មាន​លម្អិត</p>
            </a>
        </center>
    </div>
    <?php include("Carousel.php");
    ?>
    <div>
        <img src="images/Center/beltei_tour_in_cambodia_new_promotion_to_china.jpg" width="100%">
        <img src="images/Center/beltei_tour_new_promotion.jpg" width="100%">
    </div>

</body>

</html>