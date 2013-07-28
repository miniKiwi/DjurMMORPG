<?php
/** @file
 * 
 * Perform login.
 * Checks if provided username/password is valid. If valid, several $_SESSION variables are set
 * to indicate that the user is now "logged in".
 * 
 * $_SESSION -variables used:
 * accesslevel (written)
 * myusername (written)
 * mypassword (written)
 * Username (written)
 * id (written)
 * report
 * 
 * $_POST -variables used:
 * myusername (read)
 * mypassword (read)
 */
if(session_id() == '' || !isset($_POST['myusername']) || !isset($_POST['mypassword']) ) {
	header("Location: index.php");
	exit;
}

// Include necessary files and connect to database:
include_once('classes/clsDatabase.php');
include_once('classes/clsConnect.php');
Connect::openConnection();	// connect to database

// username and password POST'ed here (from main_login.php).
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];

// To protect from MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

// encrypt password
$encrypted_mypassword=md5($mypassword);

// create SQL query and fetch userID and accesslevel based on login/password given by user
$sql = "SELECT ID FROM `".Database::UserList."` WHERE UserName='$myusername' and Password='$encrypted_mypassword'";
$result = mysql_query($sql);

$count = mysql_num_rows($result);
if($count==1) // If result matched $myusername and $mypassword, table row must be 1 row
{
	$row = mysql_fetch_assoc($result);
	$_SESSION['myusername'] = strtolower($myusername);	// why convert to lowercase???
	$_SESSION['mypassword'] = $mypassword;
	$_SESSION['Username'] = strtolower($myusername);	// why convert to lowercase???
	$_SESSION['id'] = $row['ID'];
	header('Location: index.php?location=index');	// reload index.php with GET['location']=index
	exit;
}
else
{
	echo "<p><b>Felaktigt användarnamn och/eller lösenord!</b></p>";
	echo "<p>Glömt lösenord/användarnamn? kontakta administratören för att få nya inloggningsuppgifter.<br>";
}
?>