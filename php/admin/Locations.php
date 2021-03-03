<?php
include_once './layout/header.php';
?>
<main class="container-fluid mx-2">
    <div class="modal fade" id="addNewLocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adding new location!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newLocationForm" action="../AllLocationsHelper.php" method="post">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label mx-1">New&nbsp;Location&nbsp;Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control mx-1" id="newLocation" placeholder="Charbagh" required="required" name="locationName">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label mx-1">Distance&nbsp;from&nbsp;charbagh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control mx-1" id="newLocationDistance" placeholder="100, 200, etc." required="required" name="locationDistance">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label mx-1">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="locationStatus">
                                    <option selected="selected" value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
                    <button id = "confirmAddLocation" type = "submit" class = "btn btn-primary" style = "border:0;background-color: #fbb031" form="newLocationForm">Add Location</button>

                </div>
            </div>
        </div>
    </div>
    <div class="container float-right">
        <button value="admin" id="addLocation" class="btn my-3 float-right" style="background-color: #fbb031">+Add new location</button>
    </div>
    <table class="table my-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Distance</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</main>
<script>
    $.ajax({
        url: "../AllLocationsHelper.php",
        method: 'post',
        data: {
            'getLocation': true,
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

                let trAttr = document.createAttribute("id");
                trAttr.value = response[i]["id"];
                tableRow.setAttributeNode(trAttr);
                tableRow.appendChild(rideIdColumn);

                rideIdColumn.textContent = response[i]["id"];
                tableRow.appendChild(rideIdColumn);

                tableData.textContent = response[i]["name"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["distance"];
                tableRow.appendChild(tableData.cloneNode(true));
                
                (response[i]["is_available"] == 1)?tableData.textContent="Active":tableData.textContent="Blocked";

//                tableData.textContent = response[i]["is_available"];
                tableRow.appendChild(tableData.cloneNode(true));



                if (response[i]["is_available"] == "0") {
                    BtnAttr.value = "btn btn-success mx-2 my-2";
                    Btn.setAttributeNode(BtnAttr);
                    Btn.innerText = "Unblock Location";
                    tableRow.appendChild(Btn.cloneNode(true));
                } else {
                    BtnAttr.value = "btn btn-secondary mx-2 my-2 blockButton";
                    Btn.setAttributeNode(BtnAttr);
                    Btn.innerText = "Block Location";
                    tableRow.appendChild(Btn.cloneNode(true));

                }

                BtnAttr.value = "btn btn-danger mx-2 my-2 deleteButton";
                Btn.setAttributeNode(BtnAttr);
                Btn.innerText = "Delete Location";
                tableRow.appendChild(Btn.cloneNode(true));

                tableBody.appendChild(tableRow);
            }
            $("#tableBody .blockButton").on("click", function () {

                let res = confirm("Are you sure?");
                if (res) {
                    let locationId = $(this).parent().first().attr("id");
                    blockLocation(locationId, true);
                }
            });
            
            $("#tableBody .deleteButton").on("click", function () {

                let res = confirm("Are you sure?");
                if (res) {
                    let locationId = $(this).parent().first().attr("id");
                    deleteLocation(locationId, true);
                }
            });
            
            $("#tableBody .btn-success").on("click", function () {

                let res = confirm("Are you sure?");
                if (res) {
                    let locationId = $(this).parent().first().attr("id");
                    blockLocation(locationId, false);
                }
            });
        }
    });

    function blockLocation(locationId, blockLocation) {
        $.ajax({
            url: "../AllLocationsHelper.php",
            method: 'post',
            data: {
                'locationId': locationId,
                'blockLocation': blockLocation
            },
            success: function (response) {
                let res;
                if (response == 200) {
                    if (blockLocation) {
                        res = confirm("Location Blocked Successfully!");

                    } else {
                        res = confirm("Location Unblocked Successfully!");
                    }
                    if (res) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            }
        });
    }
    
    function deleteLocation(locationId, blockLocation) {
        $.ajax({
            url: "../AllLocationsHelper.php",
            method: 'post',
            data: {
                'locationId': locationId,
                'deleteLocation': blockLocation
            },
            success: function (response) {
                let res;
                if (response == 200) {
                    if (blockLocation) {
                        res = confirm("Location deleted Successfully!");

                    } else {
                        res = confirm("Something went wrong!");
                    }
                    if (res) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                }
            }
        });
    }

    $("#addLocation").on("click", function () {
        $("#addNewLocation").modal("show");
    });

    $("#newLocationForm").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "../AllLocationsHelper.php",
            method: "post",
            data: $("#newLocationForm").serialize(),
            success: function (response) {
                if (response == 200) {
                    let res = confirm("Location added Successfully!");
                    if (res) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                } else {
                    alert("Couldn't add Location!");
                }
            }
        })
    });

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