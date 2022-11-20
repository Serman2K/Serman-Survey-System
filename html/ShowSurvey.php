<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "../php/db_conn.php";
?>

<?php 
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
    <title>Survey</title>
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
                <li class="nav-item">
                  <a href="Index.php" id="modalBtn" class="btn btn-primary m-2">Back to Menu</a>
                </li>

              </ul>
      
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Survey Report</span>
                <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                  <span data-feather="plus-circle"></span>
                </a>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a href="Results.php?sid=<?php echo $id ?>" id="reportBtn" class="btn btn-primary m-2 showBtn">Show</a>
                </li>
              </ul>
              <p>Start: <b><?php echo date("G:i, M d, Y",strtotime($start_date)) ?></b></p>
			        <p>End: <b><?php echo date("G:i, M d, Y",strtotime($end_date)) ?></b></p>
            </div>
          </nav>
      
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2"><?php echo $stitle ?></h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                  <a href="#" id="showBtn" class="btn btn-primary my-2">Share</a>
                </div>
              </div>
            </div>
            <p class="lead text-muted empty-message"><?php echo $description; ?></p>

            <div id="ShareModal" class="modal">
              <div class="modal-content text-center">
                <h3 class="linkH3">Link to your survey:</h3><br>
                <p>localhost/3S/Serman-Survey-System/sb/<?php echo $Folder ?>/Survey.php</p>
              </div>
            </div>
      
            <section class="py-5 container">
                <?php 
					      $question = $conn->query("SELECT * FROM questions where survey_id = $id");
					      while($row=$question->fetch_assoc()):	
					      ?>

                <div>

                <div>
                  <div style="display: inline-block;">
                  <h5 class="pt-4"><?php echo $row['question'] ?></h5>
                  </div>
                    <div style="display: inline-block;" class="float-right">
                      <a class="px-3" href="../php/questionDeleteSeq.php?qid=<?php echo $row['id'] ?>&sid=<?php echo $_GET['id'] ?>"><img src="../pictures/delete_btn.png" alt="Remove" width="21" height="25"></a>
                    </div>
                </div>

                  <div>
                    <input type="hidden" name="qid[]" value="<?php echo $row['id'] ?>">

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
                </div>

                <?php endwhile; ?>

                <div class="py-5 text-center">
                    <a href="NewQue.php?sid=<?php echo $_GET['id']?>" id="addQueBtn" class="btn btn-primary my-2">Add Question</a>
                </div>
            </section>

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