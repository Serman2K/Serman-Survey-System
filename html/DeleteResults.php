<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include '../php/db_conn.php';
$qry = $conn->query("SELECT title FROM surveys where id = ".$_GET['sid'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Delete Results</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="../css/conf.css" rel="stylesheet">
</head>

<body>
    <div class="text-center confirmation">
        <img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200">
        <h3>Are you sure you want to clear answers for:</h3>
        <h2 class="pt-3"><?php echo $stitle ?></h2>
        <div>
            <a href="../php/answerRemoveSeq.php?sid=<?php echo $_GET['sid'] ?>"><button class="mt-4 m-5 btn btn-danger" id="confirmBtn">Confirm</button></a>
            <button class="mt-4 m-5 btn btn-secondary" id="closeBtn" onclick="location.href='../html/Results.php?sid=<?php echo $_GET['sid'] ?>'">Cancel</button>
        </div>
    </div>
</body>

</html>

<?php
}
else {
  header("Location: Login.php");
  exit();
}
?>