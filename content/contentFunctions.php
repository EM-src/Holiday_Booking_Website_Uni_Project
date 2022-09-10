<?php
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
            /*<!--Navigation links for the main functionalities-->
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="accommodationListing.php">Accommodation Listing</a></li>
                    <li><a href="bookAccommodation.html">Book Accommodation</a></li>
                    <li><a href="about.html">About</a></li>
                </ul>
            </nav>

            <!--Sign in and Register links-->
            <div id="logIn">
                <ul>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="signIn.php">Sign In</a></li>
                </ul>
            </div>
        </header>*/
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

function footerContent(){
    $pageEnd = <<< FOOTER
            <footer>
                    <ul>
                        <li><a href="credits.html">Credits</a></li>
                        <li><a href="wrfms.html">Wireframes and Design</a></li>
                        <li><a href="securityReport.html">Security Report</a></li>
                    </ul>
                    <div id="social">
                        <a href="https://www.facebook.com/" target="_blank"> <!--target=”_blank” opens in a new tab-->
                            <img src="../assets/images/fb_icon.png" alt="FB logo"/>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank">
                            <img src="../assets/images/insta_icon.png" alt="insta logo"/>
                        </a>
                        <a href="https://twitter.com/" target="_blank">
                            <img src="../assets/images/twitter_icon.png" alt="twitter logo"/>
                        </a>
                    </div>
            </footer>
        </body>
        </html>
    FOOTER;
    $pageEnd .= "\n";
    return $pageEnd;
}

?>