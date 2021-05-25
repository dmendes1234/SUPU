<?php
    $con = mysqli_connect("localhost", "root", "", "supu");
    if(mysqli_connect_errno()){
        echo "Spoj na bazu neuspješan!".mysqli_connect_errno();
    }
?>