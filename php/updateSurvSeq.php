<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "db_conn.php";

if ($stmt = $conn->prepare("UPDATE surveys SET title=?, description=?, start_date=?, end_date=? WHERE id=".$_GET['sid'])) {
    $stmt->bind_param('ssss', $_POST['survey_name'], $_POST['survey_description'], $_POST['survey_start'], $_POST['survey_end']);
    $stmt->execute();
    header("Location: ../html/Index.php?error=Succesfully Updated");
}
else {
    echo 'Error Occurred';
}
?>

<?php
}
else {
  header("Location: ../html/Login.php");
  exit();
}
?>