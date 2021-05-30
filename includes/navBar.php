<?php
$user_id = $_SESSION['user_id'];
$ret = mysqli_query($con, "select * from users where ID='$user_id'");
$row = mysqli_fetch_array($ret)
?>

<div class="navigation">
  <a href="index.php">Home</a>
  <a href="all-events.php">Svi događaji</a>
  <a href="view-category.php?event_category=Glazba">Glazba</a>
  <a href="view-category.php?event_category=Film">Film</a>
  <a href="view-category.php?event_category=Kazalište">Kazalište</a>
  <a href="view-category.php?event_category=Sport">Sport</a>
  <a href="view-category.php?event_category=Turizam">Turizam</a>
  <?php
  if ($row > 0) {
  ?>
    <div class="dropdown1">
      <button class="dropbtn1">Hi <?php echo $_SESSION['username'] ?>
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content1">
        <?php
        if ($row['UserType'] == 'admin') //samo admin može pregledavati narudžbe
        {
        ?>
          <a href="orders.php">Narudžbe</a>
        <?php
        }
        if (strlen($_SESSION['user_id'] > 0)) {
        ?>
          <a href="my-tickets.php">Moje ulaznice</a>
        <?php
        }
        ?>
        <?php
        if ($row['UserType'] == 'admin') { ?>
          <a href="add-event.php" title="Add new event">Novi događaj</a>
        <?php
        }
        ?>
        <a href="logout.php">Odjava</a>
      </div>
    </div>
  <?php } else { ?>
    <a href="register.php" style="float: right;">Registracija</a>
    <a href="login.php" style="float:right">Prijava</a>
  <?php } ?>
</div>