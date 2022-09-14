<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();

require_once 'contentFunctions.php';
require_once 'dbconn.php';

list($input, $errors) = validate_logon(); 
if ($errors) {
  echo pageStartContent("Travel Wise - Sign In", "../assets/stylesheets/styles.css");
  echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "about.html" => "About"));
  //echo authenticationContent(array("signInForm.php" => "Sign In"));
  if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
  }
  else {
    echo authenticationContent(array("SignInForm.php" => "Sign In"));
  }

  echo show_errors($errors);
  echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
}
else {
  $_SESSION['logged-in'] = "true";
  $_SESSION['user'] = $input['username'];
  echo pageStartContent("Travel Wise - Register", "../assets/stylesheets/styles.css");
  echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "bookAccoForm.php" => "Book Accommodation", "about.html" => "About"));
  //echo authenticationContent(array("registrationForm.php" => "Register"));
  if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));    
  }
  else {
    echo authenticationContent(array("SignInForm.php" => "Sign In"));
  }

  echo "<div class=\"signIn\">\n<p class=\"displayBox\">\nLogon success! You now have access on all website content,<br>please use the navigation menu to find out more!</p>\n</div>";
  echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.html" => "Security Report"));
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
		// Clear any session setting that might be left from a previous session
		unset($_SESSION['logged-in']);
    unset($_SESSION['user']);

    //require_once 'dbconn.php';
    $conn = getConnection();

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