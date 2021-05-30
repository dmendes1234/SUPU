<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$event_category = $_GET['event_category'];
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
    <link rel="stylesheet" href="css/card.css">
    <title>SUPU</title>
</head>

<body>
    <?php
    include("includes/header.html");
    include("includes/navBar.php");
    ?>

    <div style="margin-top:20px; margin-left: 50px; margin-right:40px; padding: 25px; background-color:white;">
        <a href="all-events.php" style="float:right; font-size:20px">Svi događaji -></a>
        <h4><?php echo $event_category ?></h4>
    </div>

    <?php
    $ret2 = mysqli_query($con, "select * from users where ID='$user_id'");
    $row2 = mysqli_fetch_array($ret2);

    if($event_category == 'Glazba'){
        $ret = mysqli_query($con, "select * from events where Category='Glazba'");
    }
    else if ($event_category == 'Film'){
        $ret = mysqli_query($con, "select * from events where Category='Film'");
    }
    else if ($event_category == 'Kazalište'){
        $ret = mysqli_query($con, "select * from events where Category='Kazalište'");
    }
    else if ($event_category == 'Sport'){
        $ret = mysqli_query($con, "select * from events where Category='Sport'");
    }
    else if ($event_category == 'Turizam'){
        $ret = mysqli_query($con, "select * from events where Category='Turizam'");
    }
    while ($row = mysqli_fetch_array($ret)) {
    ?>
        <a href="event_details.php?eventid=<?php echo $row['ID']; ?>">
            <div class="card">
                <img src="<?php echo $row['Image']; ?>" alt="Error" style="width:100%">
                <h1><?php echo $row['Title']; ?></h1>
                <p class="event_title"><?php echo $row['Date']; ?></p>
                <p><?php echo $row['Location']; ?></p>
                <?php if ($row2['UserType'] == 'admin') { ?>
                    <hr>
                    <p><a href="edit-event.php?editid=<?php echo $row['ID']; ?>">Uredi</a></p>
                    <hr>
                    <p><a href="delete-event.php?editid=<?php echo $row['ID']; ?>">Obriši</a></p>
                <?php } ?>
            </div>
        </a>
    <?php
    }
    ?>

</body>

</html>