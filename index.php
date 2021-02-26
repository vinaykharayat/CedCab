<?php
session_start();
if ($_SESSION["user"]["is_admin"] == 1) {
    header("Location: /php/admin/index.php");
} else if (isset($_SESSION["user"]) && $_SESSION["user"]["is_admin"] != 1) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/user/layout/header.php';
} else {
    include_once 'header.php';
}
?>
<main>
    <div id="container">
        <div>
            <!-- Image -->
            <div id="imageBackground">
            </div>
            <img src="./images/taxiImage.png" alt="Taxi Image" id="taxiImage"/>
        </div>
        <div id="formContainer">
            <h1 style="display: inline; font-size: 50px; font-weight: 400">Online taxi booking</h1>
            <form id="rideBookingForm">
                <nav class="navigation" id="navCabType">
                    <ul>
                        <li><input type="radio" value="micro" name="cabType" checked> Ced Micro</li>
                        <li><input type="radio" value="mini" name="cabType"> Ced Mini</li>
                        <li><input type="radio" value="royal" name="cabType"> Ced Royal</li>
                        <li><input type="radio" value="suv" name="cabType"> Ced SUV</li>
                    </ul>
                </nav>

                <div class="select">
                    <select name="pickupLocation" id="pickupLocation" required="required">
                        <option selected="selected" value="none" disabled="disabled">Select Pickup Location</option>
                    </select>
                </div>

                <div class="select">
                    <select name="dropLocation" id="dropLocation" required="required">
                        <option selected="selected" value="none" disabled="disabled">Select Drop Location</option>
                    </select>
                </div>

                <div class="select" id="luggageDropdownContainer">
                    <select name="luggage" value="none" data-placeholder="Luggage" id="luggageDropdown">
                        <option value="0">No luggage</option>
                        <option value="10">Upto 10 Kgs</option>
                        <option value="20">11-20KGs</option>
                        <option value="21">21Kgs or more</option>
                    </select>
                </div>
                <div></div>
                <input type="submit" name="bookCab" value="Book Now" id="bookButton" data-toggle="modal">
            </form>
        </div>
    </div>
        <div class="modal fade" id="confirmDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Booking?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
                        <button id = "confirmBooking" type = "button" class = "btn btn-primary" style = "border:0;background-color: #fbb031">Confirm Booking</button>
                    </div>
                </div>
            </div>
        </div>

</main>
<?php
if ($_SESSION["user"]["is_admin"] == 1) {
    header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "/cedcab/php/admin/index.php");
} else if (isset($_SESSION["user"]) && $_SESSION["user"]["is_admin"] != 1) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/user/layout/footer.php';
} else {


    include_once 'footer.php';
}
?>