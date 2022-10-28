<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include '../php/db_conn.php';
$qry = $conn->query("SELECT * FROM surveys where id = ".$_GET['id'])->fetch_array();
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
    <title>Edit Survey</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/editsurvey.css" rel="stylesheet">
  </head>

<body>

<main class="text-center align-center">
<h1><img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200"></h1>

<form action="../php/updateSurvSeq.php?sid=<?php echo $_GET['id'] ?>" method="post">
    <div class="text-center">
        <div class="w-100 text-center">
            <h2>Edit Survey</h2>
            <p class="lead text-muted">Survey name</p>
            <input type="text" class="form-control mb-4 Survey-Name" name="survey_name" id="surveyName" value="<?php echo $stitle ?>" required>

            <p class="lead text-muted">Survey description</p>
            <textarea class="form-control mb-4 Survey-Description" name="survey_description"
                id="surveyDescription" required><?php echo $description ?></textarea>

            <p class="lead text-muted">Start</p>
            <input type="datetime-local" class="form-control mb-4 Survey-Start" name="survey_start" value="<?php echo $start_date ?>" id="surveyStart">

            <p class="lead text-muted">End</p>
            <input type="datetime-local" class="form-control mb-4 Survey-End" name="survey_end" value="<?php echo $end_date ?>" id="surveyEnd">

            <div>
                <button type="submit" name="submit" class="add-Survey-Btn btn btn-primary w-25" id="btnCreateSurvey"
                    value="Update">Update</button>
            </div>
        </div>
    </div>
</form>
</main>

<div class="text-center">
  <button class="mt-2 btn text-center align-center btn-secondary w-10" id="closeBtn" onclick="location.href='../html/Index.php'">Cancel</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
  </body>
</html>

<?php
}
else {
  header("Location: Login.php");
  exit();
}
?>