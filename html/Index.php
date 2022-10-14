<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!doctype html>

<?php
	function createDirectory() {
		$add = generateRandomString();
		mkdir("sb/".$add);
	}
?>
<?php
function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Navigation</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/modal.css" rel="stylesheet">
  </head>

  <body>
    <header>
        <nav class="navbar navbar-expand navbar-dark fixed-top" style="background-color: #b389cb;">
            <div class="container-fluid">
                <a class="navbar-brand" href="Index.php">Home</a>
                <div>
                    <form class="navbar-nav">
                      <span class="navbar-text me-5 text-white">Hello, <?php echo $_SESSION['user_name']; ?></span>
                      <button type="button" class="btn btn-secondary mr-auto" onclick="location.href='../php/logoutSeq.php'">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div>
        <h1><img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200"></h1>
        <h2>My Surveys:</h2>
        <div class="Survey-list">
          <p class="lead text-muted empty-message">You don't have any surveys :(</p>
        </div>
        <p>
          <a href="#" id="modalBtn" class="btn btn-primary my-2">Create New Survey</a>
        </p>
      </div>
    </div>
  </section>

  <div id="modal" class="modal">

    <?php
    if (!isset($_POST['submit'])) {
      ?>

    <form action = "" method = "post">
      <div class="modal-dialog-centered">
        <div class="modal-content w-25">
          <h2>New Survey</h2>
          <p class="lead text-muted">How would you like to name your survey?</p>
          <input type="text" class="form-control mb-4 Survey-Name" id="surveyName">

          <p class="lead text-muted">Type description here</p>
          <textarea name="description" class="form-control mb-4 Survey-Description" id="surveyDescription"></textarea>

          <p class="lead text-muted">Start</p>
          <input type="datetime-local" class="form-control mb-4 Survey-Start" id="surveyStart">

          <p class="lead text-muted">End</p>
          <input type="datetime-local" class="form-control mb-4 Survey-End" id="surveyEnd">

          <p class="lead text-muted">You can change the dates later</p>

          <div class="modal-footer">
            <button type="submit" class="add-Survey-Btn btn btn-primary w-25" id="btnCreateSurvey">Create</button>
            <button class="btn btn-secondary w-25" id="closeBtn" data-dismiss="Modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>

    <?php
    }
    else {
      createDirectory();
    }
    ?>

  </div>

</main>

<script src="../js/ModalSurveyCreator.js"></script>
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