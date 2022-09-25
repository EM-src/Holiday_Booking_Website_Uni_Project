<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData"); //Session save file directory
session_start();                                                            //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once 'contentFunctions.php';
//Include file for connection to DB
require_once 'dbconn.php';

list($input, $errors) = validate_logon(); 
if ($errors) {
  //If there are errors set the page content and display the errors that were identified during the processing of the sign in form
  echo pageStartContent("Travel Wise - Sign In", "../assets/stylesheets/styles.css");
  echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));
  if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
  }
  else {
    echo authenticationContent(array("SignInForm.php" => "Sign In"));
  }

  echo show_errors($errors);
  echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
}
else {
  //If there are no errors set the page content also define teh session values so the user can be identified during their HTTP requests
  //to the server and display a successfully logged in message
  $_SESSION['logged-in'] = "true";
  $_SESSION['user'] = $input['username'];
  echo pageStartContent("Travel Wise - Sign In", "../assets/stylesheets/styles.css");
  echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));
  if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
  }
  else {
    echo authenticationContent(array("SignInForm.php" => "Sign In"));
  }

  echo "<div class=\"signIn\">\n<p class=\"displayBox\">\nLogon success! You now have access on all website content,<br>please use the navigation menu to find out more!</p>\n</div>";
  echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
}

function validate_logon(){
  $input = array();
  $errors = array();

  $input['username'] = array_key_exists('username', $_REQUEST) ? $_REQUEST['username'] : null;
  $input['username'] = filter_var($input['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
  $input['username'] = trim($input['username']);
  $input['password'] = array_key_exists('password', $_REQUEST) ? $_REQUEST['password'] : null;
  $input['password'] = filter_var($input['password'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); //1st step remove tags to prevent XSS attack
  $input['password'] = trim($input['password']);

  if (empty($input['username']) || empty($input['password'])) {
		$errors[] = "You need to provide a username and a password.";
	}
	else {
		//Clear any session setting that might be left from a previous session
		unset($_SESSION['logged-in']);
    unset($_SESSION['user']);

    //define the connection variable
    $conn = getConnection();

    //Retrieve the password hash in the DB for the username entered in the sign in form
    //Check that it matches the password given with the password_verify() function
    //Depending on outcome display the appropriate message but without telling the user
    //where the mismatch was in case of error for security reasons
    $query = "SELECT password_hash FROM customers WHERE username = ?";
    if($stmt = mysqli_prepare($conn, $query)){
      mysqli_stmt_bind_param($stmt, "s", $input['username']);
      mysqli_stmt_execute($stmt);
      $queryresult = mysqli_stmt_get_result($stmt);
      if($queryresult){
        $userRow = mysqli_fetch_assoc($queryresult);
          if($userRow){
            $password_hash = $userRow['password_hash'];
            if(password_verify($input['password'], $password_hash)){
              $_SESSION['logged-in'] = "true";
              $_SESSION['user'] = $input['username'];
            }
            else {
              $errors[] = "Username and/or password were incorrect.";
            }
          }
          else {
            $errors[] = "Username and/or password were incorrect.";
          }
        }
    }
    else {
      $errors[] = "Could not prepare statement";
    }
}

  return array ($input, $errors);
  mysqli_close($conn);
}

function show_errors($errors){
  $output = "";
  $output_temp = "";
  foreach($errors as $err){
    $output_temp .= $err."<br>";
  }
  $output .= "<div class=\"signIn\">\n<p class=\"displayBox\">\n".$output_temp."Please try <a href='signInForm.php'>again</a>, or click Sign In on the top right corner.\n</p>\n</div>";
  return $output;
}
?>