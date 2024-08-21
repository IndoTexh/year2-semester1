<?php  
    include_once 'connection.php';
    // Import the file where we defined the connection to Database.      
    $query = "SELECT * FROM tblimages Where imageType=1";     
    $rs_result = mysqli_query ($connect, $query);    
?>
<div class="row">
   <div class="col-lg-12 border">
    <?php     
        while ($row = mysqli_fetch_array($rs_result)) {    
            // Display each field of the records.    
    ?>
            <img src="images/<?php echo $row["imageURL"] ?>" style="width: 100%;">
            <?php     
        };  
    ?>
   </div>
</div>