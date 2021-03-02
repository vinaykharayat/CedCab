<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/dao/Dbcon.php';

class tbl_ride extends Dbcon {

    const SOURCE_TBL = "tbl_ride";

    private $ride_id;
    private $ride_date;
    private $from;
    private $to;
    private $total_distance;
    private $luggage;
    private $total_fare;
    private $status;
    private $customer_user_id;
    private $cabType;
    private $allRidesArr;

    function __construct() {
        $this->getConn();
    }

    function getConn() {
        $this->createConnection();
    }

    function addNewRide() {
        $query = "insert into `" . self::SOURCE_TBL . "` "
                . "(`ride_date`, `from`, `to`,`total_distance`, `luggage`, `total_fare`, `status`, `customer_user_id`, `cabtype`) "
                . "values(now(), '$this->from', '$this->to', '$this->total_distance','$this->luggage','$this->total_fare','1','$this->customer_user_id','$this->cabType')";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return 200;
        } else if ($this->conn->affected_rows == 0) {
            return 404;
        } else {
            return $this->conn->error;
        }
    }

    function getAllRides($customer_user_id) {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `customer_user_id` = '$customer_user_id'";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getAllRidesAdmin() {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where 1";

//        $query = "select * from `" . self::SOURCE_TBL . "` where '1'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function calculateDistance($dropLocation, $pickupLocation) {
        return abs($pickupLocation - $dropLocation);
    }

    function getTotalPendingRides($userid) {
        $query = "select `status` from `tbl_ride` where `status` = '1' and `customer_user_id` = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getTotalPendingRidesAdmin() {
        $query = "select `status` from `tbl_ride` where `status` = '1'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getAllPendingRides($userid) {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `status` = '1' and `customer_user_id` = '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getAllPendingRidesAdmin() {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `status` = '1'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getTotalCancelledRides($userid) {
        $query = "select `status` from `tbl_ride` where `status` = '0' and `customer_user_id` = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getTotalCancelledRidesAdmin() {
        $query = "select `status` from `tbl_ride` where `status` = '0'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getAllCancelledRides($userid) {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `status` = '0' and `customer_user_id` = '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getAllCancelledRidesAdmin() {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `status` = '0'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getTotalSpent($userid) {
        $query = "select sum(`total_fare`) as `total_spent` from `tbl_ride` where `status` = '2' and `customer_user_id` = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->fetch_assoc()['total_spent'];
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getTotalSpentAdmin() {
        $query = "select sum(`total_fare`) as `total_spent` from `tbl_ride` where `status` = '2'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->fetch_assoc()['total_spent'];
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getAllTotalSpent($userid) {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `status` = '2' and `customer_user_id` = '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getAllTotalSpentAdmin() {
        $query = "select a.`ride_id`, a.`ride_date`, b.`name` as `from`, c.`name` as `to`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`status`, a.`customer_user_id`, a.`cabtype` from `tbl_ride` as a join `tbl_location` as `b` on a.`from` = b.`id` join `tbl_location` as `c` on a.`to` = c.`id` where `status` = '2'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getTotalRides($userid) {
        $query = "select `status` from `tbl_ride` where `customer_user_id` = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getTotalRidesAdmin() {
        $query = "select `status` from `tbl_ride` where '1'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        } else {
            if ($this->conn->errno == 0)
                return 0;
            else
                return $this->conn->error;
        }
    }

    function getAllTotalRides($userid) {
        $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id` = '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function cancelRide($rideid) {
        $query = "update `" . self::SOURCE_TBL . "` set `status` = '0' where `ride_id` = '$rideid'";
        $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return 200;
        } else {
            return $this->conn->error;
        }
    }

    function getRide($rideid) {
        $query = "select * from `" . self::SOURCE_TBL . "` where `ride_id` = $rideid";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return -1;
        }
    }

    function getSingleFilteredData($sortValue, $sort_type, $rideStatus, $userid, $isAdmin = false) {
        if ($isAdmin) {
            switch ($sort_type) {
                case "month":
                    if ($rideStatus == -1) {
                        $query = "select * from `" . self::SOURCE_TBL . "` where month(`ride_date`) = '$sortValue' order by `ride_date`";
                    } else {
                        $query = "select * from `" . self::SOURCE_TBL . "` where month(`ride_date`) = '$sortValue' and `status` = '$rideStatus' order by `ride_date`";
                    }
                    break;
                case "week":
                    if ($rideStatus == -1) {
                        $query = "select * from `" . self::SOURCE_TBL . "` where week(`ride_date`) = ''$sortValue' order by `ride_date`";
                    } else {
                        $query = "select * from `" . self::SOURCE_TBL . "` where week(`ride_date`)=''$sortValue' and `status` = '$rideStatus' order by `ride_date`";
                    }
                    break;
                case "sortBy":
                    if ($sortValue == "total_fare") {
                        if ($rideStatus == -1) {
                            $query = "select * from `" . self::SOURCE_TBL . "` order by `$sortValue`";
                        } else {
                            $query = "select * from `" . self::SOURCE_TBL . "` where `status` = '$rideStatus' order by `$sortValue`";
                        }
                    } else if ($sortValue == "ride_date") {
                        if ($rideStatus == -1) {
                            $query = "select * from `" . self::SOURCE_TBL . "` order by `$sortValue`";
                        } else {
                            $query = "select * from `" . self::SOURCE_TBL . "` where `status` = '$rideStatus' order by `$sortValue`";
                        }
                    }
                    break;

                default:
                    if ($rideStatus == -1) {
                        $query = "select * from `" . self::SOURCE_TBL . "` where `cabtype` = '$sortValue'";
                    } else {
                        $query = "select * from `" . self::SOURCE_TBL . "` where `cabtype` = '$sortValue' and `status` = '$rideStatus'";
                    }
                    break;
            }

//        die($sortValue." ".$sort_type. " ". $query);

            $res = $this->conn->query($query);
            if ($this->conn->affected_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $this->allRidesArr[] = $row;
                }
                return 200;
            } else {
                return 500;
            }
        } else {
            switch ($sort_type) {
                case "month":
                    if ($rideStatus == -1) {
                        $query = "select * from `" . self::SOURCE_TBL . "` where month(`ride_date`) = '$sortValue' and `customer_user_id` = '$userid' order by `ride_date`";
                    } else {
                        $query = "select * from `" . self::SOURCE_TBL . "` where month(`ride_date`) = '$sortValue' and `status` = '$rideStatus' and `customer_user_id` = '$userid' order by `ride_date`";
                    }
                    break;
                case "week":
                    if ($rideStatus == -1) {
                        $query = "select * from `" . self::SOURCE_TBL . "` where week(`ride_date`) = ''$sortValue' and `customer_user_id`= '$userid' order by `ride_date`";
                    } else {
                        $query = "select * from `" . self::SOURCE_TBL . "` where week(`ride_date`)=''$sortValue' and `status` = '$rideStatus' and `customer_user_id` = '$userid' order by `ride_date`";
                    }
                    break;
                case "sortBy":
                    if ($sortValue == "total_fare") {
                        if ($rideStatus == -1) {
                            $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id` = '$userid' order by `$sortValue`";
                        } else {
                            $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id` = '$userid' and `status` = '$rideStatus' order by `$sortValue`";
                        }
                    } else if ($sortValue == "ride_date") {
                        if ($rideStatus == -1) {
                            $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id` = '$userid' order by `$sortValue`";
                        } else {
                            $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id` = '$userid' and `status` = '$rideStatus' order by `$sortValue`";
                        }
                    }
                    break;

                default:
                    if ($rideStatus == -1) {
                        $query = "select * from `" . self::SOURCE_TBL . "` where `cabtype` = '$sortValue' and `customer_user_id` = '$userid'";
                    } else {
                        $query = "select * from `" . self::SOURCE_TBL . "` where `cabtype` = '$sortValue' and `customer_user_id` = '$userid' and `status` = '$rideStatus'";
                    }
                    break;
            }

//        die($sortValue." ".$sort_type. " ". $query);

            $res = $this->conn->query($query);
            if ($this->conn->affected_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $this->allRidesArr[] = $row;
                }
                return 200;
            } else {
                return 500;
            }
        }
    }

    function getCabType($userid) {
        return $this->cabType;
    }

    function setCabType($cabType): void {
        $this->cabType = $cabType;
    }

    function getRide_id() {
        return $this->ride_id;
    }

    function getRide_date() {
        return $this->ride_date;
    }

    function getFrom() {
        return $this->from;
    }

    function getTo() {
        return $this->to;
    }

    function getTotal_distance() {
        return $this->total_distance;
    }

    function getLuggage() {
        return $this->luggage;
    }

    function getTotal_fare() {
        return $this->total_fare;
    }

    function getStatus() {
        return $this->status;
    }

    function getCustomer_user_id() {
        return $this->customer_user_id;
    }

    function setRide_id($ride_id): void {
        $this->ride_id = $ride_id;
    }

    function setRide_date($ride_date): void {
        $this->ride_date = $ride_date;
    }

    function setFrom($from): void {
        $this->from = $from;
    }

    function setTo($to): void {
        $this->to = $to;
    }

    function setTotal_distance($total_distance): void {
        $this->total_distance = $total_distance;
    }

    function setLuggage($luggage): void {
        $this->luggage = $luggage;
    }

    function setTotal_fare($total_fare): void {
        $this->total_fare = $total_fare;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setCustomer_user_id($customer_user_id): void {
        $this->customer_user_id = $customer_user_id;
    }

    function getAllRidesArr() {
        return $this->allRidesArr;
    }

    function setAllRidesArr($allRidesArr): void {
        $this->allRidesArr = $allRidesArr;
    }

}
