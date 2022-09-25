<?php
//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Register", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));
echo authenticationContent(array("registrationForm.php" => "Register"));

//Retrieve the arrays defined and populated by validate_form() function and display the output accordingly.
//Either the errors in case any were found or a successfully registered user who then will be redirected in the sign in form
list($input, $errors) = validate_form();
if ($errors) {
    echo "<div class=\"registration\">\n<p class=\"displayBox\">\n".show_errors($errors)."</p>\n</div>\n";
}
else {
    echo process_form($input);
}
?>

<?php
function validate_form(){
    $input = array();
    $errors = array();

    $input['firstname'] = array_key_exists('firstname', $_REQUEST) ? $_REQUEST['firstname'] : null;
    $input['firstname'] = trim($input['firstname']);
    if(!empty($input['firstname'])){
        $input['firstname'] = filter_var($input['firstname'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if(preg_match('/[[:punct:]]/', $input['firstname'])){ //2nd step remove any special characters
            $errors[] = "Error! Your first name must not contain any special characters.";
        }
    }
    else{
        $errors[] = "Error! Your first name is empty.";
    }

    $input['surname'] = array_key_exists('surname', $_REQUEST) ? $_REQUEST['surname'] : null;
    $input['surname'] = trim($input['surname']);
    if(!empty($input['surname'])){
        $input['surname'] = filter_var($input['surname'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if(preg_match('/[[:punct:]]/', $input['surname'])){ //2nd step remove any special characters
            $errors[] = "Error! Your surname must not contain any special characters.";
        }
    }
    else{
        $errors[] = "Error! Your surname is empty.";
    }

    $input['address1'] = array_key_exists('address1', $_REQUEST) ? $_REQUEST['address1'] : null;
    $input['address1'] = trim($input['address1']);
    if(!empty($input['address1'])){
        $input['address1'] = filter_var($input['address1'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        $input['address1'] = filter_var($input['address1'], FILTER_SANITIZE_SPECIAL_CHARS); //2nd step remove special chars
        if(!preg_match('/^[a-zA-Z]+\s[0-9]{1,3}/', $input['address1'])){ //3rd step make sure address start with one or more letters followed by 1-3 numbers
            $errors[] = "Error! Your Address must start with the street name follwed by space and the number.";
        }
    }
    else{
        $errors[] = "Error! Your Address 1 field is empty.";
    }

    $input['address2'] = array_key_exists('address2', $_REQUEST) ? $_REQUEST['address2'] : null;
    $input['address2'] = trim($input['address2']);
    if(!empty($input['address2'])){
        $input['address2'] = filter_var($input['address2'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        $input['address2'] = filter_var($input['address2'], FILTER_SANITIZE_SPECIAL_CHARS); //2nd step escape special chars
        if(!preg_match('/([a-zA-Z]|[0-9]{1,3})/', $input['address2'])){ //3rd step make sure address 2 field is more like a free text area
            $errors[] = "Error! Check again your input.";
        }
    }

    $input['postcode'] = array_key_exists('postcode', $_REQUEST) ? $_REQUEST['postcode'] : null;
    $input['postcode'] = trim($input['postcode']);
    if(!empty($input['postcode'])){
        $input['postcode'] = filter_var($input['postcode'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        $input['postcode'] = filter_var($input['postcode'], FILTER_SANITIZE_SPECIAL_CHARS); //2nd step escape special chars
        if(!preg_match('/([a-zA-Z]+|[0-9]+)/', $input['postcode'])){ //3rd step make sure postcode consists of letters followed by numbers
            $errors[] = "Error! The postcode must consist of numbers and/or letters.";
        }
    }
    else{
        $errors[] = "Error! Your post code is empty.";
    }
    
    $input['dob'] = array_key_exists('dob', $_REQUEST) ? $_REQUEST['dob'] : null;
    $input['dob'] = trim($input['dob']);
    if(!empty($input['dob'])){
        $input['dob'] = filter_var($input['dob'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if(!preg_match('/^(19|20)\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $input['dob'])){//2nd step define the date format needed by the user
            $errors[] = "Error! Your date of birth must have format yyyy/mm/dd and year must start with either 19 or 20.";
        }
    }
    else{
        $errors[] = "Error! Your date of birth is empty.";
    }

    $input['username'] = array_key_exists('username', $_REQUEST) ? $_REQUEST['username'] : null;
    $input['username'] = trim($input['username']);
    if(!empty($input['username'])){
        $input['username'] = filter_var($input['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if((mb_strlen($input['username']) < 6 || mb_strlen($input['username']) > 50)){ //2nd step for security the username has to be between 6 and 50 chars
            $errors[] = "Error! Your user name must be between 6 and 50 characters.";
        }
    }
    else{
        $errors[] = "Error! Your username is empty.";
    }

    $input['password'] = array_key_exists('password', $_REQUEST) ? $_REQUEST['password'] : null;
    $input['password'] = trim($input['password']);
    if(!empty($input['password'])){
        if((mb_strlen($input['password']) > 7)){
            $input['password'] = filter_var($input['password'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
            if(!preg_match('/(?=.*[a-zA-Z])(?=.*\d)(?=.*[!%@#&*+_-])/', $input['password'])) //2nd step password must contain only selected special chars and must contain letters and numbers
            $errors[] = "Error! Your password must contain at least one of the following special characters 
                        '%', '!', '#', '+', '*', '$', '@', '&', '_', '-', at least one number and one letter.";
        } 
        else{
            $errors[] = "Error! Your password must be at least 8 characters.";
        }
    }
    else{
        $errors[] = "Error! Your password is empty.";
    }

    $input['cpwd'] = array_key_exists('cpwd', $_REQUEST) ? $_REQUEST['cpwd'] : null;
    if(!empty($input['cpwd'])){
        $input['cpwd'] = filter_var($input['cpwd'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
        if(!($input['cpwd'] == $input['password'])){
            $errors[] = "Error! Your password confirmation did not match the password set previously.";
        }
        else {
            $option = ['cost' => 12];
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT, $option);
        }
    }
    else{
        $errors[] = "Error! Your confirmation password is empty.";
    }

    return array ($input, $errors);
}

//If the inserted username does not already exist in DB then insert the newly registered user
function process_form($input){
    require_once ('dbconn.php');
    $conn = getConnection();
    $insertQuery = "INSERT INTO customers (customer_address1, customer_address2, customer_forename, customer_postcode, customer_surname, date_of_birth, password_hash, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $usernameQuery = "SELECT username from customers where username = ?";
    if($stmt = mysqli_prepare($conn, $usernameQuery)){
        mysqli_stmt_bind_param($stmt, "s", $input['username']);
        mysqli_stmt_execute($stmt);
        $queryresult = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($queryresult) > 0){
            echo "<div class=\"registration\">\n<p class=\"displayBox\">\nUser name entered not unique. Kindly <a href=\"registrationForm.php\">Register</a> again</p>\n</div>\n";
        }
        else {
            if($stmt = mysqli_prepare($conn, $insertQuery)){
                mysqli_stmt_bind_param($stmt, "ssssssss", $input['address1'], $input['address2'], $input['firstname'], $input['postcode'], $input['surname'], $input['dob'], $input['password'], $input['username']);
                mysqli_stmt_execute($stmt);
                header('Location: signInForm.php');
            }
        }
    }
    else {
        echo "Could not prepare statement";
    }
    mysqli_close($conn);
}

function show_errors($errors){
    $output = "";
    foreach ($errors as $err_mess){
        $output .= $err_mess."<br>"."\n";
    }
    $output .= "Please try <a href='registrationForm.php'>again</a>, or click Register on the top right corner.\n";
    return $output;
}
?>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>