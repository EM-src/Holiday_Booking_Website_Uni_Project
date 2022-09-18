<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();

require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Upcoming Bookings", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.html" => "About"));

// using the 'logged-in' as the indicator that the user is logged in.  This was set in the login process.
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("signInForm.php" => "Sign In"));
    echo "<div class=\"restricted\">\n<p class=\"displayBox\">\nYou need to be logged in to access this page. Please use the <a href=\"signInForm.php\">Sign In</a> form to login.</p>\n</div>";}
?>

<div class="accoList">
    <form action="" method="post" id="selectAcco">
        <label for="myBooking">My Bookings:
            <select name="myBooking">
            <?php
                require_once ('dbconn.php');
                $conn = getConnection();

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
    if (array_key_exists('myBooking',$_POST)) {
            $bookingID = $_POST['myBooking'];
            $sqlGetDate = "SELECT start_date FROM booking WHERE bookingID = $bookingID";
            $sql = "DELETE FROM booking WHERE bookingID = $bookingID";
            $querySDresult = mysqli_query($conn, $sqlGetDate);            
            if($querySDresult){
                $currentrow = mysqli_fetch_assoc($querySDresult);
                $startdate = substr($currentrow['start_date'],0,10);
                if(dateDiffInDays($startdate, date("Y/m/d")) < 2){
                    echo "<div>\n<p class=\"displayBox2\">Selected booking cannot be canceled as its Start Date is within 2 days from current date.</p></div>";
                }
                else{
                    $queryresult = mysqli_query($conn, $sql);
                    if ($queryresult) {
                        echo "<div>\n<p class=\"displayBox2\">Your selected booking with booking reference: $bookingID, has been canceled. <a href=\"myBookings.php\">Refresh</a> page to view your updated bookings.</p></div>";
                    }
                }
            }
        }
	?>

</div>


<?php
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
?>