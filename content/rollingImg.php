<?php

$i=rand(1,5);
	switch($i)
	{	    case 1:
			$greet2 ="../assets/images/fb_icon.png";
			break;
			case 2:
			$greet2 ="../assets/images/insta_icon.png";
			break;
			case 3:
			$greet2 ="../assets/images/parthenon.jpg";
			break;
			/*case 4:
			$greet2 ="../assets/images/logo.png";
			break;
			case 5:
			$greet2 ="../assets/images/logo2.png";*/
	}	
 echo" <img src='$greet2' height='300' width='300'>";
header("Refresh:10");
?>