<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Unset all of the session variables.
if (filter_input(INPUT_POST, "userLogout") !== null ||
        filter_input(INPUT_POST, "adminLogout") !== null) {
    
    $_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
        );
    }

// Finally, destroy the session.
    session_unset();
    session_destroy();
    header("Location: ../../cedcab/index.php");
    
} else {
    print_r($_POST);
    ?>
    <h1>u403: Forbidden</h1>
    <?php
    die();
}



