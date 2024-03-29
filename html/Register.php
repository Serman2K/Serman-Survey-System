<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>3S: Sign up</title>
  <link rel="icon" type="favicon" href="../pictures/favicon.ico">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

  <link href="../css/register.css" rel="stylesheet">
</head>

  <body class="text-center">

    <main class="form-signin">
      <div class="text-center">
        <img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200">

        <form class="form" action="../php/registerSeq.php" method="post">

          <h1 class="h3 mb-3 fw-normal">Sign up for free</h1>

          <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
          <?php } ?>

          <div class="form-floating">
            <input type="text" class="form-control" name="user_name" id="userName" placeholder="Username" required>
            <label>username</label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" name="emailAddress" id="emailAddress" placeholder="name@example.com" required>
            <label for="emailAddress">email address</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" name="password" id="password-confirm" placeholder="Password" required>
            <label for="password">password</label>
          </div>
          <button class="w-100 btn btn-lg btn-purple" type="submit" name="submit" value="Register">sign up</button>
        </form>

        <p class="link"><a href="Login.php">Back to Login</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2022</p>

      </div>
    </main>

  </body>
</html>