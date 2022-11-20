<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "db_conn.php";

if ($stmt = $conn->query("DELETE FROM questions WHERE id=".$_GET['qid'])) {
    header("Location: ../html/ShowSurvey.php?id=".$_GET['sid']);
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