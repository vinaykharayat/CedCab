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

<h1>Welcome <?= $_SESSION["user"]["name"] ?></h1>

<?php
//include_once './layout/footer.php';
?>

