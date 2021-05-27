<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_SESSION['errorMessage'])){
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['errorMessage'] . "');
          </script>";
    
    unset($_SESSION['errorMessage']);
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $pwd = md5($_POST['password']);

    /*
    $ret = mysqli_query($con, 'SELECT * FROM users');

    while ($row = mysqli_fetch_array($ret)){
            if ($username == $row['UserName']){
                $_SESSION['errorMessage'] = "Korisničko ime već postoji!";
                break;
            }
        }

    if ($password != $password2){
        $_SESSION['errorMessage'] = "Lozinke nisu identične";
        header('location:register.php');
    }
    else if ($username != $row['UserName']){
        $query = mysqli_query($con, 'insert into users (Name, Surname, UserName, Password) values ("' . $name . '", "' . $surname . '", "' . $username . '", "' . $pwd . '")');

        if($query) {
            $_SESSION['msg'] = "Registracija uspješna!";
            header('location:login.php');
        }
    }
*/} 
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
    <link rel="stylesheet" href="css/register.css">

    <title>SUPU</title>
</head>

<body>
    <?php
        include("includes/header.html");
        include("includes/navBar.php");
    ?>

    <form id="register_form" action="#" method="post" name="register">
        <div id="register_container">
            <h1 id="register_title">Registriraj se</h1>

            <label for="name"><b>Ime</b></label>
            <input type="text" placeholder="Unesi ime" name="name" required>

            <label for="surname"><b>Prezime</b></label>
            <input type="text" placeholder="Unesi prezime" name="surname" required>

            <label for="username"><b>Korisničko ime</b></label>
            <input id="username" type="text" placeholder="Unesi korisničko ime" name="username" required>
            <p id="user_exists" hidden>Korisnik već postoji!</p>

            <label for="password"><b>Lozinka</b></label>
            <input type="password" placeholder="Unesi lozinku" name="password" required>

            <label for="password2"><b>Potvrda lozinke</b></label>
            <input type="password" placeholder="Ponovi unos lozinke" name="password2" required>

            <button type="submit" name="register">Register</button>
        </div>
    </form>
</body>

</html>