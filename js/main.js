/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
let dropHiddenLocation = false;
let pickupHiddenLocation = false;

$(document).ready(function () {
    document.getElementById("rideBookingForm").reset();
    if ($(this).find("input").val() == "micro" && $(this).find('input').is(':checked')) {
        $("#luggageDropdown").attr('disabled', 'disabled');
        $("#bookButton").prev().append("<p style=\"color: red\" id=\"luggageNotAllowedNotice\">Luggage is not allowed with CedMicro<p>");
    } else {
        $("#luggageDropdown").removeAttr('disabled');
        $("#luggageNotAllowedNotice").remove();
    }
    $("#navCabType li").change(function () {
        if ($(this).find("input").val() == "micro" && $(this).find('input').is(':checked')) {
            $("#luggageDropdown").attr('disabled', 'disabled');
            $("#bookButton").prev().append("<p style=\"color: red\" id=\"luggageNotAllowedNotice\">Luggage is not allowed with CedMicro<p>");
        } else {
            $("#luggageDropdown").removeAttr('disabled');
            $("#luggageNotAllowedNotice").remove();
        }
    });
    $.ajax({
        url: "php/locations.php",
        dataType: "json",
        type: "get",
        contentType: "application/json; charset=utf-8",
        success: function (response) {
            let locations = response;
            addLocations(locations);
        },
        error: function (e) {
            console.log(e);
        }
    });
});

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
    Object.keys(locations).forEach(locationName => {
        let option = document.createElement("option");
        let value = document.createAttribute("value");
        let name = document.createAttribute("name");
        name.value = "pickupLocation";
        value.value = locationName;
        option.setAttributeNode(value);
        option.textContent = locationName;
        $("#pickupLocation").append(option);

    });

    Object.keys(locations).forEach(locationName => {
        let option = document.createElement("option");
        let value = document.createAttribute("value");
        let name = document.createAttribute("name");
        name.value = "dropLocation";
        value.value = locationName;
        option.setAttributeNode(value);
        option.textContent = locationName;
        $("#dropLocation").append(option);

    });

}

$("#navCabType").on("change", function (e) {
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


$("#bookButton").on("click", function (e) {
    e.preventDefault();
    $.ajax({
        url: "./php/calculateFare.php",
        method: "post",
        data: $("#rideBookingForm").serialize(),
        success: function (response) {
            console.log(response["pickupLocation"]);
            if ($("#luggageDropdown").find(":selected").val() != "none" && $("#pickupLocation").find(":selected").val() != "none" && $("#dropLocation").find(":selected").val() != "none")
                $("#bookButton").val("Book now @₹" + response["totalFare"] + " only");
            document.querySelector(".modal-body").innerText = 
                    "Pickup Location: "+response["pickupLocation"]+
                    "\nDrop Location: "+ response["dropLocation"]+
                    "\nDistance: "+response["distance"]+"kms"+
                    "\nTotal Fare: ₹"+response["totalFare"]
        }
    });
});


