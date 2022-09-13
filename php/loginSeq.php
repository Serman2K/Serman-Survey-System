<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['emailAddress']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $emailAddress = validate($_POST['emailAddress']);
    $pass = validate($_POST['password']);

    if (empty($emailAddress)) {
        header("Location: ../html/Login.php?error=Email Address is required");
        exit();
    }
    else if(empty($pass)){
        header("Location: ../html/Login.php?error=Password is required");
        exit();
    }
    
    else{

        $sql = "SELECT * FROM users WHERE email='$emailAddress'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $emailAddress && password_verify($pass, $row['password'])) {
                echo "Logged in!";

                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                header("Location: ../html/Index.php");
                exit();
            }

            else{
                header("Location: ../html/Login.php?error=Incorect Email Address or Password");
                password_verify($pass, $row['password']);
                exit();
            }
        }

        else{
            header("Location: ../html/Login.php?error=Incorect Email Address or Password");
            exit();
        }
    }
}
else{
    header("Location: ../html/Login.php");
    exit();
}