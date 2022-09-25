<?php
ini_set("session.save_path", "/home/unn_w21050558/sessionData"); //Session save file directory
session_start();                                                 //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Upcoming Bookings", "../assets/stylesheets/styles.css");
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

<div class="myBookings">
    <form method="post" id="selectAcco">
        <label for="myBooking">My Bookings:
            <select name="myBooking" id="myBooking">
            <?php
                //DB connection
                require_once ('dbconn.php');
                $conn = getConnection();

                //Get the logged in user's bookings that they are still active (end date is still in the future)
                //Display them in a drop down box showing the main booking details
                $username = $_SESSION['user'];
                $sql = "SELECT b.bookingID, b.accommodationID, a.accommodation_name, b.start_date, b.end_date, b.num_guests, b.total_booking_cost, b.booking_notes FROM accommodation a INNER JOIN booking b ON a.accommodationID = b.accommodationID
                INNER JOIN customers c ON c.customerID = b.customerID WHERE c.username = \"$username\" AND b.end_date > CURTIME()";

                $queryresult = mysqli_query($conn, $sql);
                if ($queryresult) {
                    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
                        $bookingID = $currentrow['bookingID'];
                        $accID = $currentrow['accommodationID'];
                        $name = $currentrow['accommodation_name'];
                        $sD = substr($currentrow['start_date'],0,10);
                        $ed = substr($currentrow['end_date'],0,10);
                        $guests = $currentrow['num_guests'];
                        $cost = $currentrow['total_booking_cost'];
                        $notes = $currentrow['booking_notes'];
                        echo "<option value='$bookingID'>Ref: $bookingID, $name, $sD to $ed, for $guests, $cost</option>";
                    }
                }

                mysqli_free_result($queryresult);
            ?>
            </select>
        </label>
        <button type="submit" class="button" >Cancel Booking</button>
    </form>

    <?php
    //Add functionality of canceling the selected booking only if either the start date is still within 2 days of current date
    //so no last minute cancels and display the outcome (either successfull cancelation or not) to the user
    if (array_key_exists('myBooking',$_POST)) {
            $bookingID = $_POST['myBooking'];
            $sqlGetDate = "SELECT start_date FROM booking WHERE bookingID = $bookingID";
            $sql = "DELETE FROM booking WHERE bookingID = $bookingID";
            $querySDresult = mysqli_query($conn, $sqlGetDate);
            if($querySDresult){
                $currentrow = mysqli_fetch_assoc($querySDresult);
                $startdate = substr($currentrow['start_date'],0,10);
                if(dateDiffInDays(date("Y-m-d"), $startdate) < 2 || $startdate < date("Y-m-d")){
                    echo "<div>\n<p class=\"displayBox2\">Selected booking cannot be canceled as its Start Date is either within 2 days from current date, or has already past.</p></div>";
                }
                else{
                    $queryresult = mysqli_query($conn, $sql);
                    if ($queryresult) {
                        echo "<div>\n<p class=\"displayBox2\">Your selected booking with reference: $bookingID, has been canceled. <a href=\"myBookings.php\">Refresh</a> page to view your updated bookings.</p></div>";
                    }
                }
            }
        }
	?>

</div>


<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>
