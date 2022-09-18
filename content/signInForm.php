<?php
//ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
//session_start();

require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Sign In", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.html" => "About"));
//echo authenticationContent(array("signInForm.php" => "Sign In"));
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
}
else {
    echo authenticationContent(array("SignInForm.php" => "Sign In"));
}
?>

<div class="signIn">
    <form method="post" action="signInProcess.php" id="siForm">
        <label class="col1" for="username">User Name: 
            <input type="text" name="username">
        </label>
        <label class="col1" for="password">Password: 
            <input type="password" name="password">
        </label>
        <button type="submit" class="button">Sign In</button>
    </form>
</div>

<?php
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
?>