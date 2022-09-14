<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();

require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Listings", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "about.html" => "About"));

if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
}
?>

<div class="accoList">
    <form action="" method="post" id="selectAcco">
        <label for="accomodation">Select Accommodation
            <select name="accommodation">
            <?php
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
                //mysqli_close($conn);
            ?>
            </select>
        </label>
        <button type="submit" class="button">Show</button>
    </form>
    
    <?php

		
		if (array_key_exists('accommodation',$_POST)) {
			$accommodationID = $_POST['accommodation'];
            //require ('dbconn.php');
            //$conn = getConnection();
	 
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
				
                echo "<div>\n<p class=\"displayBox2\">\nName: $name, $ID\n<br>Description: $desc\n<br>Location: $location\n<br>Country: $country\n<br>Price: $price\n<br><a href=\"bookAccoForm.php?accommodationID=$ID\">Continue to Booking</a>\n</p>\n</div>";
            }
			mysqli_free_result($queryresult); 
            mysqli_close($conn);
		}
		else {
			//header('Location: accoListing.php');
			exit;
		}
	?>

</div>

<?php
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
?>