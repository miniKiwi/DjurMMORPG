<?php
/** @file
 * Page for adding an animal to the database.
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
	<title>Add animal colors</title>
	<link rel="stylesheet" type="text/css" href="../djmmorpg-css.css" >
	<link rel="stylesheet" type="text/css" href="../libraries/jpicker/css/jPicker-1.1.6.css" />
	<link rel="shortcut icon" href="images/favicon.ico">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../libraries/jpicker/jpicker-1.1.6.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript" src="libraries/validation.js"></script>
	
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
$juvenilecolorcode = "";
$juvenilecolorname = "";
$adultcolorcode= "";
$adulcolorname = "";
$genderspecific = "";
$geneticcode = "";

$sql_animalcolors = "SELECT MAX(ID) AS ID FROM ".Database::AnimalColors;
$result_animalcolors = mysql_query($sql_animalcolors);
$nextNum_animalcolors = mysql_result($result_animalcolors, 0, "ID") + 1;

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

	$juvenilecolorcode = $_POST['juvenilecolorcode'];
	
		$juvenilecolorcode = mysql_real_escape_string(Functions::stripAllSlashes($juvenilecolorcode));


	$juvenilecolorname = $_POST['juvenilecolorname'];
	
		$juvenilecolorname = mysql_real_escape_string(Functions::stripAllSlashes($juvenilecolorname));


	$adultcolorcode = $_POST['adultcolorcode'];
	if($adultcolorcode == "") {
		$alert .= "Adult color code is empty! ";
	} else {
		$adultcolorcode = mysql_real_escape_string(Functions::stripAllSlashes($adultcolorcode));
	}
	
	$adultcolorname = $_POST['adultcolorname'];
	if($adultcolorname == "") {
		$alert .= "Adult color name is empty! ";
	} else {
		$adultcolorname = mysql_real_escape_string(Functions::stripAllSlashes($adultcolorname));
	}
	
	$genderspecific = $_POST['genderspecific'];
	if($genderspecific == "") {
		$alert .= "You have not chosen an option for gender! ";
	} else {
		$genderspecific = mysql_real_escape_string(Functions::stripAllSlashes($genderspecific));
	}
	
	$geneticcode = $_POST['geneticcode'];
	if($geneticcode == "") {
		$alert .= "Genetic code is empty! ";
	} else {
		$geneticcode = mysql_real_escape_string(Functions::stripAllSlashes($geneticcode));
	}
	
	if ($alert != "") { // an error has been detected in the POSTed data
		?><script type="text/javascript">alert("<?php echo $alert;?>");</script>
		<?php // Alert the user (user will not be added to database)
	}
	else { // no error found in POSTed data, go ahead and add animal to database
		// Check if username and ID is occupied in database:
	//	$resultat = mysql_query("SELECT ID FROM `".Database::AnimalColors."` WHERE animal_name_list='$animal_name_list' ");
	//	$loginIsOccupied = mysql_num_rows($resultat) > 0;

	//	if( !$loginIsOccupied ) {
			// add user to user table
			$SQL_animalcolors = "
			INSERT INTO ".Database::AnimalColors." (`Animal_Name_Latin`, `JuvenileColorCode`, `JuvenileColorName`, `AdultColorCode`, `AdultColorName`, `GenderSpecific`, `GeneticCode`)
			VALUES ('$animal_name_latin', '$juvenilecolorcode', '$juvenilecolorname', '$adultcolorcode', '$adultcolorname', '$genderspecific', '$geneticcode') ";
			$result_animalcolors = mysql_query($SQL_animalcolors);

		
			
				
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

	//	} elseif( $loginIsOccupied ) {
//			echo '<script type="text/javascript">alert("Animal_Name_Latin! Var god försök igen.")</script>';
//		} 
	}
} // end: add animal to database
mysql_close();


?>

<script type="text/javascript">
	function validateform() {
		var adultcolorcode = document.getElementById('adultcolorcode').value;
		var geneticcode = document.getElementById('geneticcode').value;
		var username = document.getElementById('animal_name_latin').value;

		var fail = false;
		var msg = "";

		if( !notEmpty(adultcolorcode) || !notEmpty(geneticcode) ) {
			fail = true; msg += "Fel! Du måste skriva in adult color code and/or genetic code.\n";
		}

		if( fail ) {
			alert(msg);
			return false;
		}
		return true;
	}
</script>

<!-- pick a color funtion jpicker.js -->
<script type="text/javascript">
		$ (document).ready(
			function ()
			{
				$('#juvenilecolorcode').jPicker({color: {active: '#FFCC00'}, window:{position:{x:'30',y:'center'},expandable: false,liveUpdate: true}});
			});
</script>
<script type="text/javascript">
		$ (document).ready(
			function ()
			{
				$('#adultcolorcode').jPicker({color: {active: '#FFCC00'}, window:{position:{x:'30',y:'center'},expandable: false,liveUpdate: true}});
			});
</script>

<form name="InsertNew" method="post" action="addAnimalColors.php?Animal_Name_Latin=<?php echo $animal_name_latin;?>">
<big>Add animal colors:</big>
	<div class="divTable">
    	<div class="divTableRow">
            <div class="divTableCell">
                Latin Name
            </div>
            <div class="divTableCell">
				&#160;&#160;&#160;Amount of rows
            </div>
	</div>
	<div class="divTableRow">
            <div class="divTableCell">
				<input type='text' name='animal_name_latin' id="animal_name_latin" placeholder="Animal_Name_Latin" autofocus required value="<?php echo $animal_name_latin;?>">
            </div>
            <div class="divTableCellSpaced">
                	<select>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				
			</select>
            </div>
		</div>
	</div>
	<br>
	<div class="divTable">
		<div class="divTableRow">
			<div class="divTableCellHeader">
				<center>GENDER</center>
			</div>
			<div class="divTableCellHeader">
				JUVENILE COLOR CODE
			</div>
			<div class="divTableCellHeader">
				JUVENILE COLOR NAME
			</div>
			<div class="divTableCellHeader">
				ADULT COLOR CODE
			</div>
			<div class="divTableCellHeader">
				ADULT COLOR NAME
			</div>
			<div class="divTableCellHeader">
				GENETIC CODE
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCellSpaced">
				<select name="genderspecific" id="genderspecific">
					<option>Both</option>
					<option>Male</option>
					<option>Female</option>
					value="<?php echo $genderspecific;?>"
				</select>
			</div>
			<div class="divTableCell">
				<input type="text" name="juvenilecolorcode" id="juvenilecolorcode" placeholder="" value="<?php echo $juvenilecolorcode;?>">
			</div>
			<div class="divTableCell">
				<input type="text" name="juvenilecolorname" id="juvenilecolorname" placeholder="" value="<?php echo $juvenilecolorname;?>">
			</div>
			<div class="divTableCell">
				<input type="text" name="adultcolorcode" id="adultcolorcode" placeholder="" required value="<?php echo $adultcolorcode;?>">
			</div>
			<div class="divTableCell">
				<input type="text" name="adultcolorname" id="adultcolorname" placeholder="Color name" required value="<?php echo $adultcolorname;?>">
			</div>
			<div class="divTableCell">
				<input type="text" name="geneticcode" id="geneticcode" placeholder="Genetic Code" required value="<?php echo $geneticcode;?>">
			</div>
		</div>
		<center>
			<input type="submit" name="Submit" class="button" value="Spara" onclick="javascript:return validateform();">
		</center>
	</div>

	<br>
	
</form>
</body>
</html>
