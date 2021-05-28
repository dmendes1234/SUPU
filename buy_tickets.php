<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$event_id = $_GET['eventid'];
$user_id = $_SESSION['user_id'];

$get_users = mysqli_query($con, "SELECT * FROM users WHERE ID = '$user_id'");
$row_user = mysqli_fetch_array($get_users);

$get_events = mysqli_query($con, "SELECT * FROM events");
$row_event = mysqli_fetch_array($get_events);

if (isset($_POST['buy'])) {
    $event_title = $row_event['Title'];
    $logged_user = $row_user['UserName'];
    $noadult = $_POST['noadult'];
    $nochildren = $_POST['nochildren'];
    $updated_seats = $row_event['AvailableSeats'] - ($noadult + $nochildren);
    $cprice = $_POST['cprice'];
    $aprice = $_POST['aprice'];
    $buyer_name = $_POST['buyer_name'];
    $buyer_surname = $_POST['buyer_surname'];
    $buyer_address = $_POST['buyer_address'];
    $ticketid = mt_rand(100000000, 999999999);
    $promo_code = $_POST['promo_code'];

    if ($row_event['PromoCode'] == $promo_code){
        $promo_discount = $row_event['PromoDiscount'];
    }
    else{
        $promo_discount = 0;
    }

    if($updated_seats >= 0){
    $query = mysqli_query($con, "INSERT INTO tickets (TicketID, NoChildren, NoAdult, ChildUnitPrice, AdultUnitPrice, User, BuyerName, BuyerSurname, BuyerAddress, EventTitle, PromoDiscount) VALUE ('$ticketid', '$nochildren', '$noadult', '$cprice', '$aprice', '$logged_user', '$buyer_name', '$buyer_surname', '$buyer_address', '$event_title', '$promo_discount')");
    $update_availableSeats = mysqli_query($con, "UPDATE events SET AvailableSeats = '$updated_seats' WHERE ID = '$event_id'");
    } else { '<script>alert("Broj ulaznica koje želite kupiti premašuje broj slobodnih mjesta!")</script>'; }

    if ($query){
    echo '<script>alert("Ulaznice će vam biti dostavljene na adresu. Možete ih pregledati na izborniku Moje ulaznice")</script>';
    } else {
    echo '<script>alert("Broj ulaznica koje želite kupiti premašuje broj slobodnih mjesta!")</script>';
} }
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

    <div style="margin: 50px;">
        <a href="event_details.php?eventid=<?php echo $event_id ?>">Natrag</a>
        <h1>Buy tickets for event with id = <?php echo $event_id ?></h1>
    </div>


    <div class="container" style="margin-top: 30px;">
        <h2>Naziv događaja</h2>
        <form method="post" action="" name="buy">
            <div class="form-group">
                <label for="noadult">Odrasli</label>
                <input type="number" class="form-control" id="noadult" name="noadult"
                    placeholder="Broj ulaznica za odrasle" value="" required="true">
            </div>
            <div class="form-group">
                <label for="children">Djeca</label>
                <input type="number" class="form-control" id="nochildren" name="nochildren"
                    placeholder="Broj ulaznica za djecu" value="">
            </div>
            <div class="form-group">
                <label for="promo_code">Promo code</label>
                <input type="text" class="form-control" name="promo_code" placeholder="Promo code (optional)" value="">
            </div>
            <hr>
            <h5>Podaci za dostavu</h5>
            <div class="form-group">
                <label for="buyer_name">Ime</label>
                <input type="text" class="form-control" id="buyer_name" name="buyer_name"
                    placeholder="Unesite ime kupca" value="" required="true">
            </div>
            <div class="form-group">
                <label for="buyer_surname">Prezime</label>
                <input type="text" class="form-control" id="buyer_surname" name="buyer_surname"
                    placeholder="Unesite prezime kupca" value="" required="true">
            </div>
            <div class="form-group">
                <label for="buyer_address">Adresa</label>
                <input type="text" class="form-control" id="buyer_address" name="buyer_address"
                    placeholder="Unesite adresu za dostavu ulaznica" value="" required="true">
            </div>
            <?php
        $ret = mysqli_query($con, "SELECT * FROM events");
        $row = mysqli_fetch_array($ret)
        ?>
            <input type="hidden" name="cprice" value="<?php echo $row['TicketPriceChild']; ?>">
            <input type="hidden" name="aprice" value="<?php echo $row['TicketPriceAdult']; ?>">

            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" name="buy">Kupi</button>
        </form>
    </div>
</body>

</html>