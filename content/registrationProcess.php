<?php
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Register", "../assets/stylesheets/styles.css");
echo navigationContent(array("home.php" => "Home", "about.html" => "About"));
echo authenticationContent(array("registrationForm.php" => "Register"));

list($input, $errors) = validate_form();
if ($errors) {
    echo "<div class=\"registration\">\n<p class=\"errors\">\n".show_errors($errors)."</p>\n</div>";
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
        if(preg_match('/[[:punct:]]/', $input['firstname'])){
            $errors[] = "Error! Your first name must not contain any special characters.";
        }
    }
    else{
        $errors[] = "Error! Your first name is empty.";
    }

    $input['surname'] = array_key_exists('surname', $_REQUEST) ? $_REQUEST['surname'] : null;
    $input['surname'] = trim($input['surname']);
    if(!empty($input['surname'])){
        if(preg_match('/[[:punct:]]/', $input['surname'])){
            $errors[] = "Error! Your surname must not contain any special characters.";
        }
    }
    else{
        $errors[] = "Error! Your surname is empty.";
    }

    $input['address1'] = array_key_exists('address1', $_REQUEST) ? $_REQUEST['address1'] : null;
    $input['address1'] = trim($input['address1']);
    if(!empty($input['address1'])){
        if(!preg_match('/^[a-zA-Z]+\s[0-9]{1,3}/', $input['address1'])){
            $errors[] = "Error! Your Address must start with the street name follwed by space and the number.";
        }
    }
    else{
        $errors[] = "Error! Your Address 1 field is empty.";
    }

    $input['address2'] = array_key_exists('address2', $_REQUEST) ? $_REQUEST['address2'] : null;
    $input['address2'] = trim($input['address2']);
    if(!empty($input['address2'])){
        if(!preg_match('/([a-zA-Z]|[0-9]{1,3})/', $input['address2'])){
            $errors[] = "Error! Your Address 2 field should only contain letters or up to 3 numbers.";
        }
    }

    $input['postcode'] = array_key_exists('postcode', $_REQUEST) ? $_REQUEST['postcode'] : null;
    $input['postcode'] = trim($input['postcode']);
    if(!empty($input['postcode'])){
        if(!preg_match('/([a-zA-Z]+|[0-9]+)/', $input['postcode'])){
            $errors[] = "Error! The postcode must consist of numbers and/or letters.";
        }
    }
    else{
        $errors[] = "Error! Your post code is empty.";
    }
    
    $input['dob'] = array_key_exists('dob', $_REQUEST) ? $_REQUEST['dob'] : null;
    $input['dob'] = trim($input['dob']);
    if(!empty($input['dob'])){
        if(!preg_match('/^(19|20)\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $input['dob'])){
            $errors[] = "Error! Your date of birth must have format yyyy/mm/dd and year must start with either 19 or 20.";
        }
    }
    else{
        $errors[] = "Error! Your date of birth is empty.";
    }

    $input['username'] = array_key_exists('username', $_REQUEST) ? $_REQUEST['username'] : null;
    $input['username'] = trim($input['username']);
    if(!empty($input['username'])){
        if((mb_strlen($input['username']) < 6 || mb_strlen($input['username']) > 50)){
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
            if(!preg_match('/(?=.*[a-zA-Z])(?=.*\d)(?=.*[!%@#&*+_-])/', $input['password']))
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
            echo "User name entered not unique.";
        }
        else {
            if($stmt = mysqli_prepare($conn, $insertQuery)){
                mysqli_stmt_bind_param($stmt, "ssssssss", $input['address1'], $input['address2'], $input['firstname'], $input['postcode'], $input['surname'], $input['dob'], $input['password'], $input['username']);
                mysqli_stmt_execute($stmt);
                $queryresult = mysqli_stmt_get_result($stmt);
                echo "<body>User account successfully created.</body>";
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
    $output .= "Please try <a href='RegistrationForm.php'>again</a>, or click Register on the top right corner.\n";
    return $output;
}
?>

<?php
echo footerContent();
?>