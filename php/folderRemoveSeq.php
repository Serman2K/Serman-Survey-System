<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include '../php/db_conn.php';
$qry = $conn->query("SELECT * FROM surveys where id = ".$_GET['sid'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}

unlink('../sb/'.$Folder.'/link.txt');
rmdir('../sb/'.$Folder);

if ($stmt = $conn->query("DELETE FROM surveys WHERE id=".$_GET['sid'])) {
    header("Location: ../html/Index.php?error=Succesfully Removed");
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