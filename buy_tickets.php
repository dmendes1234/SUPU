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

$get_events = mysqli_query($con, "SELECT * FROM events WHERE ID = '$event_id'");
$row_event = mysqli_fetch_array($get_events);

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
        <button class="tablink" id="pick_tickets_tab">Odabir ulaznica</button>
        <button class="tablink" id="delivery_info_tab">Podaci za dostavu</button>
        <button class="tablink" id="confirm_order_tab">Potvrda narudžbe</button>

        <div id="pick_tickets" class="tabcontent" style="margin-top: 30px;">
            <div class="buy-ticket_info" style="margin-bottom: 30px;">
                <h2 style="margin-bottom: 20px;" id="pick_tickets_title"><?php echo $row_event['Title']; ?></h2>
                <span style="font-weight: bold;"><?php echo $row_event['Performer']; ?>, </span>
                <span style="font-weight: bold;"><?php echo $row_event['Location']; ?>, </span>
                <span style="font-weight: bold;"><?php echo $row_event['Date']; ?></span>
                <br>
                <p style="margin-top: 15px;">
                    <span style="color: gray">ORGANIZATOR: </span> <span style="padding-right:20px; font-weight:bold">
                        <?php echo $row_event['Organizer']; ?></span>
                    <span style="color: gray;">SLOBODNA MJESTA: </span> <span id="availableSeats"
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


            <form method="post" name="buy" id="buyTicketForm">
                <div class="form-group">
                    <label for="noadult">Odrasli</label>
                    <input type="number" class="form-control" id="noadult" name="noadult"
                        placeholder="Broj ulaznica za odrasle" required="true">
                </div>
                <div class="form-group">
                    <label for="nochildren">Djeca</label>
                    <input type="number" class="form-control" id="nochildren" name="nochildren"
                        placeholder="Broj ulaznica za djecu">
                </div>
                <div class="form-group">
                    <label for="promo_code_buy">Promo kod</label>
                    <input type="text" class="form-control" id="promo_code_buy" name="promo_code"
                        placeholder="Ostvarite popust unosom promo koda (opcionalno)">
                </div>
                <div id="alertBox">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Upozorenje!</strong> <span id="validationError">Validation error</span> 
                </div>

                <button type="button" class="tablink_next" onclick="validate_pick_tickets()">Sljedeće</button>

                <?php
                $ret = mysqli_query($con, "SELECT * FROM events WHERE ID = '$event_id'");
                $row = mysqli_fetch_array($ret)
                ?>

                <input type="hidden" name="cprice" value="<?php echo $row['TicketPriceChild']; ?>">
                <input type="hidden" name="aprice" value="<?php echo $row['TicketPriceAdult']; ?>">
        </div>

        <!-- Podaci za dostavu -->
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
                    placeholder="Unesite ime kupca">
            </div>
            <div class="form-group">
                <label for="buyer_surname">Prezime</label>
                <input type="text" class="form-control" id="buyer_surname" name="buyer_surname"
                    placeholder="Unesite prezime kupca">
            </div>
            <div class="form-group">
                <label for="buyer_address">Adresa</label>
                <input type="text" class="form-control" id="buyer_address" name="buyer_address"
                    placeholder="Unesite adresu za dostavu ulaznica">
            </div>

            <a class="tablink_back"
                onclick="openPage('pick_tickets', 'pick_tickets_tab' , 'rgb(158, 46, 93)')">Nazad</a>
            <a class="tablink_next"
                onclick="openPage('confirm_order', 'confirm_order_tab' , 'rgb(158, 46, 93)'); ">Sljedeće</a>
        </div>

        <!-- Račun i Potvrda narudžbe -->
        <div id="confirm_order" class="tabcontent">
            <h4>Potvrda narudžbe</h4>
            <div style="margin-top:20px; margin-left: 50px; margin-right:40px; padding: 25px; background-color:white;">
                <h4 id="confirm_order_title" style="color: blue">Naziv događaja</h4>
                <table class="table table-striped" style="text-align: center;">
                    <tr>
                        <th style="text-align: left;">Vrsta ulaznice</th>
                        <th>Broj ulaznica</th>
                        <th>Cijena po ulaznici</th>
                        <th>Ukupno</th>
                    </tr>

                    <tr>
                        <th style="text-align: left;">Za odrasle</th>
                        <td style="padding-left: 10px;"><?php echo $noadult ?></td>
                        <td style="padding-left: 10px">$<?php echo $aup = $aprice ?></td>
                        <td style="padding-left: 10px">$<?php echo $ta = $aup * $noadult; ?></td>
                    </tr>

                    <tr>
                        <th style="text-align: left;">Za djecu</th>
                        <td style="padding-left: 10px"><?php echo $nochild = $nochild ?></td>
                        <td style="padding-left: 10px">$<?php echo $cup = $cprice ?></td>
                        <td style="padding-left: 10px">$<?php echo $tc = $cup * $nochild; ?></td>
                    </tr>

                    <tr>
                        <th style="text-align: center;color: red;font-size: 20px; padding-left:100px" colspan="3">
                            Ukupna cijena
                            ulaznica</th>
                        <td style="padding-left: 10px; color:red">$<?php echo ($ta + $tc); ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: center;color: red;font-size: 20px; padding-left:100px" colspan="3">
                            Cijena s popustom</th>
                        <td style="padding-left: 10px; color:red">
                            $<?php echo (($ta + $tc) - (($promo_discount/100)*($ta + $tc))); ?></td>
                    </tr>
                </table>
            </div>
            <button type="submit">Potvrdi</button>
            </form>
            <a class="tablink_back"
                onclick="openPage('delivery_info', 'delivery_info_tab' , 'rgb(158, 46, 93)')">Nazad</a>
            <a class="tablink_next"
                onclick="openPage('confirm_order', 'confirm_order_tab' , 'rgb(158, 46, 93)')">Potvrdi narudžbu</a>
        </div>
    </div>

    <script>
    function validate_pick_tickets() {
        var noadult = +document.getElementById("noadult").value;
        var nochildren = +document.getElementById("nochildren").value;
        var availableSeats = +document.getElementById("availableSeats").innerHTML;

        var alertBox = document.getElementById("alertBox");
        var alertBoxMsg = document.getElementById("validationError");

        if ((noadult + nochildren) > availableSeats) {
            alertBox.style.display = "block";
            alertBoxMsg.innerHTML = "Količina ulaznica koju ste odabrali premašuje broj slobodnih mjesta";
        } else if (noadult <= 0) {
            alertBox.style.display = "block";
            alertBoxMsg.innerHTML = "Broj ulaznica za odrasle ne smije biti nula";
        } else {
            openPage('delivery_info', 'delivery_info_tab', 'rgb(158, 46, 93)');
        }
    }

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
        document.getElementById(elmnt).style.backgroundColor = 'rgb(158, 46, 93)';

    }

    // display first tab on start
    document.getElementById('pick_tickets').style.display = "block";
    document.getElementById('pick_tickets_tab').style.backgroundColor = 'rgb(158, 46, 93)';

    // make check from inputed values
    var event_title = document.getElementById("pick_tickets_title").innerHTML;
    document.getElementById("confirm_order_title").innerHTML = event_title;
    </script>
    </div>
</body>

</html>