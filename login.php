<?php
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
            <form id="rideBookingForm">
                <nav class="navigation" id="authType">
                    <ul>
                        <li><input type="radio" value="login" name="loginType" checked> Login</li>
                        <li><input type="radio" value="register" name="loginType"> Register</li>
                    </ul>
                </nav>
                <div id="loginForm">
                    <div class="inputDiv" id="emailInput">
                        <label for="name">Email</label>
                        <input name="email" type="email" class="inputBox" placeholder="name@email.com">
                    </div>

                    <div class="inputDiv" id="passwordInput">
                        <label for="name">Password</label>
                        <input name="password" type="password" class="inputBox" placeholder="******">
                    </div>
                </div>
                
                <div id="registerForm">
                    <div class="inputDiv" id="nameInput">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="inputBox" placeholder="First Last name">
                    </div>
                    <div class="inputDiv" id="emailInput">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" class="inputBox" placeholder="name@email.com" required="required"><u><span id="verifyEmailButton" hidden="hidden">Verify Email!</span></u><span id="invalidEmail" class="invalid" hidden="hidden">Email taken!</span>
                    </div>
                    
                    <div class="inputDiv" id="phoneInput">
                        <label for="mobile">Mobile</label>
                        <input name="mobile" type="tel" class="inputBox" placeholder="+915555555555"><u><span id="verifyPhoneButton" hidden="hidden">Verify Phone!</span></u><span class="invalid" id="invalidPhone" hidden="hidden">Already registered!</span>
                    </div>

                    <div class="inputDiv" id="passwordInput">
                        <label for="name">Password</label>
                        <input name="password" type="password" class="inputBox" placeholder="Password (>6)"><span id="invalidLength" class="invalid" hidden="hidden">Password too short! </span>
                    </div>
                    
                    <div class="inputDiv" id="conPasswordInput">
                        <label for="password">Confirm</label>
                        <input name="conPass" type="password" class="inputBox" placeholder="******"><span class="invalid" id="invalidConPassword" hidden="hidden">Password did not match!</span><span class="valid" id="validConPassword" hidden="hidden">Password matched!</span>
                    </div>
                </div>
                <div></div>
                <input type="submit" name="bookCab" value="Login Now" id="bookButton" data-toggle="modal" data-target="#exampleModal">
            </form>
        </div>
    </div>
</main>
<script src="js/login.js"></script>
<?php
include_once 'footer.php';
?>