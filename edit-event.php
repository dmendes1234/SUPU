<?php
session_start();
include('includes/dbconnection.php');
error_reporting(0);

  if (isset($_POST['submit'])) {
    $event_id = $_GET['editid'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $image = $_POST['image'];
    $date = $_POST['date'];

    $query = mysqli_query($con, "update events set Title='$title',Location='$location',Image='$image',Date='$date' where ID='$event_id'");
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
        <div class="form-group">
          <p>Title</p>
          <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['Title']; ?>" required="true">
        </div>
        <div class="form-group">
          <p>Location</p>
          <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['Location']; ?>" required="true">
        </div>
        <div class="form-group">
          <p>Image</p>
          <input type="text" class="form-control" id="image" name="image" value="<?php echo $row['Image']; ?>" required="true">
        </div>
        <div class="form-group">
          <p>Date</p>
          <input type="datetime-local" class="form-control" id="date" name="date" value="<?php echo $row['Date']; ?>" required="true">
        </div>
      
      <button type="submit" name="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </body>

  </html>