<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "db_conn.php";

$qtype = $_POST['qtype'];
$sid = $_POST['sid'];
$question = $_POST['question'];

$qdata = " survey_id=$sid , question='$question' , type='$qtype' ";

extract($_POST);

if($qtype != "text_f") {
  $arr = array();
  foreach ($label as $k => $v) {
    $i = 0 ;
		while($i == 0){
			$k = substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
			if(!isset($arr[$k]))
				$i = 1;
		}
    $arr[$k] = $v;
  }
  $arr2 = json_encode($arr);
  $arr3 = str_replace("\\", "\\\\", $arr2);
  $qdata .= ", form_option='".$arr3."' ";
}
else {
  $qdata .= ", form_option='' ";
}

$save = $conn->query("INSERT INTO questions set $qdata");
header("Location: ../html/ShowSurvey.php?id=$sid");
?>

<?php
}
else {
  header("Location: ../html/Login.php");
  exit();
}
?>