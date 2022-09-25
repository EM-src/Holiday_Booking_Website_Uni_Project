<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData"); //Session save file directory
session_start();                                                            //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Features notes", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link.
//Additionally since this is a restricted page, a relevant message and a Sign In redirection link will be shown to
//unauthorized users. The exit() php function is used to end the script in case of an unauthorized access attempt so the HTML part will not be shown
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
    echo "<div class=\"restricted\">\n<p class=\"displayBox\">\nYou need to be logged in to access this page. Please use the <a href=\"signInForm.php\">Sign In</a> form to login.</p>\n</div>\n";
    echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
    exit();
}
?>

<!-- Features bulletpoints content -->
<div id="features">
    <h2>Features</h2>
    <p>Please note, in almost all pages the contentFunctions.php has been used. Also dbconn.php was imported<br>
        where database connectivity was necessary for database driven content. For simplicity's sake these files<br>
        have been ommited from the bulletpoints features listings that follow below. Finally all pages and CSS<br>
        have been successfully validated in w3.org with no errors</p>
    <ul>
        <li>Home page
            <ol>
                <li>index.php</li>
            </ol>
        </li>
        <li>Restricted pages
            <ol>
                <li>contentFunctions.php - check_login() function</li>
            </ol>
        </li>
        <li>Registration functionality
            <ol>
                <li>registrationForm.php</li>
                <li>registrationProcess.php</li>
            </ol>
        </li>
        <li>Sign In functionality
            <ol>
                <li>signInForm.php</li>
                <li>signInProcess.php</li>
            </ol>
        </li>
        <li>Logout functionality
            <ol>
                <li>logout.php</li>
            </ol>
        </li>
        <li>Accommodation Listing page
            <ol>
                <li>accoListing.php</li>
            </ol>
        </li>
        <li>Accommodation Details page
            <ol>
                <li>accoDetails.php</li>
            </ol>
        </li>
        <li>Book Accommodation functionality
            <ol>
                <li>bookAccoForm.php</li>
                <li>bookAccoProcess.php</li>
                <li>contentFunctions.php - accoForm() function</li>
            </ol>
        </li>
        <li>Upcoming Bookings and Cancel functionality
            <ol>
                <li>myBookings.php</li>
            </ol>
        </li>
        <li>About page
            <ol>
                <li>about.php</li>
            </ol>
        </li>
        <li>Wireframes page
            <ol>
                <li>wrfms.php</li>
            </ol>
        </li>
        <li>Security Report page
            <ol>
                <li>securityReport.php</li>
            </ol>
        </li>
        <li>Credits page
            <ol>
                <li>credits.php</li>
            </ol>
        </li>
    </ul>
</div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>