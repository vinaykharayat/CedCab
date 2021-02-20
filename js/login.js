/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $("#loginForm").show();
    $("#registerForm").hide();
})
$("#authType input").change(function () {
    console.log($(this));
    if ($(this).val() == "login") {
        $("#loginForm").fadeIn();
        $("#registerForm").hide();
    } else if ($(this).val() == "register") {
        $("#loginForm").hide();
        $("#registerForm").fadeIn();
    }
}
)


