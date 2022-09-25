<?php
//For all HTML content functions use mainly heredoc to insert the HTML tags and return the output
function pageStartContent($pageTitle, $CSSfile){
    $pageStart = <<< PAGESTART
    <!--PE7045 - Final Assignment-->
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="$CSSfile"/>
        <meta charset="utf-8"/>
        <title>$pageTitle</title>
    </head>
    <body>
        <header class="headerGrid">
            <img src="../assets/images/logo2.png" alt="logo"/>
            <h1>Travel Wise</h1>
PAGESTART;
    $pageStart .= "\n";
    return $pageStart;
}

function navigationContent(array $navLinks){
    $navigationLinks = <<< NAVSTART
    <!--Navigation links for the main functionalities-->
    <nav>
        <ul>
NAVSTART;
    foreach($navLinks as $link => $linkText){
        $navigationLinks .= "\n<li><a href=\"$link\">$linkText</a></li>";
    }
    $navigationLinks .= "\n</ul>\n</nav>\n";
    return $navigationLinks;
}

function authenticationContent(array $authLinks){
    $authenticationLinks = <<< AUTHSTART
    <!--Sign in and Register links-->
    <div id="logIn">
        <ul>
AUTHSTART;
    foreach($authLinks as $link => $linkText){
        $authenticationLinks .= "\n<li><a href=\"$link\">$linkText</a></li>";
    }
    $authenticationLinks .= "\n</ul>\n</div>\n</header>\n";
    return $authenticationLinks;
}

function footerContent(array $footerLinks){
    $pageEnd = <<< FOOTER
            <footer>
                    <ul>
FOOTER;
    foreach($footerLinks as $link => $linkText){
        $pageEnd .= "\n<li><a href=\"$link\">$linkText</a></li>";
    }
    
    $pageEnd .= "\n</ul>\n"."<div id=\"social\">\n<a href=\"https://www.facebook.com/\" target=\"_blank\">\n<img src=\"../assets/images/fb_icon.png\" alt=\"FB logo\"/>\n</a>\n<a href=\"https://www.instagram.com/\" target=\"_blank\">\n<img src=\"../assets/images/insta_icon.png\" alt=\"insta logo\"/>\n</a>\n<a href=\"https://twitter.com/\" target=\"_blank\">\n<img src=\"../assets/images/twitter_icon.png\" alt=\"twitter logo\"/>\n</a>\n</div>"."\n</footer>\n</body>\n</html>\n";

    return $pageEnd;
}

function check_login() {
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
		return true;
	}
	else {
		return false;
	}
}

//Function to calculate teh date difference in days
function dateDiffInDays($date1, $date2) {
    $diff = strtotime($date2) - strtotime($date1);
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
}

function accoForm(){
    $accoFormStart =<<< START
        <div class="booking">
            <form action="bookAccoProcess.php" method="post" id="selectAcco">
                <label for="accommodation">Select Accommodation
                    <select name="accommodation" id="accommodation">
START;
                        //The following part ensures that when a customer selects an accommodation from the accommodation details page
                        //and clicks on continue to booking link, the ID of their selected accommodation will populate the
                        //select accommodation field in the book accommodation form and will be as read only
                        //However if the user goes straight into the book accommodation page they will be able to freely choose
                        //the accommodation of their liking
                        $url = "";
                        $url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                        $url = filter_var($url, FILTER_SANITIZE_URL); //remove all illegal URL characters
                        if(preg_match('/[0-9]/',substr($url, -1))){
                            require_once ('dbconn.php');
                            $conn = getConnection();
                            $accommodationID = 0;
                            //Check accommodationID has been passed in
                            if(array_key_exists('accommodationID', $_REQUEST )){
                                //check accommodationID is integer
                                $accommodationID = intval($_REQUEST['accommodationID']);
                                
                                
                                $sql = "SELECT accommodation_name FROM accommodation WHERE accommodationID = $accommodationID";
                                $queryresult = mysqli_query($conn, $sql);
                                if ($queryresult) {
                                    while ($currentrow = mysqli_fetch_assoc($queryresult)) {
                                        $name = $currentrow['accommodation_name'];
                                        $accoFormFull = $accoFormStart."<option value=$accommodationID readonly>$name</option>";
                                    }
                                }
                                mysqli_free_result($queryresult);
                            }
                            else {
                                echo "<p>Accommodation ID not found</p>";
                            }
                        }
                        else{
                            require_once ('dbconn.php');
                            $conn = getConnection();
                            $sql = "SELECT accommodationID, accommodation_name, description FROM accommodation";
                            $queryresult = mysqli_query($conn, $sql);
                            if ($queryresult) {
                                $option = "";
                                while ($currentrow = mysqli_fetch_assoc($queryresult)) {
                                    $ID = $currentrow['accommodationID'];
                                    $name = $currentrow['accommodation_name'];
                                    $option .= "<option value='$ID'>$name</option>";
                                }
                                $accoFormFull = $accoFormStart.$option;
                            }
                            mysqli_free_result($queryresult);
                        }
    $accoFormMiddle =<<< MIDDLE
                    </select>
                </label>
                <label for="start_date">Start Date
                    <input type="text" name="start_date" id="start_date">
                </label>
                <label for="end_date">End Date
                    <input type="text" name="end_date" id="end_date">
                </label>
                <label for="num_guests">Number of Guests
                    <input type="number" name="num_guests" id="num_guests">
                </label>
MIDDLE;
$accoFormFull .= $accoFormMiddle;
    $accoFormEnd =<<<END
                <label for="booking_notes">Booking Notes
                    <textarea name="booking_notes" id="booking_notes"></textarea>
                </label>
                <button type="submit" class="button">Book Now</button>
            </form>
        </div>
END;


$accoFormFull .= $accoFormEnd;
return $accoFormFull;
}

//Display the booking confirmation
function confirmation($cnx, $ipt){
    $accommodationID = $ipt['accommodation'];
    $sql = "SELECT b.bookingID, a.accommodation_name, b.start_date, b.end_date, b.num_guests, b.total_booking_cost FROM accommodation a INNER JOIN booking b ON a.accommodationID = b.accommodationID 
    WHERE a.accommodationID = $accommodationID AND b.bookingID = (SELECT MAX(bookingID) FROM booking)";
    $queryresult = mysqli_query($cnx, $sql);
    if ($queryresult) {
        $currentrow = mysqli_fetch_assoc($queryresult);
        $bookingID = $currentrow['bookingID'];
        $accoName = $currentrow['accommodation_name'];
        $sD = substr($currentrow['start_date'],0,10);
        $eD = substr($currentrow['end_date'],0,10);
        $cost = $currentrow['total_booking_cost'];
        $guests = $currentrow['num_guests'];
        
        $confirmationMessage = "Booking ID: $bookingID\n<br>Accommodation Name: $accoName\n<br>Start Date: $sD\n<br>End Date: $eD\n<br>Number of Guests: $guests\n<br>Total Cost: $cost\n<br><br>You will be redirected in the booking form in 5 seconds\n<br>";

    }
    mysqli_free_result($queryresult); 
    mysqli_close($cnx);
    return $confirmationMessage;
}

?>