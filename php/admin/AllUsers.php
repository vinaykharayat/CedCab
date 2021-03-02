<?php
include_once './layout/header.php';
?>
<main>
    <table class="table my-3">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Email ID</th>
                <th>Name</th>
                <th>Date of Registration</th>
                <!--<th>Total Distance</th>-->

                <th id="totalFare">Phone</th>
                <th id="rideStatus">Status</th>
                <th>Profile Pic</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
</main>

<script>

    $.ajax({
        url: "../AllUsersHelper.php",
        method: 'post',
        data: {
            'getUsers': true,
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
                trAttr.value = response[i]["user_id"];
                tableRow.setAttributeNode(trAttr);
                tableRow.appendChild(rideIdColumn);

                rideIdColumn.textContent = response[i]["user_id"];
                tableRow.appendChild(rideIdColumn);

                tableData.textContent = response[i]["email_id"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["name"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["dateofsignup"];
                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["mobile"];
                tableRow.appendChild(tableData.cloneNode(true));
                
                (response[i]["status"]==0)?tableData.textContent = "Blocked":tableData.textContent = "Active";

                tableRow.appendChild(tableData.cloneNode(true));

                tableData.textContent = response[i]["profilePic"];
                tableRow.appendChild(tableData.cloneNode(true));



                if (response[i]["status"] == "0") {
                    BtnAttr.value = "btn btn-success mx-2 my-2";
                    Btn.setAttributeNode(BtnAttr);
                    Btn.innerText = "Unblock User";
                    tableRow.appendChild(Btn.cloneNode(true));
                } else {
                    BtnAttr.value = "btn btn-danger mx-2 my-2";
                    Btn.setAttributeNode(BtnAttr);
                    Btn.innerText = "Block User";
                    tableRow.appendChild(Btn.cloneNode(true));

                }
                tableBody.appendChild(tableRow);
            }
            $("#tableBody .btn-danger").on("click", function () {

                let res = confirm("Are you sure?");
                if (res) {
                    let userId = $(this).parent().first().attr("id");
                    blockUser(userId, true);
                }
            });
            $("#tableBody .btn-success").on("click", function () {

                let res = confirm("Are you sure?");
                if (res) {
                    let userId = $(this).parent().first().attr("id");
                    blockUser(userId, false);
                }
            });
        }
    });

    function blockUser(userId, blockUser) {
        $.ajax({
            url: "../AllUsersHelper.php",
            method: 'post',
            data: {
                'userId': userId,
                'blockUser': blockUser
            },
            success: function (response) {
                let res;
                if (response == 200) {
                    if (blockUser) {
                        res = confirm("User Blocked Successfully!");

                    } else {
                        res = confirm("User Unblocked Successfully!");
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
