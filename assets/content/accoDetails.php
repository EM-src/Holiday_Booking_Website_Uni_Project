<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData"); //Session save file directory
session_start();                                                            //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Accommodation Details", "../assets/stylesheets/styles.css");
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

<!-- Form with dropdown box that dynamically gets all accommodations inserted in DB and Show button to display info for teh selected accommodation -->
<div class="accoDetails">
    <form method="post" id="selectAcco">
        <label for="accomodation">Select Accommodation
            <select name="accommodationID" id="accomodation">
            <?php
                // Include file that contains code to connect to database
                require_once ('dbconn.php');
                $conn = getConnection();

                $sql = "SELECT accommodationID, accommodation_name, description FROM accommodation";
                $queryresult = mysqli_query($conn, $sql);
                if ($queryresult) {
                    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
                        $ID = $currentrow['accommodationID'];
                        $name = $currentrow['accommodation_name'];
                        echo "<option value='$ID'>$name</option>";
                    }
                }

                mysqli_free_result($queryresult);
            ?>
            </select>
        </label>
        <button type="submit" class="button">Show</button>
    </form>
    
    <?php
        //for the selected accommodation ID all required information will be displayed to the user in a display box (separate container)
		if (array_key_exists('accommodationID',$_POST)) {
			$accommodationID = $_POST['accommodationID'];

			$sql = "SELECT accommodationID, accommodation_name, description, location, country, price_per_night FROM accommodation WHERE accommodationID = $accommodationID";
			$queryresult = mysqli_query($conn, $sql);

			if ($queryresult) {
				$currentrow = mysqli_fetch_assoc($queryresult);
                $ID = $currentrow['accommodationID'];
				$name = $currentrow['accommodation_name'];
				$desc = $currentrow['description'];
				$location = $currentrow['location'];
				$country = $currentrow['country'];
				$price = $currentrow['price_per_night'];
				
                echo "<div>\n<p class=\"displayBox2\">\nID: $ID\n<br>Name: $name\n<br>Description: $desc\n<br>Location: $location\n<br>Country: $country\n<br>Price: $price\n<br><a href=\"bookAccoForm.php?accommodationID=$ID\">Continue to Booking</a>\n</p>\n</div>";
            }
			mysqli_free_result($queryresult); 
            mysqli_close($conn);
		}
        
	?>

</div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>