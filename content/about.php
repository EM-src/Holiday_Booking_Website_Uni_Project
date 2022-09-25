<?php
ini_set("session.save_path", "/home/unn_w21050558/sessionData"); //Session save file directory
session_start();                                                 //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - About", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
}
?>
<!-- Display a cover page for the practical part of the PE7045 assignment -->
    <div id="about">
        <img src="../assets/images/uniLogo.png" alt="uniLogo"/>
        <h2>TravelWise website Development<br>and Deployment</h2>
        <p>
           <span>Author: </span>Emmanouil Marketos<br>
           <span>Student ID: </span> 21050558<br><br>
           <span>Professor: </span>Dr Emma Anderson<br><br><br><br>
           A web solution submitted as partial fulfilment of<br>the requirements for course PE7045 - Secure Web Development<br><br><br><br>
           at<br>Northumbria University<br>September 2022
        </p>
    </div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>
