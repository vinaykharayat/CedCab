<?php
include_once './layout/header.php';

?>
<main class="container-fluid">
    <div class="modal fade" id="viewRideDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ride Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
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
                                <button value="admin" id="showPending" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="pendingRides"></span> Pending Rides<br></button>
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
                                <button value="admin" id="showCancelled" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="cancelledRides"></span> Cancelled Rides</button>
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
                                <button value="admin" id="showTotalSpent" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="totalSpent"></span> Earned</button>
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
                                <button value="admin" id="showTotalRides" class="btn my-3" style="width: 100%;background-color: #fbb031"><span id="totalRides"></span> Total Rides</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-3 d-flex">
        <form action="action" class="form-inline mx-auto">
            <div class="form-group row mb-2 mx-2">
                <div class="col-sm-10 col">
                    <h3 class="my-auto">Filter&nbsp;By:</h3>
                </div>
            </div>
            <div class="form-group row mb-2 mx-2">
                <div class="col-sm-10 col">
                    <select class="form-control" name="SelectedMonth" id="selectMonth">
                        <option value="0" selected="selected" disabled="disabled">Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2 mx-2">
                <div class="col-sm-10 col">
                    <select class="form-control" name="SelectedWeek" id="selectWeek">
                        <option value="value" selected="selected" disabled="disabled">Select week</option>
                        <option value="1">1st Week</option>
                        <option value="2">2nd Week</option>
                        <option value="3">3rd Week</option>
                        <option value="4">4th Week</option>

                    </select>
                </div>
            </div>
            <div class="form-group row mb-2 mx-2">
                <select class="form-control" name="sortBy" id="selectSortBy">
                    <option value="value" selected="selected" disabled="disabled">Sort By</option>
                    <option value="fare">Fare</option>
                    <option value="date">Date</option>
                </select>
            </div>

            <div class="form-group row mb-2 mx-2">
                <select class="form-control" name="sortBy" id="selectCabType">
                    <option value="value" selected="selected" disabled="disabled">CabType</option>
                    <option value="micro">Ced Micro</option>
                    <option value="mini">Ced Mini</option>
                    <option value="suv">Ced Suv</option>
                    <option value="royale">Ced Royale</option>
                </select>
            </div>
        </form>
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
<script src="../../js/allRides.js"></script>
<?php
if ($_SESSION["user"]["is_admin"] == 1) {
    header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "/cedcab/php/admin/index.php");
} else if (isset($_SESSION["user"]) && $_SESSION["user"]["is_admin"] != 1) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/user/layout/footer.php';
} else {
    include_once 'footer.php';
}
?>
