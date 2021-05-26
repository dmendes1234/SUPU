<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);

if (isset($_POST['submit'])) {
  $event_id = $_GET['editid'];
  $title = $_POST['title'];
  $performer = $_POST['performer'];
  $organizer = $_POST['organizer'];
  $location = $_POST['location'];
  $image = $_POST['image'];
  $date = $_POST['date'];
  $cprice = $_POST['cprice'];
  $aprice = $_POST['aprice'];
  $seats = $_POST['seats'];

  $query = mysqli_query($con, "update events set Title='$title', Performer='$performer', Organizer='$organizer', Location='$location', Image='$image', Date='$date', TicketPriceChild='$cprice', TicketPriceAdult='$aprice', AvailableSeats='$seats' where ID='$event_id'");
  if ($query) {
    echo '<script>
      alert("Podaci uspješno izmijenjeni");
 </script>';
  } else {

    echo '<script>alert("Something Went Wrong. Please try again.")</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Uredi događaj</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/navBar.css">
</head>

<body>


  <?php include('includes/header.html'); ?>
  <?php include('includes/navBar.php'); ?>

  <div class="container" style="margin-top: 30px;">
    <h2>Uredi informacije o događaju</h2>
    <form method="post" action="" name="">

      <?php
      $event_id = $_GET['editid'];
      $ret = mysqli_query($con, "select * from events where ID='$event_id'");
      $cnt = 1;
      $row = mysqli_fetch_array($ret);

      ?>
      <h4>Informacije o događaju</h4>
      <div class="form-group">
        <label for="title">Naziv događaja</label>
        <input type="text" class="form-control" id="title" placeholder="Unesi naziv događaja" name="title" value="<?php echo $row['Title'] ?>">
      </div>
      <div class="form-group">
        <label for="performer">Izvođač</label>
        <input type="text" class="form-control" id="performer" placeholder="Unesi naziv izvođača" name="performer" value="<?php echo $row['Performer'] ?>">
      </div>
      <div class="form-group">
        <label for="organizer">Organizator</label>
        <input type="text" class="form-control" id="organizer" placeholder="Unesi naziv organizatora" name="organizer" value="<?php echo $row['Organizer'] ?>">
      </div>
      <div class="form-group">
        <label for="location">Mjesto izvođenja događaja</label>
        <input class="form-control" id="location" placeholder="Unesi lokaciju događaja" name="location" value="<?php echo $row['Location'] ?>">
      </div>
      <div class="form-group">
        <label for="image">Fotografija događaja</label>
        <input type="text" class="form-control" id="image" placeholder="Unesi url fotografije" name="image" value="<?php echo $row['Image'] ?>">
      </div>
      <div class="form-group">
        <label for="date">Datum i vrijeme događanja</label>
        <input type="datetime-local" class="form-control" id="date" placeholder="Unesi datum događaja" name="date" value="<?php echo $row['Date'] ?>">
      </div>
      <div class="form-group">
        <label for="cprice">Cijena ulaznice za djecu</label>
        <input type="number" class="form-control" id="cprice" placeholder="Unesi cijenu ulaznice za djecu" name="cprice" value="<?php echo $row['TicketPriceChild'] ?>">
      </div>
      <div class="form-group">
        <label for="aprice">Cijena ulaznice za odrasle</label>
        <input type="number" class="form-control" id="aprice" placeholder="Unesi cijenu ulaznice za odrasle" name="aprice" value="<?php echo $row['TicketPriceAdult'] ?>">
      </div>
      <div class="form-group">
        <label for="seats">Slobodna mjesta</label>
        <input type="number" class="form-control" id="seats" placeholder="Unesi broj slobodnih mjesta" name="seats" value="<?php echo $row['AvailableSeats'] ?>">
      </div>

      <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</body>

</html>