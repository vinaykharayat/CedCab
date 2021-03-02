<?php
session_start();

/* * ***********************************************************************
 * When user is logged in and clicked on Re confirm booking in modal.
 * 
 * *********************************************************************** */
include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_ride.php';
if (isset($_POST["confirmBooking"]) && isset($_SESSION["rideInfoWithId"])) {
    $user = $_SESSION["user"];
    $rideInfo = $_SESSION["rideInfoWithId"];

    $ride = new tbl_ride();
    $ride->setFrom($rideInfo["pickupLocation"]);
    $ride->setTo($rideInfo["dropLocation"]);
    $ride->setTotal_distance($rideInfo["distance"]);
    $ride->setLuggage($rideInfo["luggage"]);
    $ride->setTotal_fare($rideInfo["totalFare"]);
    $ride->setCustomer_user_id($user["user_id"]);
    $ride->setCabType($rideInfo["cabType"]);

    $res = $ride->addNewRide();

    if ($res == 200) {
        unset($_SESSION["rideInfoWithId"]);
        echo '200';
        die();
    } else if ($res != 404) {
        unset($_SESSION["rideInfoWithId"]);
        echo '404';
        die();
    } else {
        print_r($res);
        die();
    }
}
include_once './layout/header.php';

/* * *************************************************************
 * If user has logged in and promoted to confirm old booking
 * ************************************************************ */
if (isset($_SESSION["rideInfoWithId"]) && !isset($_POST["confirmBooking"])) {

    $rideInfo = $_SESSION["rideInfoWithId"];

    $ride = new RideBean();
    $pickupLocation = $ride->getLocationNameDistance($rideInfo["pickupLocation"]);
    $dropLocation = $ride->getLocationNameDistance($rideInfo["dropLocation"]);
    ?>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Booking?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pickup Location: <?= $pickupLocation["name"] ?><br>

                    Drop Location: <?= $dropLocation["name"] ?><br>

                    Distance: <?= $rideInfo["distance"] ?><br>

                    Total Fare: <?= $rideInfo["totalFare"] ?><br>

                    Cab Type: <?= $rideInfo["cabType"] ?><br>

                    Luggage: <?= $rideInfo["luggage"] ?><br>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
                    <button id = "confirmBooking2" type = "button" class = "btn btn-primary" style = "border:0;background-color: #fbb031">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
    <script>
        $("#exampleModal2").modal("show");
        $("#confirmBooking2").on("click", function () {
            $.ajax({
                url: "index.php",
                method: "post",
                data: {"confirmBooking": "true"},
                success: function (response) {
                    if (response == 200) {
                        let res = confirm("Ride Booked successfully");
                        if (res) {
                            location.reload();
                        }
                    } else {
                        alert("Something went wrong!\nTechnical Details: " + response);
                    }
                }

            });
        });
    </script>

    <?php
}
?> 
<main style="width: 100%">
    <section class="container-fluid">
        <div class="">
            <?php
            if ($_SESSION["user"]["profilePic"] == "") {
                ?>
                <img class="rounded-circle my-3" width="304" height="236" src="../uploads/user.png" alt="user profile picture" id="profilePicture"/>
                <?php
            } else {
                ?>

                <img class="rounded-circle my-3" width="304" height="236" src=".<?= $_SESSION['user']['profilePic'] ?>" alt="user profile picture" id="profilePicture"/>

                <?php
            }
            ?>
            <?php
            ?>
            <input type="file" id="imgupload" hidden="hidden" name="imgupload"/> 
            <h1>Welcome <?= $_SESSION["user"]["name"] ?></h1>
        </div>
        <button class="btn btn-secondary" id="btnChangePassword">Change Password</button>
        <form action="action" class="my-4" id="profileForm">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label mx-1">Name</label>
                <div class="col-5">
                    <input type="text" value="<?= $_SESSION['user']['name'] ?>" class="form-control  d-block" placeholder="Charbagh" required="required" name="userName" disabled="disabled">
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label mx-1 d-block">Email</label>
                <div class="col-5">
                    <p id="emailAddress" class="mx-1"><?= $_SESSION['user']['email_id'] ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label mx-1 d-block">Phone Number</label>
                <div class="col-5">
                    <input type="text" value="<?= $_SESSION['user']['mobile'] ?>" class="form-control mx-1 d-block" placeholder="8888888888" required="required" name="userMobile" disabled="disabled">

                </div>
            </div>
            <input name="profileChange" hidden="hidden">
            <button class="btn btn-outline-primary" type="button" id="editProfile">Edit Profile</button>
            <button class="btn btn-success" id="saveChanges">Save Changes</button>
            <button class="btn btn-secondary" type="button" id="cancel">Cancel</button>
        </form>
    </section>
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change password!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updatePasswordForm" action="../AllLocationsHelper.php" method="post">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label mx-1">Old&nbsp;Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control mx-1" id="oldPassword" placeholder="******" required="required" name="oldPassword">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label mx-1">New&nbsp;Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control mx-1" id="newPassword" placeholder="******" required="required" name="newPassword">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label mx-1">Confirm&nbsp;new&nbsp;Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control mx-1" id="confirmNewPassword" placeholder="******" required="required" name="confirmNewPassword">
                            </div>
                        </div>
                    </form>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
                    <button id = "confirmAddLocation" form="updatePasswordForm" type = "submit" class = "btn btn-primary" style = "border:0;background-color: #fbb031" form="newLocationForm">Confirm Changes</button>

                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function () {
        $("#saveChanges").hide();
        $("#cancel").hide();
    });

    $("#profilePicture").on("click", function () {
        let res = confirm("Would you like to change your profile picture?");
        if (res) {
            $("#imgupload").trigger("click");
        }

    });

    $("#imgupload").on("change", function () {
        let formData = new FormData();
        formData.append('imgupload', $("#imgupload")[0].files[0]);
        $.ajax({
            url:"../AllUsersHelper.php",
            method:"post",
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            success: function(response){
                if(response==200){
                    alert("Image updated successfully!");
                    location.reload();
                }
            }
        });
        let res1 = $(this).val();
        console.log("here"+res1);
    });

    $("#updatePasswordForm").on("submit", function (e) {
        e.preventDefault();
        if ($("#newPassword").val().length >= 6) {
            if ($("#newPassword").val() == $("#confirmNewPassword").val()) {
                $.ajax({
                    url: "../AllUsersHelper.php",
                    method: "post",
                    data: $("#updatePasswordForm").serialize(),
                    success: function (response) {
                        if (response == 200) {
                            alert("Password updated successfully!");
                            location.reload();
                        } else if (response == 403) {
                            alert("Incorrect Old password!");
                        } else if (response == 500) {
                            alert("Something went wrong!");
                        }
                    }
                });
            } else {
                alert("Password did not match!");
            }
        } else {
            alert("Password length too short!");
        }

    });

    $("#btnChangePassword").on("click", function () {
        $("#changePassword").modal("show");
    });

    $("#editProfile").on("click", function () {
        $("#profileForm").find("input").prop("disabled", false);
        $("#saveChanges").show();
        $("#cancel").show();
        $("#editProfile").hide();
    });

    $("#profileForm").on("submit", function (e) {
        e.preventDefault();
        $("#saveChanges").hide();
        $("#cancel").hide();
        $("#editProfile").show();
        $.ajax({
            url: "../AllUsersHelper.php",
            method: "post",
            data: $("#profileForm").serialize(),
            success: function (response) {
                $("#profileForm").find("input").prop("disabled", true);
                if (response == 200) {
                    alert("Profile updated successfully!");
                    location.reload();
                } else {
                    alert("Something went wrong!");
                    location.reload();
                }
            }
        });
    });

    $("#cancel").on("click", function () {
        $("#profileForm").find("input").prop("disabled", true);
        $("#saveChanges").hide();
        $("#cancel").hide();
        $("#editProfile").show();
    });


</script>
<?php
include_once './layout/footer.php';
?>

