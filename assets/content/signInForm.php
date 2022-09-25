<?php
//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Sign In", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
}
else {
    echo authenticationContent(array("SignInForm.php" => "Sign In"));
}
?>
<!-- The sign in form -->
<div class="signIn">
    <form method="post" action="signInProcess.php" id="siForm">
        <label class="col1" for="username">User Name: 
            <input type="text" name="username" id="username">
        </label>
        <label class="col1" for="password">Password: 
            <input type="password" name="password" id="password">
        </label>
        <button type="submit" class="button">Sign In</button>
    </form>
</div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>