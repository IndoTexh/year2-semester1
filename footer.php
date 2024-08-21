<?php  
    include_once 'Connection.php';
    // Import the file where we defined the connection to Database.      
    $query = "SELECT * FROM tblimages Where imageType=5";     
    $rs_result = mysqli_query ($connect, $query);    
?>

<?php     
        while ($row = mysqli_fetch_array($rs_result)) {    
            // Display each field of the records.    
?>
        <img src="images/<?php echo $row["imageURL"] ?>" style="width: 100%;">
        <?php     
        };  
    ?>