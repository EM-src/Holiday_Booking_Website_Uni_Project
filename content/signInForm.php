<?php
require_once('contentFunctions.php');

echo pageStartContent("Travel Wise - Sign In", "../assets/stylesheets/styles.css");
echo navigationContent(array("home.php" => "Home", "about.html" => "About"));
echo authenticationContent(array("SignInForm.php" => "Sign In"));
?>
<div class="signIn">
    <form method="post" action="SignInProcess.php" id="siForm">
        <label class="col1" for="username">User Name: 
            <input type="text" name="username">
        </label>
        <label class="col1" for="password">Password: 
            <input type="password" name="password">
        </label>
        <button type="submit" class="button">Sign In</button>
    </form>
</div>

<?php
echo footerContent();
?>