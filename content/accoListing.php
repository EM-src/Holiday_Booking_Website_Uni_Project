<?php
ini_set("session.save_path", "/home/unn_w21050558/sessionData"); //Session save file directory
session_start();                                                 //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Listings", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link.
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
}
?>

<div class="list">
<table>
<tr><th>Accommodation ID</th><th>Accommodation Name</th><th>Description</th><th>Price per night</th>
<th>Location</th><th>Country</th></tr>
    <?php
    // Include file that contains code to connect to database
    require_once ('dbconn.php');
    $conn = getConnection();

    //Select every column from accommodation table (essentially every accommodation entry)
    //iterate through every row and retrieve the values. Then put them in a table to be displayed to the user
    $sql = "SELECT * FROM accommodation";
    $queryresult = mysqli_query($conn, $sql);
    if ($queryresult) {
        while ($currentrow = mysqli_fetch_assoc($queryresult)) {
            $ID = 	$currentrow['accommodationID'];
            $name = $currentrow['accommodation_name'];
            $desc = $currentrow['description'];
            $price = $currentrow['price_per_night'];
            $location = $currentrow['location'];
            $country = $currentrow['country'];

            echo "\n\t<tr><td>$ID</td><td>$name</td><td>$desc</td><td>$price</td>";
            echo "<td>$location</td><td>$country</td>";

        }
    }
    echo "\n";
    mysqli_free_result($queryresult);
    mysqli_close($conn);

    ?>
</table>
</div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>
