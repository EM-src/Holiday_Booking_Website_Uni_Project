<?php
ini_set("session.save_path", "/home/unn_w21050558/sessionData"); //Session save file directory
session_start();                                                 //Continuing or starting session

//Including the contentFunctions.php file where all the HTML text has been incorporated into functions to promote code reuse
require_once('contentFunctions.php');
echo pageStartContent("Travel Wise - Home", "../assets/stylesheets/styles.css");
echo navigationContent(array("index.php" => "Home", "accoListing.php" => "Accommodation Listing", "accoDetails.php" => "Accommodation Details", "bookAccoForm.php" => "Book Accommodation", "myBookings.php" => "Upcoming Bookings", "about.php" => "About"));

//Use check login function to identify whether a session has been set and has the value 'logged-in' in order
//to decide whether to show SignIn/Register links or Logout link
if (check_login()) {
    echo authenticationContent(array("logout.php" => "Logout"));
}
else {
    echo authenticationContent(array("registrationForm.php" => "Register", "signInForm.php" => "Sign In"));
}

?>
    <main>
        <div class="search">
            <h2>Search and book accommodation in one step!</h2>
            <form class="accoSearch" method="post" >
                <input type="text" name="searchTerm" />
                <input type="submit" value="Search..." />
            </form>

            <?php
            require_once('dbconn.php');
            $conn = getConnection();

            //Retrieve user search term, sanitize it and return in table format all matches of the search term (with wildcards appended)
            //when matched with certain columns in the WHERE clause. Display feedback to the user accordingly
            $searchTerm = array_key_exists('searchTerm', $_REQUEST) ? $_REQUEST['searchTerm'] : null;
            if(!empty($searchTerm)){
                $searchTerm = trim($searchTerm);
                $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_SPECIAL_CHARS);
                $searchTerm = "%".$searchTerm."%";
                $searchTerm = htmlspecialchars($searchTerm);

                $searchSQL = "SELECT * FROM accommodation WHERE (accommodation_name LIKE ?) OR (description LIKE ?) OR (country LIKE ?) OR (location LIKE ?)";
                if($stmt = mysqli_prepare($conn, $searchSQL)){
                    mysqli_stmt_bind_param($stmt, "ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                    mysqli_stmt_execute($stmt);
                    $queryresult = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($queryresult) > 0){
                        echo "<table>";
                        echo "<tr><th>Accommodation</th><th>Country</th><th>Location</th><th>Price</th></tr>";
                        while ($currentrow = mysqli_fetch_array($queryresult)) {
                            $ID = $currentrow['accommodationID'];
                            $name = $currentrow['accommodation_name'];
                            $desc = $currentrow['description'];
                            $country = $currentrow['country'];
                            $location = $currentrow['location'];
                            $price = $currentrow['price_per_night'];
                            echo "\n\t<tr><td><a href=\"bookAccoForm.php?accommodationID=$ID\">$name</td><td>$country</td><td>$location</td><td>$price</td>";
                        }
                        echo "</table>";
                    }
                    else{
                        echo "<div>\n<p class=\"displayBox2\">$str Your search terms did not return any results. Please use other search criteria focused on accommodation name, description country or location.</p></div>";
                    }
                }
            }
            else {
                echo "<div>\n<p class=\"displayBox2\">You have not specified any search keywords.</p></div>";
            }
            ?>

        </div>
        <img src="../assets/images/island.png" alt="island"/>
    </main>

<?php
//Insert footer at the end of the page
echo footerContent(array("credits.php" => "Credits", "wrfms.php" => "Wireframes", "securityReport.php" => "Security Report", "features.php" => "Features"));
?>
