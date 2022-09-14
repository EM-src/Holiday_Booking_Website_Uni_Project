<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();

require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Credits", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "about.html" => "About"));

// using the 'logged-in' as the indicator that the user is logged in.  This was set in the login process.
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));

	echo "<p>Welcome! This page could now display information</p>\n";
}
else {
    echo authenticationContent(array("signInForm.php" => "Sign In"));
    echo "<p>You need to be logged in to access this page. Please use the <a href=\"signInForm.php\">Sign In</a> form to login.</p>";
}
?>

<?php
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
?>