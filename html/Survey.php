<?php
include "../../php/db_conn.php";
?>

<?php
$file = fopen("link.txt", "r");
$qid = fgets($file);
fclose($file);

$surv = $conn->query("SELECT * FROM surveys WHERE id = $qid")->fetch_array();
foreach($surv as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}

$ActDate = date('Y-m-d H:i:s', time());
$SurvDateStart = date('Y-m-d H:i:s', strtotime($start_date));
$SurvDateEnd = date('Y-m-d H:i:s', strtotime($end_date));

if($ActDate > $SurvDateStart && $ActDate < $SurvDateEnd){
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Survey</title>
  <link rel="icon" type="favicon" href="../../pictures/favicon.ico">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../../css/main.css" rel="stylesheet">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block sidebar">
        <h1><img class="mt" src="../../pictures/Logo.png" alt="" width="200" height="200"></h1>
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="../../html/Login.php">
                Login Page
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2"><?php echo $stitle ?></h1>
        </div>
        <p class="lead text-muted empty-message"><?php echo $description; ?></p>

        <form class="py-5 container" action="../../php/answerSeq.php" method="post">
          <input type="hidden" name="survey_id" value="<?php echo $id ?>">
          <?php 
					  $question = $conn->query("SELECT * FROM questions where survey_id = $id");
					  while($row=$question->fetch_assoc()):	
					?>

          <div>
            <div style="display: inline-block;">
                <h5 class="pt-4"><?php echo $row['question'] ?></h5>     
            </div>


            <input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">	
						<input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">

            <?php
							if($row['type'] == 'radio_btn'):
							foreach(json_decode($row['form_option']) as $k => $v):
						?>

            <div>
		          <input type="radio" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>]" value="<?php echo $k ?>" checked="">
		          <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
		        </div>
						<?php endforeach; ?>

            <?php elseif($row['type'] == 'check_box'): 
						  foreach(json_decode($row['form_option']) as $k => $v):
						?>
							<div>
		            <input type="checkbox" id="option_<?php echo $k ?>" name="answer[<?php echo $row['id'] ?>][]" value="<?php echo $k ?>" >
		            <label for="option_<?php echo $k ?>"><?php echo $v ?></label>
		          </div>
						<?php endforeach; ?>

            <?php else: ?>
							<div class="form-group">
								<textarea name="answer[<?php echo $row['id'] ?>]" id="" cols="30" rows="4" class="form-control" placeholder="Write Something Here..."></textarea>
							</div>
						<?php endif; ?>

          </div>

          <?php endwhile; ?>

          <div class="text-center p-5">
            <button type="submit" name="submit" class="send-Answer-Btn btn btn-primary w-25" id="btnSendAnswer" value="SendAnswer">Send Answers</button>
          </div>
        </form>

      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>


</body>

</html>

<?php
}
else {
  header("Location: ../../html/Error.html");
  exit();
}
?>