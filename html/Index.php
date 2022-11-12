<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "../php/db_conn.php";
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

            <colgroup>
              <col width="2%">
              <col width="20%">
              <col width="20%">
              <col width="20%">
              <col width="20%">
              <col width="18%">
            </colgroup>

            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start</th>
                <th>End</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
            <?php
					  $i = 1;
            $user_id = $_SESSION['id'];
					  $qry = $conn->query("SELECT * FROM surveys WHERE user_id=$user_id");
					  while($row= $qry->fetch_assoc()):
					  ?>

              <tr>
                <th class="text-center"><?php echo $i++ ?></th>
                <td class="survey-name"><?php echo $row['title'] ?></td>
                <td class="truncate"><?php echo $row['description'] ?></td>
                <td><?php echo date("G:i, M d, Y",strtotime($row['start_date'])) ?></td>
                <td><?php echo date("G:i, M d, Y",strtotime($row['end_date'])) ?></td>
                <td class="survey-func-btn">
                  <a class="px-3" href="./EditSurvey.php?id=<?php echo $row['id'] ?>"><img src="../pictures/edit_btn.png" alt="Edit" width="30" height="30"></a>
                  <a class="px-3" href="./ShowSurvey.php?id=<?php echo $row['id'] ?>"><img src="../pictures/show_btn.png" alt="Show" width="30" height="30"></a>
                  <a class="px-3" href="./DeleteSurvey.php?id=<?php echo $row['id'] ?>"><img src="../pictures/delete_btn.png" alt="Remove" width="30" height="30"></a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>

            </table>
        </div>
        <p>
        <a href="./NewSurvey.php" id="createSurvBtn" class="btn btn-primary my-2">Create New Survey</a>
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