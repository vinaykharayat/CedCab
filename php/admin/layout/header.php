<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../../css/style.css" rel="stylesheet"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script src="../../js/jquery-3.5.1.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
    </head>
    <body>
        <header id="header" class="container-fluid">
            <nav id="mainNavigation" class="navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="/cedcab/php/admin/AllUsers.php">Users</a></li>
                    <li><a href="/cedcab/php/admin/AllRides.php">All Rides</a></li>
                    <li><form style="display: inline" action="/cedcab/php/logout.php" method="post">
                            <input type="hidden" value="true" name="userLogout">
                            <button class="btn btn-danger" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>

            </nav>
            <section id="branding" class="container-fluid">
                <div>
                    <img src="../../images/icons/logo.png" alt="site logo"/>
                    <div id="brandName">Ced<span style="color: #fbb031">Cab</span></div>
                </div>
            </section>
        </header>
