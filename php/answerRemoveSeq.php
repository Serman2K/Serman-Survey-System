<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include '../php/db_conn.php';

if ($stmt = $conn->query("DELETE FROM answers WHERE survey_id=".$_GET['sid'])) {
    header("Location: ../html/ShowSurvey.php?id=".$_GET['sid']);
}
else {
    echo 'Error Occurred';
}
?>

<?php
}
else {
  header("Location: Login.php");
  exit();
}
?>