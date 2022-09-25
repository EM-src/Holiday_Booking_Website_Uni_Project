<?php
ini_set("session.save_path", "/Applications/XAMPP/xamppfiles/sessionData"); //Session save file directory
session_start();                                                            //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Credits", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link.
//Additionally since this is a restricted page, a relevant message and a Sign In redirection link will be shown to
//unauthorized users. The exit() php function is used to end the script in case of an unauthorized access attempt so the HTML part will not be shown
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
    echo "<div class=\"restricted\">\n<p class=\"displayBox\">\nYou need to be logged in to access this page. Please use the <a href=\"signInForm.php\">Sign In</a> form to login.</p>\n</div>\n";
    echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
    exit();
}
?>

<!-- Ordered list of the references of assets and code used for PE7045 practical part -->
<div class="credits">
    <h2>References</h2>
    <h3>Image Credits</h3>
    <ol>
        <li>Unsplash.com. 2022. Photo by Hello Lightbulb on Unsplash. [online] Available at: https://unsplash.com/photos/YC8qqp50BdA</li>
        <li>Unsplash.com. 2022. Photo by Constantinos Kollias on Unsplash. [online] Available at: https://unsplash.com/photos/yqBvJJ8jGBQ</li>
        <li>Unsplash.com. 2022. Photo by Parsa Farjam on Unsplash. [online] Available at: https://unsplash.com/photos/jmlHMkus6UA</li>
        <li>Unsplash.com. 2022. Photo by Venti Views on Unsplash. [online] Available at: https://unsplash.com/photos/VZOPQBME6L4</li>
        <li>Unsplash.com. 2022. Photo by visualsofdana on Unsplash. [online] Available at: https://unsplash.com/photos/T5pL6ciEn-I</li>
        <li>Unsplash.com. 2022. Photo by John Matychuk on Unsplash. [online] Available at: https://unsplash.com/photos/Af8ZjGMsHKQ</li>
        <li>Unsplash.com. 2022. Photo by Kyle Glenn on Unsplash. [online] Available at: https://unsplash.com/photos/dGk-qYBk4OA</li>
        <li>Unsplash.com. 2022. Photo by Tony Yakovlenko on Unsplash. [online] Available at: https://unsplash.com/photos/lDxxeAJrWpE</li>
        <li>Editor.freelogodesign.org. 2022. Logo Creator - Make a logo with Free Logo Design. [online] Available at: https://editor.freelogodesign.org/en/logo/edit/119be7de16e34a32853ad0d800b15e6e?template=15f42bfc9b184531b748499eb6f032c6</li>
        <li>Mr, H., 2022. Instagram, social media, social icon - Free download. [online] Iconfinder. Available at: https://www.iconfinder.com/icons/2609558/instagram_social_media_social_icon</li>
        <li>Mr, H., 2022. Facebook, media, social icon - Free download on Iconfinder. [online] Iconfinder. Available at: https://www.iconfinder.com/icons/2609541/facebook_media_social_icon</li>
        <li>Mr, H., 2022. Media, social, twitter icon - Free download on Iconfinder. [online] Iconfinder. Available at: https://www.iconfinder.com/icons/2609552/media_social_twitter_icon</li>        
    </ol>
<h3>Code credits</h3>
    <ol>
        <li>Border?, C., Tackmann, L., Filho, N. and Thomas, D., 2022. CSS Font Border?. [online] Stack Overflow. Available at: https://stackoverflow.com/questions/2570972/css-font-border</li>
        <li>MacLochlainns Weblog. 2022. PHP Binding a Wildcard. [online] Available at: https://blog.mclaughlinsoftware.com/2010/02/21/php-binding-a-wildcard/</li>
        <li>W3schools.com. 2022. HTML Iframes. [online] Available at: https://www.w3schools.com/html/html_iframe.asp</li>
    </ol>
</div>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>