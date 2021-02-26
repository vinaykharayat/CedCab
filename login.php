<?php
session_start();

/* * ****************************************************************************
 * If user has clicked on book ride but is not logged in,
 * Redirect him to again to this page directly. And set POST data into session
 * **************************************************************************** */
if (isset($_POST['rideInfo']) && !isset($_SESSION['user'])) { //user came through modal "confirm button"
    echo '200';
    die();
}


/* *****************************************************************
 * If user is already logged in and if user came by booking button
 * Set Ride info to session and redirect user to 'AllRides.php'
 * **************************************************************** */
if (isset($_SESSION['user']) && $_SESSION['user']["is_admin"] == 0) {
//    header("Location: ./php/user/index.php");
    echo "302";
    $_SESSION['loggedInUserRideInfo'] = json_decode($_POST["rideInfo"]);
    $_SESSION['alreadyLoggedIn'] = true;
    die();
}
/* * ************************************************************** */


include_once 'header.php';
?>
<main class="container-fluid">
    <div id="container">
        <div> 
            <div id="imageBackground" style="visibility: hidden">
            </div>
            <img src="./images/authentication.png" alt="Taxi Image" id="authImage"/>
        </div>
        <div id="formContainer">
            <h1 id="formHeading" style="display: inline; font-size: 50px; font-weight: 400">Login to continue!</h1>
            <nav style="display: block"class="navigation" id="authType">
                <ul>
                    <li><input type="radio" value="login" name="loginType" checked> Login</li>
                    <li><input type="radio" value="register" name="loginType"> Register</li>
                </ul>
            </nav>
            <form id="loginForm">
                <div>
                    <div class="inputDiv" id="emailInput">
                        <label for="name">Email</label>
                        <input name="email" type="email" class="inputBox" placeholder="name@email.com" required="required">
                    </div>

                    <div class="inputDiv" id="passwordInput">
                        <label for="name">Password</label>
                        <input name="password" type="password" class="inputBox" placeholder="******" required="required">
                    </div>
                </div>
                <input type="submit" name="login" value="Login Now" id="login">

            </form>

            <form id="registerForm" enctype="multipart/form-data">
                <div>
                    <div class="inputDiv" id="nameInputReg">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="inputBox" placeholder="First Last name" required="required">
                    </div>
                    <div class="inputDiv" id="emailInputReg">
                        <label for="email">Email</label>
                        <input id="emailReg" name="email" type="email" class="inputBox" placeholder="name@email.com" required="required"><u><span id="verifyEmailButton" hidden="hidden">Verify Email!</span></u><span id="invalidEmail" class="invalid" hidden="hidden">Email taken!</span>
                    </div>

                    <div class="inputDiv" id="phoneInputReg">
                        <label for="mobile">Mobile</label>
                        <input id="phoneReg" name="mobile" type="tel" class="inputBox" placeholder="5555555555" max="10" required="required"><u><span id="verifyPhoneButton" hidden="hidden">Verify Phone!</span></u><span class="invalid" id="invalidPhone" hidden="hidden">Already registered!</span>
                    </div>

                    <div class="inputDiv" id="passwordInputReg">
                        <label for="name">Password</label>
                        <input id="password" name="password" type="password" class="inputBox" placeholder="Password (>6)" required="required"><span id="invalidLength" class="invalid" hidden="hidden">Password too short! </span>
                    </div>

                    <div class="inputDiv" id="conPasswordInputReg">
                        <label for="password">Confirm</label>
                        <input id="conPassword" name="conPass" type="password" class="inputBox" placeholder="******" required="required"><span class="invalid" id="invalidConPassword" hidden="hidden">Password did not match!</span><span class="valid" id="validConPassword" hidden="hidden">Password matched!</span>
                    </div>

                    <div class="inputDiv" id="file">
                        <label for="file">Profile</label>
                        <input id="file" name="file" type="file" class="inputBox"><span class="invalid" id="invalidFile" hidden="hidden">Invalid file</span>
                    </div>
                </div>
                <input type="submit" name="register" value="Register Now" id="register">
                <div></div>
            </form>
        </div>
    </div>
</main>
<script src="js/login.js"></script>
<?php
include_once 'footer.php';
?>