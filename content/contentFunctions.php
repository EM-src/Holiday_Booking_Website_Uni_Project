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

function footerContent(array $footerLinks){
    $pageEnd = <<< FOOTER
            <footer>
                    <ul>
    FOOTER;
    foreach($footerLinks as $link => $linkText){
        $pageEnd .= "\n<li><a href=\"$link\">$linkText</a></li>";
    }
    
    $pageEnd .= "\n</ul>\n"."<div id=\"social\">\n<a href=\"https://www.facebook.com/\" target=\"_blank\">\n<img src=\"../assets/images/fb_icon.png\" alt=\"FB logo\"/>\n</a>\n<a href=\"https://www.instagram.com/\"target=\"_blank\">\n<img src=\"../assets/images/insta_icon.png\" alt=\"insta logo\"/>\n</a>\n<a href=\"https://twitter.com/\" target=\"_blank\">\n<img src=\"../assets/images/twitter_icon.png\"alt=\"twitter logo\"/>\n</a>\n</div>"."\n</footer>\n</body>\n</html>\n";

    return $pageEnd;
}

function check_login() {
	if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == "true") {
		return true;
	}
	else {
		return false;
	}
}
?>