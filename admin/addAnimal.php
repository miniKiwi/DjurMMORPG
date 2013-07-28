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
 * animal_name-latin
 * ListWord
 * ContentText
 */

session_start();	// continue session
?>
<!DOCTYPE html>  
<html lang="sv">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Add animal</title>
	<link rel="stylesheet" type="text/css" href="../djmmorpg-css.css" >
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
$animal_name_latin = "";
$listword = "";
$contenttext = "";

$sql = "SELECT MAX(ID) AS ID FROM ".Database::ToC;
$result = mysql_query($sql);
$nextNum = mysql_result($result, 0, "ID") + 1;

if (isset($_POST['Submit'])) { // Data was POSTed here - add animal to database:
	$alert = ""; // Placeholder for error message to user

	
	$animal_name_latin = $_POST['animal_name_latin'];
	if($animal_name_latin == "") {
		$alert .= "animal_name_latin is empty! ";
	} else {
		//$animal_name_latin = strtolower($animal_name_latin);
		$animal_name_latin = Functions::stripAllSlashes($animal_name_latin);
		$animal_name_latin = mysql_real_escape_string($animal_name_latin);
	}

	$listword = $_POST['listword'];
	if($listword == "") {
		$alert .= "ListWord is empty! ";
	} else {
		$listword = mysql_real_escape_string(Functions::stripAllSlashes($listword));
	}

	$contenttext = $_POST['contenttext'];
	if($contenttext == "") {
		$alert .= "contenttext is empty! ";
	} else {
		$contenttext= mysql_real_escape_string(Functions::stripAllSlashes($contenttext));
	}

	if ($alert != "") { // an error has been detected in the POSTed data
		?><script type="text/javascript">alert("<?php echo $alert;?>");</script>
		<?php // Alert the user (user will not be added to database)
	}
	else { // no error found in POSTed data, go ahead and add animal to database
		// Check if username and ID is occupied in database:
		$resultat = mysql_query("SELECT ID FROM `".Database::ToC."` WHERE animal_name_list='$animal_name_list' ");
		$loginIsOccupied = mysql_num_rows($resultat) > 0;

		if( !$loginIsOccupied ) {
			// add user to user table
			$SQL1 = "
			INSERT INTO ".Database::ToC." (`Animal_Name_Latin`, `ListWord`, `ContentText`)
			VALUES ('$animal_name_latin', '$listword', '$contenttext') ";
			$result1 = mysql_query($SQL1);

		
			
				
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
			echo '<script type="text/javascript">alert("Animal_Name_Latin! Var god försök igen.")</script>';
		} 
	}
} // end: add animal to database
mysql_close();


?>

<script type="text/javascript">
	function validateform() {
		var fname = document.getElementById('listword').value;
		var lname = document.getElementById('contenttext').value;
		var username = document.getElementById('animal_name_latin').value;

		var fail = false;
		var msg = "";

		if( !notEmpty(listword) || !notEmpty(contenttext) ) {
			fail = true; msg += "Fel! Du måste skriva in ListWord och/eller ContentText.\n";
		}

		if( fail ) {
			alert(msg);
			return false;
		}
		return true;
	}
</script>

<form name="InsertNew" method="post" action="addAnimal.php?Animal_Name_Latin=<?php echo $animal_name_latin;?>">
<big>Create new animal:</big>
	<div class="divTable">
    	<div class="divTableRow">
            <div class="divTableCell">
                Create Animal
            </div>
            <div class="divTableCell">
				Create ListWord
            </div>
		</div>
		<div class="divTableRow">
            <div class="divTableCell">
				<input type='text' name='animal_name_latin' id="animal_name_latin" placeholder="Animal_Name_Latin" autofocus required value="<?php echo $animal_name_latin;?>">
            </div>
            <div class="divTableCell">
                <input type="text" name="listword" id="listword" placeholder="ListWord" required value="<?php echo $listword; ?>">
            </div>
		</div>
	</div>	
	<br>
	<div class="divTable">
		<div class="divTableRow">
			<div class="divTableCell">
				Create ContentText
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
				<textarea rows="8" cols="100" name="contenttext" id="contenttext" align="left" placeholder="ContentText" required value="<?php echo $contenttext;?>"></textarea>
			</div>
		</div>
		<input type="submit" name="Submit" class="button" value="Spara" onclick="javascript:return validateform();">
	</div>
	
	<br>
	
</form>
</body>
</html>
