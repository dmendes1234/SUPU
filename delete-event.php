<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);

$event_id = $_GET['editid'];

$query = mysqli_query($con, "DELETE FROM `events` WHERE `events`.`ID` = '$event_id'");
if ($query) {
    echo '<script>
      alert("Događaj uspješno izbrisan");
 </script>';
    $url = $_SERVER["REQUEST_URI"]; 
    $pos = strrpos($url, "index.php"); 

    if ($pos == true) {
        header('location:index.php');
    }
    else {
        header('location:all-events.php');
    }

} else {

    echo '<script>alert("Something Went Wrong. Please try again.")</script>';
}
