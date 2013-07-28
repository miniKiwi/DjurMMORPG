<?php
/** @file
 * Main HTTP file.
 * Displays the HTTP page and fills it with content depending on $_GET['location'].
 *
 * $_SESSION -variables used:
 * Username (read)
 *
 * $_GET -variables used:
 * location
 * user
 */

ob_start();
session_start();	// start a new session to track data (or continue exisiting)

// This is the URL of this page
$page_url = 'http://www.stefanlindh.se/DjurMMORPG/index.php';  // TODO: hard coded url, need to be changed and saved in config-file.
ini_set('display_errors', 1);	// DEBUG: Show error messages
error_reporting(E_ALL);	// DEBUG: shows all error messages

// Set proper 'location' used in function changelocation
if ( !isset($_SESSION['Username']) )	// Not logged in
{
	if ( isset($_GET['location']) )		// GET['location'] is given (probably means user is currently logging in and trying to reach check_login)
		$location = $_GET['location'];
	else
		$location = 'login';			// go to login
}
elseif ( !isset($_GET['location']) ) {	// no GET['location'] given, but Username set (i.e. user with an active session tried to reach index.php for some reason)
	$location = 'index';				// will show welcome page
} else {
	$location=$_GET['location'];		// otherwise, location is give from GET['location']
}

$errMsg = isset($_GET['error']) ? $_GET['error'] : null;


// Set some headers
header("Cache-control: no-cache, must-revalidate");
header("Content-language: se");
header("Link: <$page_url?location=index>; rel=\"previous\"; title=\"UTF-8'se'Inloggad\"");

?>

<!DOCTYPE html>  
<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!-- mobile settings -->
	<link rel="stylesheet" type="text/css" href="djmmorpg-css.css" >
	<link rel="stylesheet" type="text/css" href="print.css" media="print" >
	<link rel="shortcut icon" href="images/favicon.ico" >
	<title>WildLife</title>
</head>
<body>

<!-- page structure -->
<div id="pageContainer">
		<header id="pageHeader">		
			<?php include ('header.php'); ?>
		</header>
		
		<div id="pageContent">
						
			<?php changelocation($location); /* When function changelocation is called, new content is included here */ ?>
		
		</div>
		
		<footer id="pageFooter">
			<div class="no_print">
				<?php include ('footer.php'); ?>
			</div>
	
			<?php if( !is_null($errMsg) ) { ?>
				<div style="float: center;" tr class="no_print">			
					<?php echo $errMsg; ?>
				</div>
			<?php } ?>
		</footer>
</div>

</body>
</html>

<?php
// Choose what to display in the content area, depending on $location
function changelocation($location) {
	switch ($location) {
		case 'login':
			include ('main_login.php');
			break;
		case 'logout':
			include ('logout.php');
			break;
		case 'checkLogin':
			include ('check_login.php');
			break;
		case 'changePassword':
			include ('changePassword.php');
			break;
		case 'index':
			include ('mainpage.php');
			break;
		case 'showAnimalListTable':
			include ('showAnimalListTable.php');
			break;
		case 'places':
			include ('places.php');
			break;
		case 'africa':
			include ('animalchart/africa.php');
			break;
		case 'africaDesert':
			include ('animalchart/africaDesert.php');
			break;
		case 'NorthAmerica':
			include ('animalchart/NorthAmerica.php');
			break;
		case 'SouthAmericaRainforest':
			include ('animalchart/SouthAmericaRainforest.php');
			break;
		
	default:	// should never be reached unless user delibertely typed an undefined location in browser address field...
			echo("<p> INVALID LOCATION '$location'</p>");
			include 'mainpage.php';
	}
}
?>