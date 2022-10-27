<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Navigation</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="../css/main.css" rel="stylesheet">
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

  <?php if (isset($_GET['error'])) { ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
  <?php } ?>

  <section class="py-5 text-center container">
    <div class="py-5">
    <div>
        <h1><img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200"></h1>
    
        <h2>My Surveys:</h2>
        <div class="Survey-list">
            <table class="table">
                <tr>
                    <th>Survey Name</th>
                    <th>Start</th>
                    <th>End</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
        <p>
        <a href="./NewSurvey.php" id="modalBtn" class="btn btn-primary my-2">Create New Survey</a>
        </p>
      </div>
    </div>
  </section>

</main>

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