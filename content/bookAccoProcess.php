<?php
    require_once ('dbconn.php');
    $conn = getConnection();

    $accommodationID = 0;
    // Check accommodationID has been passed in and is an integer only
    if(array_key_exists('accommodationID', $_REQUEST )){
        //check accommodationID is int
        $accommodationID = intval($_REQUEST['accommodationID']);
        echo "<p>Accommodation ID: $accommodationID </p>";

        //Retrieve customerID corresponding to the user currently logged into the website
        $tempuser = $_SESSION['user'];
        $custIDquery = "SELECT customerID from customers WHERE username = \"$tempuser\"";
        $queryResult = mysqli_query($conn, $custIDquery);
        if($queryResult){
            $currentRow = mysqli_fetch_assoc($queryResult);
            $customerID = $currentRow['customerID'];
            //echo "<p>$customerID</p>";
        }
        mysqli_free_result($queryResult);
        mysqli_close($conn);
    }
    else {
        echo "<p>Accommodation ID not found</p>";
        echo $_SESSION['user'];
    }
?>