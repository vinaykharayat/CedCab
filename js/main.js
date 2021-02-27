/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
let dropHiddenLocation = false;
let pickupHiddenLocation = false;

$(document).ready(function () {
    try {
        document.getElementById("rideBookingForm").reset(); //Reset the booking form

        /******************************************************************
         * Check if CedMicro is selected and disables the luggage dropdown.
         ******************************************************************/

        if ($(this).find("#navCabType input").val() == "micro" && $(this).find('#navCabType input').is(':checked')) {
            $("#luggageDropdown").attr('disabled', 'disabled');
            $("#bookButton").prev().append("<p style=\"color: red\" id=\"luggageNotAllowedNotice\">Luggage is not allowed with CedMicro<p>");
        } else {
            console.log("here");
            $("#luggageDropdown").removeAttr('disabled');
            $("#luggageNotAllowedNotice").remove();
        }

        /*****************************************************************
         * After user changes the cab type and again selects the CedMicro,
         * this function disables the luggage option again.
         * Also shows total fare on Book now button.
         *****************************************************************/
        $("#navCabType li").change(function () {
            if ($(this).find("input").val() == "micro" && $(this).find('input').is(':checked')) {
                $("#luggageDropdown").attr('disabled', 'disabled');
                $("#bookButton").prev().append("<p style=\"color: red\" id=\"luggageNotAllowedNotice\">Luggage is not allowed with CedMicro<p>");
            } else {
                $("#luggageDropdown").removeAttr('disabled');
                $("#luggageNotAllowedNotice").remove();
            }

        });
        /****************************
         * Adds locations to dropdown
         ****************************/
        $.ajax({
            url: "php/locations.php",
            dataType: "json",
            type: "get",
            contentType: "application/json; charset=utf-8",
            success: function (response) {
                addLocations(response);
            },
            error: function (e) {
                console.log(e);
            }
        });
    } catch (e) {
        console.log(e);
    }
});

$("#navCabType").change(function (e) {
    e.preventDefault();
    $.ajax({
        url: "./php/calculateFare.php",
        method: "post",
        data: $("#rideBookingForm").serialize(),
        success: function (response) {
            $("#bookButton").val("Book now @₹" + response["totalFare"] + " only");
        }
    });
});
/*************************************
 * When user changes PickUp Locations
 *************************************/

$("#pickupLocation").change(function (e) {

    dropHiddenLocation["hidden"] = false;
    let selectedValue = $(this).val();
    dropHiddenLocation = $("#dropLocation [value = \'" + selectedValue + "\']")[0];
    dropHiddenLocation["hidden"] = true;
    e.preventDefault();
    $.ajax({
        url: "./php/calculateFare.php",
        method: "post",
        data: $("#rideBookingForm").serialize(),
        success: function (response) {
            if ($("#pickupLocation").find(":selected").val() != "none" && $("#dropLocation").find(":selected").val() != "none")
                $("#bookButton").val("Book now @₹" + response["totalFare"] + " only");
        }
    });
});
/*********************************
 * When user changes drop location
 *********************************/

$("#dropLocation").change(function (e) {
    pickupHiddenLocation["hidden"] = false;
    let selectedValue = $(this).val();
    pickupHiddenLocation = $("#pickupLocation [value = \'" + selectedValue + "\']")[0];
    pickupHiddenLocation["hidden"] = true;
    e.preventDefault();
    $.ajax({
        url: "./php/calculateFare.php",
        method: "post",
        data: $("#rideBookingForm").serialize(),
        success: function (response) {
            if ($("#pickupLocation").find(":selected").val() != "none" && $("#dropLocation").find(":selected").val() != "none")
                $("#bookButton").val("Book now @₹" + response["totalFare"] + " only");
        }
    });
});
function addLocations(locations) {
    /*************************************
     * Adds locations to pickup locations.
     *************************************/
    Object.keys(locations).forEach(locationName => {
        let option = document.createElement("option");
        let value = document.createAttribute("value");
        let name = document.createAttribute("name");
        option.innerText = locations[locationName]["name"];
        name.value = "pickupLocation";
        value.value = locationName;
        option.setAttributeNode(value);
        $("#pickupLocation").append(option);
    });
    /*******************************************************************************
     * Adds locations to drop locations.
     * I did this seperately because .append() was moving items, instead of copying.
     * I don't know why :p
     *******************************************************************************/

    Object.keys(locations).forEach(locationName => {
        let option = document.createElement("option");
        let value = document.createAttribute("value");
        let name = document.createAttribute("name");
        option.innerText = locations[locationName]["name"];
        name.value = "pickupLocation";
        value.value = locationName;
        option.setAttributeNode(value);
        $("#dropLocation").append(option);
    });
}

/***********************************************************************
 * When user changes luggage, this updates the value on book now button
 ***********************************************************************/
$("#luggageDropdown").on("change", function (e) {
    e.preventDefault();
    $.ajax({
        url: "./php/calculateFare.php",
        method: "post",
        data: $("#rideBookingForm").serialize(),
        success: function (response) {
            if ($("#luggageDropdown").find(":selected").val() != "none" && $("#pickupLocation").find(":selected").val() != "none" && $("#dropLocation").find(":selected").val() != "none")
                $("#bookButton").val("Book now @₹" + response["totalFare"] + " only");
        }
    });
});
/**************************************
 * When user clicks on Book now button
 **************************************/
let rideDetails;
$("#bookButton").on("click", function (e) {
    e.preventDefault();
    $.ajax({
        url: "./php/calculateFare.php",
        method: "post",
        data: $("#rideBookingForm").serialize(),
        success: function (response) {
            rideDetails = response;
            if ($("#luggageDropdown").find(":selected").val() != "none" && $("#pickupLocation").find(":selected").val() != "none" && $("#dropLocation").find(":selected").val() != "none")
                $("#bookButton").val("Book now @₹" + response["totalFare"] + " only");
            document.querySelector(".modal-body").innerText =
                    "Pickup Location: " + response["pickupLocation"] +
                    "\nDrop Location: " + response["dropLocation"] +
                    "\nDistance: " + response["distance"] + "kms" +
                    "\nTotal Fare: ₹" + response["totalFare"] +
                    "\nCabType: Ced " + response["cabType"] +
                    "\nLuggage: " + $("#luggageDropdown option:selected").html();
            $("#confirmDialog").modal("show");
        }
    });
});

/************************************************************
 * When user clicked on "Confirm Booking" button inside modal
 ************************************************************/

$("#confirmBooking").on("click", function (e) {
    $.ajax({
        url: "/cedcab/login.php",
        method: "post",
        data: {"rideInfo": JSON.stringify(rideDetails)},
        success: function (response) {
            if (response == 200) {
                window.location.href = "/cedcab/login.php";
            } else if(response == 302){ //if user is already logged in
                window.location.href = "/cedcab/php/user/AllRides.php";
            }
        }
    });
});


