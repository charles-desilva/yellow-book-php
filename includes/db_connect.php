<?php 
$con = mysqli_connect("localhost:3307", "root", "", "db_yellowbook");

// 3.2 Connection Errror debuging
if (mysqli_connect_errno($con)){
    echo "Error: " . mysqli_error($con);
    
}
?>