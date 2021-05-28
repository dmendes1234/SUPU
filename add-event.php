<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_POST['add_event'])) {
    $title = $_POST['title'];
    $performer = $_POST['performer'];
    $organizer = $_POST['organizer'];
    $location = $_POST['location'];
    $image = $_POST['image'];
    $date = $_POST['date'];
    $cprice = $_POST['cprice'];
    $aprice = $_POST['aprice'];
    $seats = $_POST['seats'];
    $promo_code = $_POST['promo_code'];
    $promo_discount = $_POST['promo_discount'];

    $query = mysqli_query($con, 'insert into events (Title, Performer, Organizer, Location, Image, Date, TicketPriceChild, TicketPriceAdult, AvailableSeats, PromoCode, PromoDiscount) values ("' . $title . '", "' . $performer . '", "' . $organizer . '", "' . $location . '", "' . $image . '", "' . $date . '", "' . $cprice . '", "' . $aprice . '", "' . $seats . '", "' . $promo_code . '", "' . $promo_discount . '")');
    $_SESSION['msg'] = "Događaj uspješno kreiran.";
    header('location:index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Uredi događaj</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/navBar.css">
  <link rel="stylesheet" href="css/index.css">
</head>

<body>


  <?php include('includes/header.html'); ?>
  <?php include('includes/navBar.php'); ?>

  <div class="container" style="margin-top: 30px;">
    <h2>Dodaj novi događaj</h2>
    <form method="post" action="" name="">
      <h4>Informacije o događaju</h4>
      <div class="form-group">
        <label for="title">Naziv događaja</label>
        <input type="text" class="form-control" id="title" placeholder="Unesi naziv događaja" name="title" required>
      </div>
      <div class="form-group">
        <label for="performer">Izvođač</label>
        <input type="text" class="form-control" id="performer" placeholder="Unesi naziv izvođača" name="performer" required>
      </div>
      <div class="form-group">
        <label for="organizer">Organizator</label>
        <input type="text" class="form-control" id="organizer" placeholder="Unesi naziv organizatora" name="organizer" required>
      </div>
      <div class="form-group">
        <label for="location">Mjesto izvođenja događaja</label>
        <input class="form-control" id="location" placeholder="Unesi lokaciju događaja" name="location" required>
      </div>
      <div class="form-group">
        <label for="image">Fotografija događaja</label>
        <input type="text" class="form-control" id="image" placeholder="Unesi url fotografije" name="image" required>
      </div>
      <div class="form-group">
        <label for="date">Datum i vrijeme događanja</label>
        <input type="datetime-local" class="form-control" id="date" placeholder="Unesi datum događaja" name="date" required>
      </div>
      <div class="form-group">
        <label for="cprice">Cijena ulaznice za djecu</label>
        <input type="number" class="form-control" id="cprice" placeholder="Unesi cijenu ulaznice za djecu" name="cprice" required>
      </div>
      <div class="form-group">
        <label for="aprice">Cijena ulaznice za odrasle</label>
        <input type="number" class="form-control" id="aprice" placeholder="Unesi cijenu ulaznice za odrasle" name="aprice" required>
      </div>
      <div class="form-group">
        <label for="seats">Slobodna mjesta</label>
        <input type="number" class="form-control" id="seats" placeholder="Unesi broj slobodnih mjesta" name="seats" required>
      </div>
      <div class="form-group">
        <label for="promo_code">Promo code</label>
        <input type="text" class="form-control" id="promo_code" placeholder="Unesi kod za popust ukoliko postoji" name="promo_code">
      </div>
      <div class="form-group">
        <label for="promo_discount">Promo popust</label>
        <input type="number" class="form-control" id="promo_discount" placeholder="Unesi popust (%) koji se ostvaruje unosom promo koda" name="promo_discount">
      </div>

      <button type="submit" name="add_event" class="btn btn-primary">Add</button>
    </form>
  </div>
</body>

</html>

