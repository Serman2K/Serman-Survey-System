<?php
$sname= "localhost";
$unmae= "root";
$password = "";
$db_name = "serman_survey_system";
$con = mysqli_connect($sname, $unmae, $password, $db_name);
if (mysqli_connect_error()) {
    exit('Error connecting to the database' . mysqli_connect_error());
}

$con->close();
?>