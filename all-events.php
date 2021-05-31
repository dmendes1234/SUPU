<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
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

    <div style="margin-top:30px; margin-left: 80px; margin-right:80px;">
        <h4>Svi događaji:</h4>
        <hr>
    </div>

    <?php
    $ret = mysqli_query($con, "select * from events where Recommended='1'");
    while ($row = mysqli_fetch_array($ret)) {
    ?>

    <div class="event_card">
        <img src="<?php echo $row['Image']; ?>" alt="error">
        <h6 class="event_title"><?php echo $row['Title']; ?></h6>
        <p class="event_date_location">
            <?php echo $row['Location']; ?>
            <br>
            <span><?php echo $row['Date']; ?></span>
        </p>
        <?php if ($_SESSION['user_type'] != 'admin') { ?>
        <a href="buy_tickets.php?eventid=<?php echo $row['ID']; ?>" class="buy-ticket_link">KUPI ULAZNICE</a>
        <?php } else { ?>
        <a href="edit-event.php?editid=<?php echo $row['ID']; ?>" class="edit-ticket_link">UREDI</a>
        <a href="delete-event.php?editid=<?php echo $row['ID']; ?>" class="delete-ticket_link">OBRIŠI</a>
        <?php } ?>
    </div>
    <?php
    } 
    ?>

</body>

</html>