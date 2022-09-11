<?php
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Home", "../assets/stylesheets/styles.css");
echo navigationContent(array("home.php" => "Home", "accommodationListing.php" => "Accommodation Listing", "bookAccommodation.html" => "Book Accommodation", "about.html" => "About"));
echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));

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
echo footerContent();
?>
