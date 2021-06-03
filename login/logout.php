<?php
//Made by Ashwin Pillai 
//Enrollment No. - A80105219015
session_start();
$_SESSION = array();
session_destroy();
header("location:login.php");



?>