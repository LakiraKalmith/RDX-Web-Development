<?php 

     mysqli_report(MYSQLI_REPORT_OFF);
     
    $conn=mysqli_connect('localhost','root','','rdx_store') 
    or
    die("Connection Failed");

    mysqli_set_charset($conn, "utf8mb4");


