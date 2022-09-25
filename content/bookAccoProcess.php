<?php
    ini_set("session.save_path", "/home/unn_w21050558/sessionData"); //Session save file directory
    session_start();                                                 //Continuing or starting session

    //Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
    require_once('contentFunctions.php');

    //$conn is established once and then used when necessary from validate_form(), confirmation() and process_form() funtions.
    //This is a better practice than making the $conn global
    require_once ('dbconn.php');
    $conn = getConnection();

    echo pageStartContent("Travel Wise - Book your Holiday", "../assets/stylesheets/styles.css");
    echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));
    echo authenticationContent(array("logout.php" => "Logout"));

    //Retrieve the arrays defined and populated by validate_form() function and display the output accordingly.
    //Either the errors in case any were found or a booking confirmation of a successfully booked accommodation
    list($input, $errors) = validate_form($conn);
    if ($errors) {
        echo "<div class=\"booking\">\n<p class=\"displayBox\">\n".show_errors($errors)."</p>\n</div>";
    }
    else {
        process_form($input, $conn);
        echo "<div class=\"booking\">\n<h2>Confirmation of booking details</h2>\n<p class=\"displayBox2\">\n".confirmation($conn, $input)."</p>\n</div>";
    }

?>

<?php
function validate_form($cnx){
    $input = array();
    $errors = array();

    $input['accommodation'] = array_key_exists('accommodation', $_REQUEST) ? $_REQUEST['accommodation'] : null;
    $input['accommodation'] = trim($input['accommodation']);
    $hotels = array('1','2','3','4','5','6','7','8','9','10','11','12');
    if(!empty($input['accommodation'])){
        if(!in_array($input['accommodation'], $hotels)){ //Check if selected accommodation is a valid accommodation ID
            $errors[] = "Error! Not a valid accommodation";
        }
    }
    else{
        $errors[] = "Error! Accommodation name is empty.";
    }

    $input['start_date'] = array_key_exists('start_date', $_REQUEST) ? $_REQUEST['start_date'] : null;
    $input['start_date'] = trim($input['start_date']);
    if(!empty($input['start_date'])){
        $input['start_date'] = filter_var($input['start_date'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if(!preg_match('/^\d{4}\/(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $input['start_date'])){//2nd step define the date format needed by the user with a regex
            $errors[] = "Error! Start Date must have format yyyy/mm/dd.";
        }
        else{
            $input['start_date'] = strtotime($input['start_date']); // convert input string to date object
            $input['start_date'] = date('Y/m/d', $input['start_date']); // define date object format
            if($input['start_date'] < date("Y/m/d")){ // 3rd check the start date has to be greater than or equal current date
                $errors[] = "Error! Start Date has to be greater than or equal to today.";
            }
        }
    }
    else{
        $errors[] = "Error! Your Start Date is empty.";
    }

    $input['end_date'] = array_key_exists('end_date', $_REQUEST) ? $_REQUEST['end_date'] : null;
    $input['end_date'] = trim($input['end_date']);
    if(!empty($input['end_date'])){ // 1st step make sure end date is not empty
        $input['end_date'] = filter_var($input['end_date'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //2nd step remove tags to prevent XSS attack
        if(!preg_match('/^\d{4}\/(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $input['end_date'])){//3rd step define the date format needed by the user
            $errors[] = "Error! End Date must have format yyyy/mm/dd.";
        }
        else{
            $input['end_date'] = strtotime($input['end_date']); // convert input string to date object
            $input['end_date'] = date('Y/m/d', $input['end_date']); // define date object format
            if($input['end_date'] <= date("Y/m/d") || $input['end_date'] <= $input['start_date']){ //4th check the end date has to be greater than the current date and also greater than start date
                $errors[] = "Error! End Date has to be greater than today and also greater from start date.";
            }
        }
    }
    else{
        $errors[] = "Error! Your End Date is empty.";
    }

    $input['num_guests'] = array_key_exists('num_guests', $_REQUEST) ? $_REQUEST['num_guests'] : null;
    $input['num_guests'] = abs((int)$input['num_guests']); // cast input into integer and make sure the inserted value is positive
    if(!empty($input['num_guests'])){
        $input['num_guests'] = filter_var($input['num_guests'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if(!filter_var($input['num_guests'], FILTER_VALIDATE_INT)){ //2nd step num_guests must be an int
            $errors[] = "Error! Number of guests must be an integer.";
        }
    }
    else{
        $errors[] = "Error! You must specify the number of guests.";
    }

    $input['booking_notes'] = array_key_exists('booking_notes', $_REQUEST) ? $_REQUEST['booking_notes'] : null;
    $input['booking_notes'] = trim($input['booking_notes']);
    if(!empty($input['booking_notes'])){
        $input['booking_notes'] = filter_var($input['booking_notes'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        $input['booking_notes'] = filter_var($input['booking_notes'], FILTER_SANITIZE_SPECIAL_CHARS); //2nd step remove special characters
    }

    //Total Cost calculation for selected accommodation ID
    //Get price per night, then see for how many days is the stay, then multiply by price per night
    //Insert the calculated value into the input[] array in order to be processed later
    $temp = $_REQUEST['accommodation'];
    $sql = "SELECT price_per_night FROM accommodation WHERE accommodationID = $temp";
    $queryresult = mysqli_query($cnx, $sql);

    if ($queryresult) {
        $currentrow = mysqli_fetch_assoc($queryresult);
        $price = $currentrow['price_per_night'];
        $totalCost = dateDiffInDays($input['start_date'], $input['end_date']) * $price;
        $input['total_booking_cost'] = $totalCost;
        $input['total_booking_cost'] = filter_var($input['total_booking_cost'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    else{
        $errors[] = "Could not prepare statement";
    }
    mysqli_free_result($queryresult);

    //Retrieve customerID corresponding to the user currently logged into the website
    //Get the user name stored into the session file
    //Get the user ID corresponding to the user name from the customers table
    //Insert the user ID into input[] array in order to be processed later
    $tempuser = $_SESSION['user'];
    $custIDquery = "SELECT customerID from customers WHERE username = \"$tempuser\"";
    $queryResult = mysqli_query($cnx, $custIDquery);
    if($queryResult){
        $currentRow = mysqli_fetch_assoc($queryResult);
        $customerID = $currentRow['customerID'];
        $input['customerID'] = $customerID;
    }
    else{
        $errors[] = "User ID not found";
    }
    mysqli_free_result($queryResult);


    return array ($input, $errors);

}

//Insert into the booking table the sanitized data from the input[] array as collected from user inputs
//Use of bind parameteres and prepared statements for ensuring secured data are inserted into DB
function process_form($input, $cnx){
    $insertQuery = "INSERT INTO booking (accommodationID, customerID, start_date, end_date, num_guests, total_booking_cost, booking_notes) VALUES (?,?,?,?,?,?,?)";
    $usernameQuery = "SELECT username from customers where username = ?";
    if($stmt = mysqli_prepare($cnx, $insertQuery)){
        mysqli_stmt_bind_param($stmt, "iissids", $input['accommodation'], $input['customerID'], $input['start_date'], $input['end_date'], $input['num_guests'], $input['total_booking_cost'], $input['booking_notes']);
        mysqli_stmt_execute($stmt);
        $queryresult = mysqli_stmt_get_result($stmt);
    }
    else {
        $errors[] = "Could not prepare statement";
    }
}

//Function to show errors in a concatenated message
function show_errors($errors){
    $output = "";
    foreach ($errors as $err_mess){
        $output .= $err_mess."<br>"."\n";
    }
    $output .= "Please check the errors and book <a href='bookAccoForm.php'>again</a>.\n";
    return $output;
}

?>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
//redirect the user in the book accommodation page after allowing 5 seconds to view their confirmation
header('refresh: 5; bookAccoForm.php');
?>
