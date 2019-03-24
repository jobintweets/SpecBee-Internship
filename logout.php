<?php
session_start();
session_destroy();
header( "Location:login.php");
// echo 'You have been logged out. <a href="/">Go back</a>';

?>