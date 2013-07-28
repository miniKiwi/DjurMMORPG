<?php
/** @file
 * Change password page.
 * Lets the currently logged in user change password.
 * 
 * $_SESSION -variables used:
 * Username (read)
 * 
 * $_POST -variables used:
 * Submit
 * mypassword
 * newpassword
 * confnewpassword
 * 
 */

// Check login. Every logged in use should be able to change password
if(!isset($_SESSION['Username'])) {
	header("Location: index.php?location=login");	// redirect to login page if user is not logged currently logged in
	exit;
}

// Include necessary files and connect to database
include_once('classes/clsConnect.php');
include_once('classes/clsDatabase.php');

Connect::openConnection(); // connect to database

// Kolla användar-ID, årtal coh veckonr
$user = $_SESSION['Username'];	// get (login) username

$ok = false;	// Flag indicating if page is loaded first time (i.e. user has not provided password change data yet)

if (isset($_POST['Submit']))	// has POST-data been received?
{
	$oldPass= $_POST['mypassword'];
	$newPass = $_POST['newpassword'];
	$newPassConf = $_POST['confnewpassword'];
	$encrypted_mypassword=md5($oldPass); // encrypt password

	// To protect MySQL injection (more detail about MySQL injection)
	$user = stripslashes($user);
	$oldPass= stripslashes($oldPass);
	$user = mysql_real_escape_string($user);
	$oldPass = mysql_real_escape_string($oldPass);

	$sql="SELECT * FROM `".Database::Anstallda."` WHERE Login='$user' and Password='$encrypted_mypassword'";	// get the entry matching the given user/password
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);	// count the number of rows in SQL result
	if($count == 1)	// If result matched $myusername and $mypassword, table row must be exactly 1 row
	{
		if ($newPass == $newPassConf) // new password and new password confirmation must match
		{
			// change password
			$password = md5($newPass);
			$sql="UPDATE `".Database::Anstallda."` SET Password = '$password' WHERE Login = '$user'";
			$result = mysql_query($sql);
			if(mysql_error())	// if something went bad editing the database:
			{
				echo mysql_error();
				echo '<script type="text/javascript">';
				echo 'alert("Någonting gick fel... Var vänlig försök igen.")';
				echo '</script>';
			}
			else	// password successfully changed in database
			{
				$ok= true;	// set flag to prevent user beeing prompted for password change again
				echo "<p>&nbsp</p>";
				echo "Lösenordet bytt!";
				echo "<p>&nbsp</p>";
			}
		}
		else	// new password and new password confirmation did not match
		{
			// alert user with a Javascript alert box
			echo '<script type="text/javascript">';
			echo 'alert("Bekräftelsen av det nya lösenordet misslyckades. Var vänlig försök igen.")';
			echo '</script>';
		}
	}
	else	// no match user/password in database
	{
		// Alert user with a JavaScript alert box
		echo '<script type="text/javascript">';
		echo 'alert("Felaktigt lösenord! Var vänlig försök igen.")';
		echo '</script>';
	}
}
if( !$ok ) {	// will be false first time this page is loaded. If so, display password change input form
?>
	<!-- Display password change input form -->
	<P>&nbsp;<P>	<!-- insert some space -->
	<form name="form1" method="post" action="index.php?location=changePassword">
	<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
		<tr>
			<td colspan="3"><strong>Byte av lösenord</strong></td>
		</tr>
		<tr>
			<td width="200">Nuvarande lösenord</td>
			<td width="6">:</td>
			<td width="250"><input name="mypassword"" type="password" id="mypassword" placeholder="Nuvarande lösenord" autofocus required></td>
		</tr>
		<tr>
			<td>Nytt lösenord</td>
			<td>:</td>
			<td><input name="newpassword" type="password" id="newpassword" placeholder="Nytt lösenord" required></td>
		</tr>
		<tr>
			<td>Bekräfta nytt lösenord</td>
			<td>:</td>
			<td><input name="confnewpassword" type="password" id="confnewpassword" placeholder="Bekräfta nytt lösenord" required></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" class="button" name="Submit" value="Byt l�senord"></td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	</form>
	
	<p style="width: 400px; margin-left: auto; margin-right: auto;">
	Tänk på att välja ett tillräckligt säkert lösenord. För att öka säkerheten,
	välj ett lösenord som är minst åtta tecken långt, med blandade små och
	stora bokstäver, siffror och specialtecken. <br>
	Lösenordet kommer att skickas över okrypterade anslutningar men inte i
	klartext.
	</p>
<?php
}

?>