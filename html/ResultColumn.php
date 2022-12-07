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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
              <ul class="nav flex-column mb-2">
			  	<li class="nav-item m-4">
                  <span><b>Taken: <?php echo $taken?></b></span>
                </li>
                <li class="nav-item ms-4">
                  <a href="ShowSurvey.php?id=<?php echo $_GET['sid'] ?>" class="btn btn-primary ms-2 ps-5 pe-5">Back</a>
                </li>
              </ul>

              <ul class="nav flex-column mb-2">
                <li class="nav-item ms-4">
                  <a href="DeleteResults.php?sid=<?php echo $_GET['sid'] ?>" id="reportBtn" class="btn btn-danger m-2 showBtn">Clear Answers</a>
                </li>
              </ul>

			  <ul class="nav flex-column mb-2">
                <li class="nav-item ms-4">
					<button id="printBtn" onclick="window.print();return false;" class="btn btn-success ms-2 ps-5 pe-5">Print</button>
                </li>
              </ul>

			  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-3 text-muted">
                <span>Diagrams type:</span>
              </h6>
			  <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="ResultPie.php?sid=<?php echo $_GET['sid'] ?>" class="btn btn-primary ms-2 w-75">Pie Chart</a>
                </li>
				<li class="nav-item">
                  <a href="ResultBar.php?sid=<?php echo $_GET['sid'] ?>" class="btn btn-primary ms-2 w-75">Bar Chart</a>
                </li>
				<li class="nav-item">
                  <a href="Results.php?sid=<?php echo $_GET['sid'] ?>" class="btn btn-primary ms-2 w-75">Standard Chart</a>
                </li>
              </ul>
            </div>
          </nav>
      
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Report for <?php echo $stitle ?></h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                <span><b>Taken: <?php echo $taken?></b></span>
                </div>
              </div>
            </div>

            <div>
                <small><?php echo $description; ?></small>
            </div><br>

            <div>
                <?php 
                $nr = 1;
				$question = $conn->query("SELECT * FROM questions where survey_id = $id");
				while($row=$question->fetch_assoc()):	
				?>

          <div class="callout callout-info">
						<div class="col-md-12">
						<input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">	
							
							<?php if($row['type'] != 'text_f'):?>
								<ul class="ResultsArea">
                  <div id="chartQ--<?php echo $nr ?>" style="height: 500px; width: 90%;"></div>
								</ul>

						<?php else: ?>
              <h5><?php echo $row['question'] ?></h5>	
							<div class="d-block tfield-area w-75">
								<?php if(isset($ans[$row['id']])): ?>
								<?php foreach($ans[$row['id']] as $val): ?>
								<blockquote class="text-dark"><?php echo $val ?></blockquote>
								<?php endforeach; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
            <br>
						</div>	
					</div>
					<?php 
            $nr = $nr + 1;
            endwhile; 
          ?>

            </div>

          </main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>

<script>
  google.charts.load('current', { 'packages': ['corechart', 'bar'] });
  google.charts.setOnLoadCallback(drawTopX);

  function drawTopX() {

    <?php 
    $qmax = 1;
    $questionChart = $conn->query("SELECT * FROM questions where survey_id = $id");
    ?>

    <?php 
      while($row=$questionChart->fetch_assoc()):	
        if ($row['type'] == 'text_f') {
          $qmax = $qmax + 1;
          continue;
        }
    ?>


var data = google.visualization.arrayToDataTable([
          ['Answers', 'Votes'],
          <?php foreach(json_decode($row['form_option']) as $k => $v): 
              $prog = (isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0);
              echo "['".$v."', ".$prog."],";
            endforeach;
          ?>
        ]);

    var options = {
      legend: { position: 'none' },
      titleTextStyle: {
          color: '#000000',
          fontSize: 20
        },
      chart: {
        title: "<?php echo $row['question'] ?>"
        }
    };
    var checkChart = document.getElementById(`chartQ--${<?php echo $qmax?>}`);

    if(checkChart)
    {
      var chart2 = new google.charts.Bar(checkChart);
      chart2.draw(data, google.charts.Bar.convertOptions(options));
    }

    <?php 
      $qmax = $qmax + 1;
      endwhile; 
    ?>
}
</script>

<?php
}
else {
  header("Location: Login.php");
  exit();
}
?>