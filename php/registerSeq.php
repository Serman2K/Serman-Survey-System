<?php
$sname= "localhost";
$unmae= "root";
$password = "";
$db_name = "serman_survey_system";
$con = mysqli_connect($sname, $unmae, $password, $db_name);

if (mysqli_connect_error()) {
    exit('Error connecting to the database' . mysqli_connect_error());
}

if (!isset($_POST['user_name'], $_POST['password'], $_POST['emailAddress'])) {
    exit('Empty Field(s)');
}

if (empty($_POST['user_name'] || empty($_POST['password']) || empty($_POST['emailAddress']))) {
    exit('Values Empty');
}

if ($stmt = $con->prepare('SELECT id, password FROM users WHERE user_name = ?')) {
    $stmt->bind_param('s', $_POST['user_name']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows>0) {
        echo 'Username Already Exists. Try Again';
    }
    else {
        if ($stmt = $con->prepare('INSERT INTO users (user_name, password, email) VALUES (?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['user_name'], $password, $_POST['emailAddress']);
            $stmt->execute();
            echo 'Succesfully Registered';
        }
        else {
            echo 'Error Occurred';
        }
    }
    $stmt->close();
}
else {
    echo 'Error Occured';
}
$con->close();
?>