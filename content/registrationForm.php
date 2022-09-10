<?php
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise", "../assets/stylesheets/styles.css");
echo navigationContent(array("home.php" => "Home", "about.html" => "About"));
echo authenticationContent(array("registrationForm.php" => "Register"/*, "signIn.php" => "Sign In"*/));
?>
<div class="registration">
    <form method="post" action="registrationProcess.php" id="regForm">
        <h2>Registration Form</h2>
        <label for="firstname">Firstname: </label><br>
        <input type="text" name="firstname"><br><br>
        <label for="firstname">Surname: </label><br>
        <input type="text" name="surname"><br><br>
        <label for="firstname">Username: </label><br>
        <input type="text" name="username"><br><br>
        <label for="firstname">Password: </label><br>
        <input type="password" name="password"><br><br>
        <label for="firstname">Confirm Password: </label><br>
        <input type="password" name="cpwd"><br><br>
        <button type="submit" class="button">Register</button>
        <!--<input type="submit" value="Register">-->
    </form>
</div>

<?php
echo footerContent();
?>