<?php
include_once './layout/header.php';
?>
<main class="container-fluid">
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
    <section class="grey-bg container-fluid ">
        <div class="container-fluid">
            <div class="row flex-grow-1" style="width: 100%">
                <div class="col-xl-3 col-sm-6 col-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="container-fluid align-self-center">
                                        <img class="d-block mx-auto" src="/cedcab/images/icons/pending.png" width="128" height="120" alt="pending rides"/>
                                    </div>
                                </div>
                                <button id="showPending" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="pendingRides"></span> Pending Rides<br></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="container-fluid align-self-center">
                                        <img class="d-block mx-auto" src="/cedcab/images/icons/cancel.png" width="128" height="120" alt="cancellled rides"/>
                                    </div>

                                </div>
                                <button id="showCancelled" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="cancelledRides"></span> Cancelled Rides</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="container-fluid align-self-center">
                                        <img class="d-block mx-auto" src="/cedcab/images/icons/money.png" width="128" height="120" alt="total spent"/>
                                    </div>

                                </div>
                                <button id="showTotalSpent" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="totalSpent"></span> Spent</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="container-fluid align-self-center">
                                        <img class="d-block mx-auto" src="/cedcab/images/icons/completed.png" width="128" height="120" alt="completed rides"/>
                                    </div>

                                </div>
                                <button id="showTotalRides" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="totalRides"></span> Total Rides</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <table class="table my-3">
        <thead>
            <tr>
                <th>Ride ID</th>
                <th>From</th>
                <th>To</th>
                <th>Ride Date</th>
                <!--<th>Total Distance</th>-->
                <!--<th>Luggage</th>-->
                <th id="totalFare">Total Fare</th>
                <th id="rideStatus">Ride Status</th>
                <th>CabType</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>
</main>
<script>
    $(document).ready(function () {
        $("#showPending").trigger("click");

        $.ajax({
            url: "../AllRidesHelper.php",
            method: "post",
            data: {"action": "getUserRideInfo"},
            success: function (response) {
                document.getElementById("pendingRides").textContent = response['pendingRides'];
                document.getElementById("cancelledRides").textContent = response['cancelledRides'];
                document.getElementById("totalSpent").textContent = "₹" + response['totalSpent'];
                document.getElementById("totalRides").textContent = response['totalRides'];
            }
        });
    });

    $("#showPending").on("click", function () {
        getData("pending", false);
    });

    $("#showCancelled").on("click", function () {
        getData("cancelled", false);
    });

    $("#showTotalSpent").on("click", function () {
        getData("totalSpent", false);
    });

    $("#showTotalRides").on("click", function () {
        getData("allRides", true);
    });

    function getData(status, showStatus) {
        $.ajax({
            url: "../AllRidesHelper.php",
            method: 'post',
            data: {'status': status},
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
                $("#tableBody button").on("click", function () {

                    let res = confirm("Are you sure?\nThis cannot be undone!");
                    if (res) {
                        let rideId = $(this).parent().first().attr("id");
                        cancelRide(rideId);
                    }
                });
            }
        });
    }

    function cancelRide(rideId) {
        $.ajax({
            url: "../AllRidesHelper.php",
            method: "post",
            data: {"cancelRide": rideId},
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

</script>
<?php
if ($_SESSION["user"]["is_admin"] == 1) {
    header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "/cedcab/php/admin/index.php");
} else if (isset($_SESSION["user"]) && $_SESSION["user"]["is_admin"] != 1) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/user/layout/footer.php';
} else {
    include_once 'footer.php';
}
?>
