<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/RideBean.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_ride.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_user.php';

if (!isset($_SESSION['user']) || $_SESSION["user"]["is_admin"] == 1) {
    ?>
    <h1>403: Forbidden</h1>
    <?php
    header("Location: ../../index.php");
    die();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="/cedcab/css/style.css" rel="stylesheet"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="/cedcab/css/bootstrap.min.css">
        <script src="/cedcab/js/jquery-3.5.1.min.js"></script>
        <script src="/cedcab/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header id="header" class="container-fluid">
            <nav id="mainNavigation" class="navigation">
                <ul>
                    <li><a href="/cedcab/index.php">Home</a></li>
                    <li><a href="/cedcab/php/user/AllRides.php">All Rides</a></li>
                    <li><a href="/cedcab/php/user/index.php">Profile</a></li>
                    <li><form style="display: inline" action="/cedcab/php/logout.php" method="post">
                            <input type="hidden" value="true" name="userLogout">
                            <button class="btn btn-danger" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>

            </nav>
            <section id="branding" class="container-fluid">
                <div>
                    <img src="/cedcab/images/icons/logo.png" alt="site logo"/>
                    <div id="brandName">Ced<span style="color: #fbb031">Cab</span></div>
                </div>
            </section>
        </header>
