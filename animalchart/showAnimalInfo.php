<?php
/** @file
 * ShowAnimalInfo from table wl_AnimalList (name, pic), wl_AnimalProperties and wl_ToC
 *
 * $_SESSION -variables used:
 * Username (read)
 *
 * $_GET -variables used:
 * animal_name_latin
 * 
 */
 
// turn on display of all error messages
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check login
//if(!isset($_SESSION['Username'])) {
//	header("location:../index.php?location=login");	// Not logged in, redirect to login page
//	exit;
//}

//Include necessary files and connect to database
include_once('../classes/clsConnect.php');										//används
include_once('../classes/clsDatabase.php');									//används
include_once('../classes/clsFunctions.php');									//används

Connect::openConnection();	// Connect to database.

// Make sure variables to be used are empty:
$area = "" ;
$animal_name_latin = $_GET['animal_name_latin']; // "Panthera Leo";
$animal_name_eng = "";
$animal_name_swe = "";
$picture = "";
$map = "";
$listword = "";
$listword_description ="";
$contenttext = "";
$row = "";



// fetch data from wl_AnimalList
$sql = "
SELECT Area, Animal_Name_ENG, Animal_Name_SWE, Picture, Map
FROM ".Database::AnimalList."
WHERE Animal_Name_Latin='$animal_name_latin' ";

$result = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_array($result))
	{
		// set information to variables.
		$area = $row['Area'];
		$animal_name_eng = $row['Animal_Name_ENG'];
		$animal_name_swe = $row['Animal_Name_SWE'];
		$picture = $row['Picture'];
		$map = $row['Map'];
	}
	
// fetch data from wl_ToC
$sql1 = "
SELECT ListWord, ListWord_Description, ContentText
FROM ".Database::ToC."
WHERE Animal_Name_Latin='$animal_name_latin' ";

$result1 = mysql_query($sql1) or die(mysql_error());

$sql2 = "
SELECT LifeSpan, Size, Weight, Devour, Devour_Comment, Circadian, Circadian_Comment, NameSynonyms
FROM ".Database::AnimalProperties."
WHERE Animal_Name_Latin='$animal_name_latin' ";

$result2 = mysql_query($sql2) or die(mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../djmmorpg-css.css">
	<title>WildLife - <?php echo $animal_name_eng ?></title>

	<script type="text/javascript">
		function showSpoiler(obj)
		{
		var inner = obj.parentNode.getElementsByTagName("div")[0];
		if (inner.style.display == "none")
			inner.style.display = "";
		else
			inner.style.display = "none";
		}
    </script>
</head>

<body>

<header id="HeadNav">
<h3 id="top"><?php echo $animal_name_eng;?></h3>
	<i><a href="https://en.wikipedia.org/wiki/<?php echo $animal_name_eng;?>" target="_blank"><?php echo $animal_name_latin;?></a></i>
	<?php echo $animal_name_swe;?>
	<small><a href="../showAnimalListTable.php?location=<?php echo $area;?>"><< Tillbaka till tabell</a></small>
</header>

<div>
<img class="ContentPic" src="../images/<?php echo $picture;?>" alt="stor bild">
</div>

<!--  start outputting data in ContentList  -->
<div class="ContentList">
	<u>Innehållsförteckning</u><br>
	<ul>
	<?php
	while( $xs = mysql_fetch_assoc($result1) ) {
			echo "<li><a href=". "#" . $xs['ListWord'] . ">" . $xs['ListWord_Description'] . "</a></li>\n";
	}
	?>
	</ul>
</div>

<!-- lista på rubriker hämtat från wl_Toc -->

<div>
<img class="ContentMap" src="<?php echo $map;?>" alt="stor bild">
</div>

<div class="ContentProperties">
	<?php
	// mysql_data_seek ($result2, 0);
	while( $xs = mysql_fetch_assoc($result2) ) {
		echo "<li>".$xs['LifeSpan']. "</li>\n";
		echo "<li>".$xs['Circadian'];
		echo " " .$xs['Circadian_Comment']."</li>\n";
		echo "<li>".$xs['Devour']."</li>\n";
		echo "<li>".$xs['Devour_Comment']."</li>\n";
		echo "<li>".$xs['Size']."</li>\n";
		echo "<li>".$xs['Weight']."</li>\n";
		echo "<li>" . "The " .$animal_name_eng . " is also called " .$xs['NameSynonyms']."</li>\n";
	}
	?>
</div>




<!--
<div id="ainfo">
<table>
<tr>
<td>
<img src="Range_FinchRedBilledFire.jpg" width="150px">
</td>
<td>
Life expectansy for a __________________ is _ to _ years in the wild. (up to __ in captivity.)<br>
<img src="" width="25px"> Saknar information ang dagaktiv/nattaktiv.<br>
<img src="" width="40px"> Hunting strategy and prefered type of food.<br>
Length: Head-body length
Wingspan: Wingspan.<br>
Weight: weight<br>
Coloration on males and females.<br>
<br>Any other names?<br>
</td>
</tr>
</table>
</div> -->
<p>Reference pictures, sounds, model, textures, animations.</p>

<div class="ContentText">
	<h1>The story continues...</h1><br>
	<?php
	//Point to 0 (zero) to reuse the mysql_fetch_assoc without do another sql query.
	mysql_data_seek ($result1, 0);
	$class = 'class="ContentTopic"';
	while( $xs = mysql_fetch_assoc($result1) ) {
			echo "<div $class>" . $xs['ContentText'] . "</div>";
	}
	?>
</div>

_____

<b id="colors">COLORS</b><br>
Any color morphs?<br>

<span style="background-color:#E60026; border:1px solid #E60026 width:20px;color:#E60026">#E60026&#160;</span> RR Red<br>
<span style="background-color:#DC143C; border:1px solid #DC143C width:20px;color:#DC143C">#DC143C</span> Crimson<br>
<span style="background-color:#CE2029; border:1px solid #CE2029 width:20px;color:#CE2029">#CE2029</span> Fire Engine Red<br>
<span style="background-color:#FF0000; border:1px solid #FF0000 width:20px;color:#FF0000">#FF0000&#160;</span> Sharp Red<br>
<span style="background-color:#800000; border:1px solid #800000 width:20px;color:#800000">#800000&#160;</span> Maroon<br>
<span style="background-color:#A52A2A; border:1px solid #A52A2A width:20px;color:#A52A2A">#A52A2A</span> Auburn<br>
<span style="background-color:#900020; border:1px solid #900020 width:20px;color:#900020">#900020&#160;</span> Burgundy<br>
<span style="background-color:#A81C07; border:1px solid #A81C07 width:20px;color:#A81C07">#A81C07</span> Rufous<br><br>
Wings and tail:<br>
<span style="background-color:#404040; border:1px solid #404040 width:20px;color:#404040">#404040&#160;</span> Grey<br>
<span style="background-color:#7B3F00; border:1px solid #7B3F00 width:20px;color:#7B3F00">#7B3F00</span> Chocolate<br>
<br>
Female body:<br>
<span style="background-color:#6F4E37; border:1px solid #6F4E37 width:20px;color:#6F4E37">#6F4E37&#160;</span> Coffe<br>
<span style="background-color:#B87333; border:1px solid #B87333 width:20px;color:#B87333">#B87333&#160;</span> Copper<br>
<span style="background-color:#C19A6B; border:1px solid #C19A6B width:20px;color:#C19A6B">#C19A6B</span> Fawn<br>

	<br>
<b id="eyecolors">EYE COLOR</b><br>
With sunglass effect. (Mörkt lager ovanpå)<br>
<span style="background-color:#7B3F00; border:1px solid #7B3F00 width:20px;color:#7B3F00">#7B3F00</span> BB	Brown<br>
<span style="background-color:#8A3324; border:1px solid #8A3324 width:20px;color:#8A3324">#8A3324</span> RR  Burnt Umber<br>
<br>

<b id="markings">MARKINGS</b><br>
	<br>
	<br>
	<b id="interactions">INTERACTIONS / BEHAVIOUR</b><br>
In the wild Fire Finches live in large groups and usually found in savannah woodland. They are the most widespread and common of the African birds and abundant around human habitats. Fire Finches predominantly feed on the ground, consuming seeds of various weeds and some insects.<br>
Fire finches, in their natural environment, eat small seeds of grasses and herbs, and small insects. <br>
<b id="diet">Diet</b><br><br>
PREFERED PREY <b>Grass seeds, insects</b>.<br>
AMOUNT ?<br>
FIGHTING  ?<br>
STYLE ? <br>
 SPEED of EATING ?<br>
 WATER ?<br>
STEAL ?<br>
<br>
FLIGHT STYLE?<br>
<br>

<b id="ages">AGE AND MATURITY</b><br> <!-- Edit this to a nice timeline! -->
Season: Egg-laying season <br>
Antal: Amount of eggs in a brood.<br>
Bo: Construction of the nest.<br>
Bomaterial: Preferred material(s).<br>
Construction: Who builds? How long does it take?<br>
Boplats: Prefered location of nest.<br>
Ruvning: Vem ruvar?<br>
??? Gestation<br>
12-14d Incubation. My birds would easily abandon their incubation task whenever I
approached the nest too close, but would usually return after 5-10 minutes. <br>
3w Fledging<br>
2w stays w parents<br>
6-9w Males get their plumage<br>
6m Sexual Maturity<br>
12m-4y Best breeding years (estimate)<br>
<br>
<br>
<br>

<b id="sounds">SOUNDS</b><br>

	<br>
	<br>

	<br>
<b id="ill">SICKNESSES, DISEASES AND COMMON INJURIES</b><br>
	Predator attacks<br>
	<br>
	<br>
	<b>Blind (one or both eyes) </b><br>
	<b>Cause:</b> Injury (fight/hunting)<br>
	<b>Effect:</b> Causes screen to become dim/whiteish. (On the blind eye(s) side) <i>OBS: Eventuellt att detta ?effecten av gr?tarr, och "vanlig" blind ger en svart effect p?k?en ist?et..?</i><br>
	<br>
	<b>Deaf (One or both ears)</b><br>
	<b>Cause:</b> Usually born with. (Might increase with age.)<br>
	<b>Effect:</b> Speakers stop playing sound.<br>
	<br>
	<b>Broken leg</b><br>
	<b>Cause:</b> From battle/hunting, <br>
	<b>Effect:</b> (Will heal over time, but can cause death. It also may not heal very well.) Greatly decreases speed (limping animation), and agility. Maybe slight decrease to strenght. Also needs more rest.<br>
	<br>
	<b>Open wound</b><br>
	<b>Cause:</b> battle/hunting <br>
	<b>Effect:</b> (chance to cause infection)  More need to rest. Less agility.<br>
	<br>
	<b>Infection</b> <br>
	<b>Cause:</b> Usually caused by open wound. <br>
	<b>Effect:</b> Even more need to rest. Health going slowly down.<br>
	<br>
	<b>Poison</b> <br>
	<b>Cause:</b> Caused by eating poisonous food, or maybe old food. <br>
	<b>Effect:</b> Health going down, more need to rest, might roll around or show pain.<br>
	<br>
	<b>Disease</b><br>
	<b>Cause:</b> Randomly, or by eating old or unfresh/clean food. Kan smitta. <br>
	<b>Effect:</b> More need to rest. Health slowly going down. Slightly less speed. Takes different amounts of time to heal/dissappear.<br>
	<br>
	<b>Worms</b> <br>
	<b>Cause:</b> From eating old food, small chance from eating fresh kill. <br>
	<b>Effect:</b> Causes more need to eat, will have to eat more or will starve.<br>
	<br>
	<b>SCARS</b><br>
	Wounds and other injuries may give scars, visible on the animal. Blind eyes will also be visible (whiteish). Also ripped/teared ears etc.
	<br>
	<br>
	


<b id="interbreed">INTERBREEDING</b> <a href="#top">^ up ^</a><br>
_______________ can breed with ?<br>
<br>



<?php mysql_close();?>


</body>
</html>