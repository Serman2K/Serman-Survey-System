<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>3S: Sign in</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link href="../css/login.css" rel="stylesheet">
  </head>

<body class="text-center">
    
<main class="form-signin">
  <div class="text-center">
    <img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200">
  <form action="../php/loginSeq.php" method="post">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <?php if (isset($_GET['error'])) { ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <div class="form-floating">
      <input type="text" class="form-control" name="emailAddress" id="emailAddress" placeholder="name@example.com">
      <label>Email address</label>
    </div>

    <div class="form-floating">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
      <label>Password</label>
    </div>
<!--
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    -->
    <button class="w-100 btn btn-lg btn-purple" type="submit">Login</button>
  </form>
  <a href="Register.php">Create a new account</a>
  <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
</div>
</main>
    
</body>
</html>