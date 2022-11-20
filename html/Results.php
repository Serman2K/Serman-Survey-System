<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<?php 
include "../php/db_conn.php";
?>

<?php 
$qry = $conn->query("SELECT * FROM surveys where id = ".$_GET['sid'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
$takensup1 = $conn->query("SELECT * from answers where survey_id ={$id}")->num_rows;
$takensup2 = $conn->query("SELECT distinct(question_id) from answers where survey_id ={$id}")->num_rows;
if($takensup1==0) {
	header("Location: ../html/ShowSurvey.php?id=".$_GET['sid']);
}
$taken = $takensup1 / $takensup2;

$answers = $conn->query("SELECT a.*,q.type from answers a inner join questions q on q.id = a.question_id where a.survey_id ={$id}");
$ans = array();

while($row=$answers->fetch_assoc()){
	if($row['type'] == 'radio_btn'){
		$ans[$row['question_id']][$row['answer']][] = 1;
	}
	if($row['type'] == 'check_box'){
		foreach(explode(",", str_replace(array("[","]"), '', $row['answer'])) as $v){
		$ans[$row['question_id']][$v][] = 1;
		}
	}
	if($row['type'] == 'text_f'){
		$ans[$row['question_id']][] = $row['answer'];
	}
}
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Results</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/survey.css" rel="stylesheet">
  </head>

  <body>
    <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block sidebar">
            <h1><img class="mt" src="../pictures/Logo.png" alt="" width="200" height="200"></h1>
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <li class="nav-item ms-4">
                  <a href="ShowSurvey.php?id=<?php echo $_GET['sid'] ?>" class="btn btn-primary ms-2 ps-5 pe-5">Back</a>
                </li>

              </ul>
      
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                  <span data-feather="plus-circle"></span>
                </a>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item ms-4">
                  <a href="DeleteResults.php?sid=<?php echo $_GET['sid'] ?>" id="reportBtn" class="btn btn-danger m-2 showBtn">Clear Answers</a>
                </li>
              </ul>
            </div>
          </nav>
      
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Report for <?php echo $stitle ?></h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <a href="PrintReport.php?sid=<?php echo $id ?>" target="_blank" rel="noopener noreferrer" id="showBtn" class="btn btn-success my-2 ps-5 pe-5">Print</a>
                </div>
              </div>
            </div>

            <div>
                <small><?php echo $description; ?></small>
            </div><br>

            <div>
                <?php 
				$question = $conn->query("SELECT * FROM questions where survey_id = $id");
				while($row=$question->fetch_assoc()):	
				?>

                    <div class="callout callout-info">
						<h5><?php echo $row['question'] ?></h5>	
						<div class="col-md-12">
						<input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">	
							
							<?php if($row['type'] != 'text_f'):?>
								<ul>
							<?php foreach(json_decode($row['form_option']) as $k => $v): 
								$prog = ((isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0) / $taken) * 100;
								$prog = round($prog,2);
								?>
								<li>
									<div class="d-block w-100">
										<b><?php echo $v ?></b>
									</div>
									<div class="d-flex w-100">
									<span class=""><?php echo isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0 ?>/<?php echo $taken ?></span>
									<div class="mx-1 col-sm-8">
									<div class="progress w-100" >
					                  <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: <?php echo $prog ?>%">
					                    <span class="sr-only"><?php echo $prog ?>%</span>
					                  </div>
					                </div>
					                </div>
					                <span class="badge badge-info"><?php echo $prog ?>%</span>
									</div>
								</li>
								<?php endforeach; ?>
								</ul>
						<?php else: ?>
							<div class="d-block tfield-area w-75">
								<?php if(isset($ans[$row['id']])): ?>
								<?php foreach($ans[$row['id']] as $val): ?>
								<blockquote class="text-dark"><?php echo $val ?></blockquote>
								<?php endforeach; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						</div>	
					</div>
					<?php endwhile; ?>

            </div>

          </main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>

<script src="../js/Survey.js"></script>

</html>



<?php
}
else {
  header("Location: Login.php");
  exit();
}
?>