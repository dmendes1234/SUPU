<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_SESSION['msg'])){
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['msg'] . "');
          </script>";
    unset($_SESSION['msg']);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "select ID from users where UserName='$username' && Password='$password'");
    $ret = mysqli_fetch_array($query);
    if ($ret > 0) {
        $_SESSION['user_id'] = $ret['ID'];
        header('location:index.php');
    } else {
        echo '<script>alert("Pogrešno korisničko ime ili lozinka!")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/navBar.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Prijava</title>
</head>

<body>
    <?php
    include("includes/header.html");
    include("includes/navBar.php");
    ?>

    <form id="login_form" action="#" method="post" name="login">
        <div id="login_container">
            <h1 id="login_title">Prijavi se</h1>

            <label for="uname"><b>Korisničko ime</b></label>
            <input type="text" placeholder="Enter username" name="username" required>

            <label for="pwd"><b>Lozinka</b></label>
            <input type="password" placeholder="Enter password" name="password" required>

            <button type="submit" name="login">Login</button>
        </div>
    </form>
</body>

</html>