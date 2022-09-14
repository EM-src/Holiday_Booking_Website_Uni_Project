<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();

require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Home", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "about.html" => "About"));

if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
}

?>

<main>
    <ol class="activities">
        <li>Activity a</li>
        <li>Activity b</li>
        <li>Activity c</li>
        <li>Activity d</li>
        <li>Activity e</li>
        <li>Activity f</li>
    </ol>
    <img src="../assets/images/island.png" alt="island"/>
</main>

<?php
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
?>
