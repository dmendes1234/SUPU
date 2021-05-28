<?php
$user_id = $_SESSION['user_id'];
$ret = mysqli_query($con, "select * from users where ID='$user_id'");
$row = mysqli_fetch_array($ret)
?>

<div class="navigation">
  <a href="index.php">Home</a>
  <?php
     if ($row['UserType'] == 'admin') //samo admin može pregledavati narudžbe
     {  
    ?>
  <a href="orders.php">Narudžbe</a>
  <?php 
     }
     if (strlen($_SESSION['user_id'] > 0)){ 
    ?>
    <a href="my-tickets.php">Moje ulaznice</a>
    <?php
     }

     
//ako želimo da samo s početne stranice možemo dodavati nove događaje
//$url = $_SERVER["REQUEST_URI"]; 
//$pos = strrpos($url, "index.php"); 

//if ($row['UserType'] == 'admin' && $pos == true) {
//<a href="add-event.php" title="Add new event"><i class="fa fa-plus"></i></a>}
?>

<a href="add-event.php" title="Add new event"><i class="fa fa-plus"></i></a>

<?php 

    if ($row > 0) {
    ?>
  <div class="dropdown1">
    <button class="dropbtn1">Hi <?php echo $_SESSION['username'] ?> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content1">
      <a href="logout.php">Odjava</a>
    </div>
  </div> 
  <?php } else { ?>
    <a href="register.php" style="float: right;">Registracija</a>
    <a href="login.php" style="float:right">Prijava</a>
    <?php } ?>
</div>
