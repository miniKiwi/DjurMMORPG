<?php
/** @file
 * Page for adding an user to the database.
 * This page is intended to be opened in a separate window (and not inside
 * index.php like most of the other pages).
 * The page holds a HTML-form that POSTs data back to this page when user
 * adds an user. Received POST data is validated and if everything is
 * found to be correct, the user is added to database. A mail with login and
 * password is sent to newly added user.
 *
 * Included functions:
 * none
 *
  * $_GET -variables used:
 * none
 *
 * $_POST -variables used:
 * Submit
 * username
 * firstname
 * lastname
 * password
 */

session_start();	// continue session
?>
<!DOCTYPE html>  
<html lang="sv">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Add user</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<script type="text/javascript" src="libraries/validation.js" ></script>
</head>
<body>
<?php

// Include necessary files and connect to database:
include_once('../classes/clsDatabase.php');
include_once('../classes/clsFunctions.php');
include_once('../classes/clsConnect.php');

Connect::openConnection();

// Make sure variables to be used are empty:
$username = "";
$firstname = "";
$lastname = "";
$password = Functions::generatePassword();	// Generate a new password.

$sql = "SELECT MAX(ID) AS ID FROM ".Database::UserList;
$result = mysql_query($sql);
$nextNum = mysql_result($result, 0, "ID") + 1;

if (isset($_POST['Submit'])) { // Data was POSTed here - add user to database:
	$alert = ""; // Placeholder for error message to user

	
	$username = $_POST['username'];
	if($username == "") {
		$alert .= "Username is empty! ";
	} else {
		$username = strtolower($username);
		$username = Functions::stripAllSlashes($username);
		$username = mysql_real_escape_string($username);
	}

	$password = $_POST['password'];
	if($password == "") {
		$alert .= "Password is empty! ";
	} else {
		$password = Functions::stripAllSlashes($password);
		$password = mysql_real_escape_string($password);
	}

	$firstname = $_POST['firstname'];
	if($firstname == "") {
		$alert .= "First name is empty! ";
	} else {
		$firstname = mysql_real_escape_string(Functions::stripAllSlashes($firstname));
	}

	$lastname = $_POST['lastname'];
	if($lastname == "") {
		$alert .= "Last Name is empty! ";
	} else {
		$lastname= mysql_real_escape_string(Functions::stripAllSlashes($lastname));
	}

	if ($alert != "") { // an error has been detected in the POSTed data
		?><script type="text/javascript">alert("<?php echo $alert;?>");</script>
		<?php // Alert the user (user will not be added to database)
	}
	else { // no error found in POSTed data, go ahead and add user to database
		// Check if username and ID is occupied in database:
		$resultat = mysql_query("SELECT ID FROM `".Database::UserList."` WHERE UserName='$username' ");
		$loginIsOccupied = mysql_num_rows($resultat) > 0;

		if( !$loginIsOccupied ) {
			// add user to user table
			$encrypted_password = md5($password);
			$SQL1 = "
			INSERT INTO ".Database::UserList." (`UserName`, `Password`, `FirstName` , `LastName` )
			VALUES ('$username', '$encrypted_password', '$firstname', '$lastname') ";
			$result1 = mysql_query($SQL1);

		
			if( !$result1 ) {
				Connect::emailAdmin("addUser.php failed to add, mysql query fail:"."\n$result1 -> $SQL1");
			}

			$message = "Hello!

			Du är nu registrerad i Wildlife.
			Byt lösenord efter att du loggat in första gången.
			Användarnamn: $username
			Lösenord: $password

			Gå till http://www.stefanlindh.se/DjurMMORPG/index.php för att logga in.

			Automatiskt mail";
			mail("$username@stefanlindh.se",
				"Wildlife, inloggningsuppgifter", $message,
				'From: "Wildlife" <'.Connect::CONTACT_EMAIL.">\r\n"
				."CC: ".Connect::CONTACT_EMAIL."\r\n"
				."Reply-To: ".Connect::CONTACT_EMAIL);
				
			?>			
			<script type="text/javascript">
				/* Reload parent window and close this window. Some issues
				 * have been reported in certain browsers but we have so
				 * far been unable to duplicate them.
				 */
				opener.location.reload(true);
				self.close();
			</script>
			<?php

		} elseif( $loginIsOccupied ) {
			echo '<script type="text/javascript">alert("Användarnamnet upptaget! Var god försök igen.")</script>';
		} 
	}
} // end: add user to database
mysql_close();


?>

<script type="text/javascript">
	function validateform() {
		var fname = document.getElementById('fname').value;
		var lname = document.getElementById('lname').value;
		var username = document.getElementById('username').value;

		var fail = false;
		var msg = "";

		if( !notEmpty(fname) || !notEmpty(lname) ) {
			fail = true; msg += "Fel! Du måste ange användarens namn.\n";
		}

		if( fail ) {
			alert(msg);
			return false;
		}
		return true;
	}
</script>

<form name="InsertNew" method="post" action="addUser.php?username=<?php echo $username;?>">
<big>Create new user:</big>
<hr align="left" width=50%>
<table>
	<tr>
		<td>Create username</td>
		<td><input type='text' name='username' id="username" value="<?php echo $username;?>"></td>
	</tr>
	<tr>
		<td>Create password</td>
		<td><input type="text" name="password" value="<?php echo $password; ?>"></td>
	</tr>
	
	<tr>
		<td>Create Firstname</td>
		<td><input type='text' name='firstname' id="fname" value="<?php echo $firstname;?>"></td>
	</tr>
	
	<tr>
		<td>Create Lastname</td>
		<td><input type='text' name='lastname' id="lname" value="<?php echo $lastname;?>"></td>
	</tr>
	
	<tr>
		<td colspan="3" align="center">
			<input type="submit" name="Submit" value="Save" onclick="javascript:return validateform();">
		</td>
	</tr>
</table>
</form>

<div style="text-align: center;">
<input type="button" name="Close" value="Close Window"
	title="Not saved to database!"
	onclick="javascript:self.close()">
</div>

</body>
</html>
