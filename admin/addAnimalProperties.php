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
	<title>Add animal properties</title>
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
$lifespan = "";
$size = "";
$weight = "";
$devour = "";
$devourcomment = "";
$circadian = "";
$circardiancomment = "";
$namesynonyms = "";

$sql_animalproperties = "SELECT MAX(ID) AS ID FROM ".Database::AnimalProperties;
$result_animalproperties = mysql_query($sql_animalproperties);
$nextNum_animalproperties = mysql_result($result_animalproperties, 0, "ID") + 1;

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

	$lifespan = $_POST['lifespan'];
	if($lifespan == "") {
		$alert .= "lifespan is empty! ";
	} else {
		$lifespan= mysql_real_escape_string(Functions::stripAllSlashes($lifespan));
	}

	$size = $_POST['size'];
	if($size == "") {
		$alert .= "size is empty! ";
	} else {
		$size= mysql_real_escape_string(Functions::stripAllSlashes($size));
	}

	$weight = $_POST['weight'];
	if($weight == "") {
		$alert .= "weight is empty! ";
	} else {
		$weight= mysql_real_escape_string(Functions::stripAllSlashes($weight));
	}

	$devour = $_POST['devour'];
	if($devour == "") {
		$alert .= "you haven't specified what the animal eats! ";
	} else {
		$devour= mysql_real_escape_string(Functions::stripAllSlashes($devour));
	}
	
	$devourcomment = $_POST['devourcomment'];
	if($devourcomment == "") {
		$alert .= "you haven't written a comment about what the animal eats! ";
	} else {
		$devourcomment= mysql_real_escape_string(Functions::stripAllSlashes($devourcomment));
	}

	$circadian = $_POST['circadian'];
	if($circadian == "") {
		$alert .= "circadian is empty! ";
	} else {
		$circadian= mysql_real_escape_string(Functions::stripAllSlashes($circadian));
	}

	$circadiancomment = $_POST['circadiancomment'];
	if($circadiancomment == "") {
		$alert .= "circadian comment is empty! ";
	} else {
		$circadiancomment= mysql_real_escape_string(Functions::stripAllSlashes($circadiancomment));
	}
	
	$namesynonyms = $_POST['namesynonyms'];
	if($namesynonyms == "") {
		$alert .= "namesynonyms is empty! ";
	} else {
		$namesynonyms= mysql_real_escape_string(Functions::stripAllSlashes($namesynonyms));
	}
	
	
	//error check save to database
	
	if ($alert != "") { // an error has been detected in the POSTed data
		?><script type="text/javascript">alert("<?php echo $alert;?>");</script>
		<?php // Alert the user (user will not be added to database)
	}
	else { // no error found in POSTed data, go ahead and add animal to database
		// Check if username and ID is occupied in database:
	//	$resultat = mysql_query("SELECT ID FROM `".Database::Toc."` WHERE animal_name_list='$animal_name_list' ");
	//	$loginIsOccupied = mysql_num_rows($resultat) > 0;

	//	if( !$loginIsOccupied ) {
	
			//add data to animal properties table
			$SQL_animalproperties = "
			INSERT INTO ".Database::AnimalProperties." (`Animal_Name_Latin`, `LifeSpan`, `Size`, `Weight`, `Devour`, `Devour_Comment`, `Circadian`, `Circadian_comment`, `NameSynonyms`)
			VALUES ('$animal_name_latin', '$lifespan', '$size', '$weight', '$devour', '$devourcomment', '$circadian', '$circadiancomment', '$namesynonyms') ";
			$result_animalproperties = mysql_query($SQL_animalproperties);

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
	//		echo '<script type="text/javascript">alert("Animal_Name_Latin! Var god försök igen.")</script>';
	//	} 
	}
} // end: add animal to database
mysql_close();
?>

<script type="text/javascript">
	function validateform() {
		var lifespan = document.getElementById('lifespan').value;
		var size = document.getElementById('size').value;
		var username = document.getElementById('animal_name_latin').value;

		var fail = false;
		var msg = "";

		if( !notEmpty(lifespan) || !notEmpty(size) ) {
			fail = true; msg += "Fel! Du måste skriva in lifespan och/eller size.\n";
		}

		if( fail ) {
			alert(msg);
			return false;
		}
		return true;
	}
</script>

<form name="InsertNew" method="post" action="addAnimalProperties.php?Animal_Name_Latin=<?php echo $animal_name_latin;?>">
<big>Add new animal properties:</big>
	<div class="divTable">
    	<div class="divTableRow">
            <div class="divTableCell">
                Create Animal Properties
            </div>
            <div class="divTableCell">
				 Life expectation
            </div>
		</div>
		<div class="divTableRow">
            <div class="divTableCell">
				<input type="text" name="animal_name_latin" id="animal_name_latin" placeholder="none" autofocus required value="<?php echo $animal_name_latin;?>">
            </div>
            <div class="divTableCell">
                <input type="text" name="lifespan" id="lifespan" placeholder="Life expectansy for chosen animal is _ to _ years. (up to _ in captivity)." required value="<?php echo $lifespan; ?>">
            </div>
		</div>
	</div>	
	<br>
	<div class="divTable">
		<div class="divTableRow">
			<div class="divTableCell">
			<!--	Circadian -->
			
				<select name="circadian" id="circadian">
					<option value="Nocturnal">Nocturnal</option>
					<option value="Diurnal">Diurnal</option>
					<option value="other">othertemp</option>
				<?php echo $circadian;?>
				</select>
			
			</div>
		
			<div class="divTableCell">

			<input type="text" name="circadiancomment" id="circadiancomment" placeholder="comment for circadian" required value="<?php echo $circadiancomment;?>">
			<br>
			</div>
		</div>
		<div class="divTableRow">
		     <div class="DivTableCell" "left">
			<!-- FOODIEAT -->
			
				<select name="devour" id="devour">
					<option value="Carnivore">Carnivore</option>
					<option value="Omnivore">Omnivore</option>
					<option value="Herbivore">Herbivore</option>
				<?php echo $devour;?>
				</select>
			</div>
			<div class="divTableCell">
			<input type="text" name="devourcomment" id="devourcomment" placeholder="Comment" required value="<?php echo $devourcomment;?>">
			</div>	
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
				Size
			</div>
			<div class="divTableCell">
				<input type="text" name="size" id="size" placeholder="HBL, shoulder, tail, wingspan, HBL+tail" width="120px" required value="<?php echo $size;?>">
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
				Weight
			</div>
			<div class="divTableCell">
				<input type="text" name="weight" id="weight" placeholder="The animal's weight here. (females and males)" required value="<?php echo $weight;?>">
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell">
				Synonymous names
			</div>
			<div class="divTableCell">
				<input type="text" name="namesynonyms" id="namesynonyms" placeholder="Other names ..." required value="<?php echo $namesynonyms;?>">
			</div>
		</div>
	</div>
		<center><input type="submit" name="Submit" class="button" value="Spara" onclick="javascript:return validateform();"></center>
	</div>
	
	<br>
	
</form>
</body>
</html>