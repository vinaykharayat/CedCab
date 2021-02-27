/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#showPending").trigger("click");

    $.ajax({
        url: "../AllRidesHelper.php",
        method: "post",
        data: {"action": "getUserRideInfo",
            'isAdmin': $("#showPending").val()},
        success: function (response) {
            document.getElementById("pendingRides").textContent = response['pendingRides'];
            document.getElementById("cancelledRides").textContent = response['cancelledRides'];
            document.getElementById("totalSpent").textContent = "₹" + response['totalSpent'];
            document.getElementById("totalRides").textContent = response['totalRides'];
        }
    });
});

$("#showPending").on("click", function () {
    getData("pending", false, $(this).val());
});

$("#showCancelled").on("click", function () {
    getData("cancelled", false, $(this).val());
});

$("#showTotalSpent").on("click", function () {
    getData("totalSpent", false, $(this).val());
});

$("#showTotalRides").on("click", function () {
    getData("allRides", true, $(this).val());
});

function getData(status, showStatus, isAdmin) {

    $.ajax({
        url: "../AllRidesHelper.php",
        method: 'post',
        data: {
            'status': status,
            'isAdmin': isAdmin
        },
        success: function (response) {
            let tableBody = document.getElementById("tableBody");

            while (tableBody.firstChild) {
                tableBody.removeChild(tableBody.firstChild);
            }

            for (let i = 0; i < response.length; i++) {
                let tableRow = document.createElement("tr");
                let rideIdColumn = document.createElement("th");
                let tableData = document.createElement("td");

                let Btn = document.createElement("button");
                let BtnAttr = document.createAttribute("class");
                BtnAttr.value = "btn btn-outline-primary mx-2 my-2";
                Btn.setAttributeNode(BtnAttr);
                Btn.innerText = "View Details";

                let trAttr = document.createAttribute("id");
                trAttr.value = response[i]["ride_id"];
                tableRow.setAttributeNode(trAttr);

                rideIdColumn.textContent = response[i]["ride_id"];
                tableRow.appendChild(rideIdColumn);


                tableData.textContent = response[i]["from"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["to"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["ride_date"];
                tableRow.appendChild(tableData.cloneNode(true));

//                    tableData.textContent = response[i]["total_distance"];
//                    tableRow.appendChild(tableData.cloneNode(true));

//                    tableData.textContent = response[i]["luggage"];
//                    tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = "₹" + response[i]["total_fare"];
                tableRow.appendChild(tableData.cloneNode(true));

                if (showStatus) {
                    $("#rideStatus").show();
                    tableData.textContent = response[i]["status"];
                    tableRow.appendChild(tableData.cloneNode(true));
                } else {
                    $("#rideStatus").hide();
                }

                tableData.textContent = response[i]["cabtype"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableRow.appendChild(Btn.cloneNode(true));
                if (response[i]["status"] == "1") {
                    BtnAttr.value = "btn btn-danger mx-2 my-2";
                    Btn.setAttributeNode(BtnAttr);
                    Btn.innerText = "Cancel";
                    tableRow.appendChild(Btn.cloneNode(true));
                }
                tableBody.appendChild(tableRow);
            }
            $("#tableBody .btn-danger").on("click", function () {

                let res = confirm("Are you sure?\nThis cannot be undone!");
                if (res) {
                    let rideId = $(this).parent().first().attr("id");
                    cancelRide(rideId);
                }
            });

            $("#tableBody .btn-outline-primary").on("click", function () {
                let rideId = $(this).parent().first().attr("id");
                viewRideDetails(rideId);
            });
        }
    });
}

function cancelRide(rideId) {
    $.ajax({
        url: "../AllRidesHelper.php",
        method: "post",
        data: {"cancelRide": rideId,
            'isAdmin': $("#showPending").val()},
        success: function (response) {
            if (response == 200) {
                let res = confirm("Ride Cancelled Successfully!");
                if (res) {
                    location.reload();
                } else {
                    location.reload();
                }
            }
        }
    });
}

function viewRideDetails(rideId) {
    $("#viewRideDetails").modal("show");
    $.ajax({
        url: "../AllRidesHelper.php",
        method: "post",
        data: {"viewRide": rideId,
            'isAdmin': $("#showPending").val()},
        success: function (response) {
            console.log(response);
            document.querySelector(".modal-body").innerText =
                    "Pickup Location: " + response["from"] +
                    "\nDrop Location: " + response["to"] +
                    "\nDate: " + response["ride_date"] +
                    "\nDistance: " + response["total_distance"] + "kms" +
                    "\nTotal Fare: ₹" + response["total_fare"] +
                    "\nCabType: Ced " + response["cabtype"] +
                    "\nLuggage: " + response["luggage"] +
                    "\nStatus: " + response["status"];
            $("#viewRideDetails").modal("show");
        }
    });
}

$("#selectMonth").on("change", function () {
    console.log($())
});


