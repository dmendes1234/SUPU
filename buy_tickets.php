<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$event_id = $_GET['eventid'];
$user_id = $_SESSION['user_id'];

if ($user_id <= 0) {
    $_SESSION['msg'] = 'Prijavi se kako bi mogao kupovati ulaznice';
    header('location:login.php');
}

$get_users = mysqli_query($con, "SELECT * FROM users WHERE ID = '$user_id'");
$row_user = mysqli_fetch_array($get_users);

$get_events = mysqli_query($con, "SELECT * FROM events WHERE ID = '$event_id'");
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
    <link rel="stylesheet" href="css/buy_tickets.css">
    <title>SUPU</title>
</head>

<body>
    <?php
    include("includes/header.html");
    include("includes/navBar.php");
    ?>

    <div style="margin-top:50px; margin-bottom:50px; margin-left: 100px; margin-right:80px;">
        <h3>Kupnja ulaznica</h3>
        <hr>
    </div>

    <div id="buy-ticket_container">
        <button class="tablink" id="pick_tickets_tab"
            onclick="openPage('pick_tickets', this, 'rgb(158, 46, 93)')">Odabir
            ulaznica</button>
        <button class="tablink" id="delivery_info_tab"
            onclick="openPage('delivery_info', this, 'rgb(158, 46, 93)')">Podaci za dostavu</button>
        <button class="tablink" id="confirm_order_tab"
            onclick="openPage('confirm_order', this, 'rgb(158, 46, 93)')">Potvrda narudžbe</button>

        <div id="pick_tickets" class="tabcontent" style="margin-top: 30px;">
            <div class="buy-ticket_info" style="margin-bottom: 30px;">
                <h2 style="margin-bottom: 20px;"><?php echo $row_event['Title']; ?></h2>
                <span style="font-weight: bold;"><?php echo $row_event['Performer']; ?>, </span>
                <span style="font-weight: bold;"><?php echo $row_event['Location']; ?>, </span>
                <span style="font-weight: bold;"><?php echo $row_event['Date']; ?></span>
                <br>
                <p style="margin-top: 15px;">
                    <span style="color: gray">ORGANIZATOR: </span> <span style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['Organizer']; ?></span>
                    <span style="color: gray;">SLOBODNA MJESTA: </span> <span
                        style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['AvailableSeats']; ?></span>
                    <span style="color: gray;">CIJENA ULAZNICA ZA ODRASLE: </span> <span
                        style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['TicketPriceAdult']; ?> kn</span>
                    <span style="color: gray;">CIJENA ULAZNICA ZA DJECU: </span> <span
                        style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['TicketPriceChild']; ?> kn</span>
                </p>
            </div>
            <hr>
            <h3 style="margin-top:20px; margin-bottom: 20px;">Odaberite količinu ulaznica</h3>
            <form method="post" action="" name="buy">
                <div class="form-group">
                    <label for="noadult">Odrasli</label>
                    <input type="number" class="form-control" id="noadult" name="noadult"
                        placeholder="Broj ulaznica za odrasle" value="" required="true">
                </div>
                <div class="form-group">
                    <label for="nochildren">Djeca</label>
                    <input type="number" class="form-control" id="nochildren" name="nochildren"
                        placeholder="Broj ulaznica za djecu" value="">
                </div>
                <div class="form-group">
                    <label for="promo_code_buy">Promo kod</label>
                    <input type="text" class="form-control" id="promo_code_buy" name="promo_code"
                        placeholder="Ostvarite popust unosom promo koda (opcionalno)">
                </div>
                <a class="tablink_next"
                    onclick="openPage('delivery_info', 'delivery_info_tab' , 'rgb(158, 46, 93)')">Sljedeće</a>
        </div>

        <div id="delivery_info" class="tabcontent">
            <div class="buy-ticket_info" style="margin-bottom: 30px;">
                <h2 style="margin-bottom: 20px;"><?php echo $row_event['Title']; ?></h2>
                <span style="font-weight: bold;"><?php echo $row_event['Performer']; ?>, </span>
                <span style="font-weight: bold;"><?php echo $row_event['Location']; ?>, </span>
                <span style="font-weight: bold;"><?php echo $row_event['Date']; ?></span>
                <br>
                <p style="margin-top: 15px;">
                    <span style="color: gray">ORGANIZATOR: </span> <span style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['Organizer']; ?></span>
                    <span style="color: gray;">SLOBODNA MJESTA: </span> <span
                        style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['AvailableSeats']; ?></span>
                    <span style="color: gray;">CIJENA ULAZNICA ZA ODRASLE: </span> <span
                        style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['TicketPriceAdult']; ?> kn</span>
                    <span style="color: gray;">CIJENA ULAZNICA ZA DJECU: </span> <span
                        style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['TicketPriceChild']; ?> kn</span>
                </p>
            </div>
            <hr>
            <h3 style="margin-top:20px; margin-bottom: 20px;">Unesite podatke za dostavu</h3>
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

            <a class="tablink_back"
                onclick="openPage('pick_tickets', 'pick_tickets_tab' , 'rgb(158, 46, 93)')">Nazad</a>
            <a class="tablink_next"
                onclick="openPage('confirm_order', 'confirm_order_tab' , 'rgb(158, 46, 93)')">Sljedeće</a>
        </div>

        <div id="confirm_order" class="tabcontent">
            <a class="tablink_back"
                onclick="openPage('delivery_info', 'delivery_info_tab' , 'rgb(158, 46, 93)')">Nazad</a>
            <a class="tablink_next"
                onclick="openPage('confirm_order', 'confirm_order_tab' , 'rgb(158, 46, 93)')">Potvrdi narudžbu</a>
        </div>
        </form>

    </div>

    <script>
    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        document.getElementById(elmnt).style.backgroundColor = color;
        elmnt.style.backgroundColor = color;
    }

    document.getElementById("pick_tickets_tab").click();
    document.getElementById("pick_tickets_tab").style.backgroundColor = 'rgb(158, 46, 93)';
    </script>

    <?php
        $ret = mysqli_query($con, "SELECT * FROM events WHERE ID = '$event_id'");
        $row = mysqli_fetch_array($ret)
        ?>
    <input type="hidden" name="cprice" value="<?php echo $row['TicketPriceChild']; ?>">
    <input type="hidden" name="aprice" value="<?php echo $row['TicketPriceAdult']; ?>">
    </div>
</body>

</html>