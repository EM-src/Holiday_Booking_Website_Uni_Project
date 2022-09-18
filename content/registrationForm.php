<?php
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Register", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.html" => "About"));
echo authenticationContent(array("registrationForm.php" => "Register"));
/*if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
}*/
?>
<div class="registration">
    <form method="post" action="registrationProcess.php" id="regForm">
        <label class="col1" for="firstname">Firstname:
            <input type="text" name="firstname">
        </label>
        <label class="col2" for="surname">Surname:
            <input type="text" name="surname">
        </label>
        <label class="col1" for="address1">Address 1:
            <input type="text" name="address1">
        </label>
        <label class="col2" for="address2">Address 2:
            <input type="text" name="address2">
        </label>
        <label class="col1" for="postcode">Post Code:
            <input type="text" name="postcode">
        </label>
        <label class="col2" for="dob">Date of Birth:
            <input type="text" name="dob">
        </label>
        <label class="col1" for="username">Username:
            <input type="text" name="username">
        </label>
        <label class="col2" for="password">Password:
            <input type="password" name="password">
        </label>
        <label class="col2" for="cpwd">Confirm Password:
            <input type="password" name="cpwd">
        </label>
        <button type="submit" class="button">Register</button>
    </form>
</div>
<?php
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
?>