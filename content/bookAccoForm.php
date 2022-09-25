<?php
ini_set("session.save_path", "/home/unn_w21050558/sessionData"); //Session save file directory
session_start();                                                 //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Book your Holiday", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link.
//Additionally since this is a restricted page, a relevant message and a Sign In redirection link will be shown to unauthorized users
if (!check_login()) {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
    echo "<div class=\"restricted\">\n<p class=\"displayBox\">\nYou need to be logged in to access this page. Please use the <a href=\"signInForm.php\">Sign In</a> form to login.</p>\n</div>\n";
    echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
}
else {
    echo authenticationContent(array("logout.php" => "Logout"));
    //call to accoForm() function to display HTML elements upon successful login
    echo accoForm();
    echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
}
?>
