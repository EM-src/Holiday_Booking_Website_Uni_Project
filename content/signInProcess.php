<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData");
session_start();

require_once 'contentFunctions.php';

list($input, $errors) = validate_logon(); 
if ($errors) {
  echo show_errors($errors); }
else {
  $_SESSION['logged-in'] = true;
  //echo "<p>Logon success!</p>\n";
  //echo "<a href='restricted.php'>Restricted page</a>\n";
  echo pageStartContent("Travel Wise - Register", "../assets/stylesheets/styles.css");
  echo navigationContent(array("home.php" => "Home", "about.html" => "About"));
  echo authenticationContent(array("registrationForm.php" => "Register"));
  echo "<div class=\"registration\">\n<p class=\"errors\">\nLogon success!</p>\n</div>";
  echo footerContent();
  }

function validate_logon(){
  $input = array();
  $errors = array();

  $input['username'] = array_key_exists('username', $_REQUEST) ? $_REQUEST['username'] : null;
  $input['username'] = trim($input['username']);
  $input['password'] = array_key_exists('password', $_REQUEST) ? $_REQUEST['password'] : null;
  $input['password'] = trim($input['password']);

    require_once 'dbconn.php';
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
              $_SESSION['logged-in'] = true;
              //echo "Successfully loged in."."<br>";
              //echo "<a href = \"restricted.php\">Redirection link</a>";
            }
            else {
              $errors[] = "Username and/or password were incorrect. (1)";
            }
          }
          else {
            $errors[] = "Username and/or password were incorrect. (2)";
          }
        }
    }
    else {
      $errors[] = "Could not prepare statement";
    }

    return array ($input, $errors);
  }

  function show_errors($errors){
    $output = "";
    foreach($errors as $err){
      $output .= $err."<br>";
    }
  $output .= "Please try <a href='signInForm.html'>again</a>, or click Register on the top right corner.\n";
  return $output;
}
?>

<!--<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>WS T1 Week8</title>
</head>
<body>
</body>
</html>-->