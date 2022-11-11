<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "db_conn.php";

	function createDirectory() {
		$add = generateRandomString();
		mkdir("../sb/".$add);
		$add2 = "../sb/".$add;
		$myfile = fopen($add2 . "/link.txt", "w");
		fwrite($myfile, $add);
		fwrite($myfile, "\n");
		fwrite($myfile, $_SESSION['id']);
		fclose($myfile);
        return $add;
	}

function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($stmt = $conn->prepare('INSERT INTO surveys (user_id, title, Folder, description, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)')) {
    $folder = createDirectory();
    $stmt->bind_param('isssss', $_SESSION['id'], $_POST['survey_name'], $folder, $_POST['survey_description'], $_POST['survey_start'], $_POST['survey_end']);
    $stmt->execute();
    header("Location: ../html/Index.php?error=Succesfully Created");
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