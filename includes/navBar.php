<?php
$user_id = $_SESSION['user_id'];
$ret = mysqli_query($con, "select * from users where ID='$user_id'");
$row = mysqli_fetch_array($ret)
?>

<div id="navBar">
    <a href="index.php">Početna</a>
    <a href="#">Link</a>
    <a href="#">Link</a>

    <?php
    if ($row['UserType'] == 'admin') {
    ?>
    <a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a>
    <?php } ?>

    <?php
    if ($row > 0) {
    ?>
        <a href="logout.php" style="float:right">Odjava</a>
    <?php } else { ?>
        <a href="login.php" style="float:right">Prijava</a>
    <?php } ?>
</div>


<!-- modal box to add a new event -->

<div class="container">
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Dodaj novi događaj</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container">
                        <h4>Informacije o događaju</h4>
                        <form method="POST">
                            <div class="form-group">
                                <label for="title">Naziv događaja</label>
                                <input type="text" class="form-control" id="title" placeholder="Unesi naziv događaja" name="title">
                            </div>
                            <div class="form-group">
                                <label for="location">Mjesto izvođenja događaja</label>
                                <input class="form-control" id="location" placeholder="Unesi lokaciju događaja" name="location"></input>
                            </div>
                            <div class="form-group">
                                <label for="image">Fotografija događaja</label>
                                <input type="text" class="form-control" id="image" placeholder="Unesi url fotografije" name="image">
                            </div>
                            <div class="form-group">
                                <label for="date">Datum i vrijeme događanja</label>
                                <input type="datetime-local" class="form-control" id="date" placeholder="Unesi datum događaja" name="date">
                            </div>

                            <button type="submit" class="btn btn-primary" name="addEvent">Spremi</button>
                        </form>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
                </div>

            </div>
        </div>
    </div>
</div>