<?php
/** @file
 *
 * $_SESSION -variables used:
 * Username (read)
 *
 * $_GET -variables used:
 * area
 *
 * $_POST -variables used:
 * 
 */

// turn on display of all error messages
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* include_once('clsHtml.php'); */



// Include necessary files and connect to database
include_once('classes/clsConnect.php');										//används
include_once('classes/clsDatabase.php');									//används
include_once('classes/clsFunctions.php');									//används

Connect::openConnection();	// Connect to database.

// Get AnimalList from area using clsFunction.php:
$area = "Africa";
//$viewUserData = Functions::getAnimalListTable($area); // Get current area's data

// Get the employee name
//$f5 = $viewUserData['Fornamn'];
//$f6 = $viewUserData['Efternamn'];

/** Return data from Animal List table **/
// public static function getAnimalListTable($area) {
//$query = "
//SELECT `Area`, `Type_Group`, `Type_Size`, `Animal_Name_ENG`, `Animal_Name_Latin`
//FROM `".Database::AnimalList."` 
//WHERE Area='$area' ";
//		$result = mysql_query($query);
//		return mysql_fetch_assoc($result);
//	}



// fetch data from database
$sql = "
SELECT Area, Type_Group, Type_Size, Animal_Name_ENG, Animal_Name_Latin
FROM ".Database::AnimalList."
WHERE Area='$area'
ORDER BY Animal_Name_ENG DESC; ";

$result = mysql_query($sql);
?>


<!-- HTML: START of HTML output -->
<h2><?php echo $area;?></h2>
<div id="ContentHeader">
	<?php include ('placesNav.php'); ?>
</div>
<!--
<p>
<center>AFRICA | EUROPE | NORTH AMERICA | SOUTH AMERICA | AUSTRALIA | ASIA | CANADA / NORDEN</center>
</p> -->
<!-- <hr width="50%"> -->
<!--  start outputting data in html table  -->
<table id="showtable" class="showtable">
<thead>
	<tr>
		<th>TYPE</th>
		<th>Felidae</th>
		<th>Canidae</th>
		<th>Ursidae</th>
		<th>Ungulates</th>
		<th>Aves</th>
		<th>Raptor</th>
		<th>Rodentia</th>
		<th>Reptile</th>
	</tr>
</thead>
<tbody>
	<?php
	while( $xs = mysql_fetch_assoc($result) ) {
		$class = 'class="showtable"';
		echo "	<tr>\n";
		echo "		<td $class>" . $xs['Type_Group'] . "</td>\n";
		echo "		<td $class>" . $xs['Type_Size'] . "</td>\n";
		echo "		<td $class>" . $xs['Animal_Name_ENG'] . "</td>\n";
		echo "		<td $class>" . $xs['Animal_Name_Latin'] . "</td>\n";
		echo "	</tr>\n";
	}
	?>
</tbody>
</table>
            
<br>
<a href="index.php">Tillbaka till startsidan</a>

<?php
mysql_close();
?>