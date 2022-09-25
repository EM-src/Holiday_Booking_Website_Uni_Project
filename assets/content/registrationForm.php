<?php
//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Register", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));
echo authenticationContent(array("registrationForm.php" => "Register"));

?>
    <!-- HTML code for registration form -->
    <div class="registration">
        <form method="post" action="registrationProcess.php" id="regForm">
            <label class="col1" for="firstname">Firstname:
                <input type="text" name="firstname" id="firstname">
            </label>
            <label class="col2" for="surname">Surname:
                <input type="text" name="surname" id="surname">
            </label>
            <label class="col1" for="address1">Address 1:
                <input type="text" name="address1" id="address1">
            </label>
            <label class="col2" for="address2">Address 2:
                <input type="text" name="address2" id="address2">
            </label>
            <label class="col1" for="postcode">Post Code:
                <input type="text" name="postcode" id="postcode">
            </label>
            <label class="col2" for="dob">Date of Birth:
                <input type="text" name="dob" id="dob">
            </label>
            <label class="col1" for="username">Username:
                <input type="text" name="username" id="username">
            </label>
            <label class="col2" for="password">Password:
                <input type="password" name="password" id="password">
            </label>
            <label class="col2" for="cpwd">Confirm Password:
                <input type="password" name="cpwd" id="cpwd">
            </label>
            <button type="submit" class="button">Register</button>
        </form>
    </div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>