<?php

// Check login
if(!isset($_SESSION['Username'])) {
	header("location:index.php?location=login");	// Not logged in, redirect to login page
	exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="djmmorpg-css.css">
<!-- here a future link to javascript library? -->
<title>DjurMMORPG</title>
</head>

<body>
<header>
<h3>DJUR SIMULATION MMORPG</h3>
</header>
<!--
<a href="djurspel-plan_CCreation.html">Character Creation</a> | 
<a href="index.php?location=showAnimalListTable">AnimalList</a> | 
<a href="index.php?location=places">Places</a> -->

<div id="content">
<a href="Birdbase.html">Birdbase</a>

<!-- <div class="accordion vertical">
    <ul>
        <li>
            <input type="checkbox" id="checkbox-1" name="checkbox-accordion" />
            <label for="checkbox-1">TITLE</label>
            <div class="content"> -->
<table class="nTable">
<tr>
<td>
<dl>
<dt>Genetics</dt>
<br>
<dt>Interactions (RPG)</dt>
	<dd>Fight (hunt?)</dd>
	<dd>Friendly</dd>
	<dd>Self / enviroment</dd>
	</td>
	<td>
<dt>NPCs</dt>
	<dd>Eat</dd>
	<dd>Drink</dd>
	<dd>Hunt</dd>
	<dd>Interact</dd>
	<dd>Sleep/rest</dd>
	<dd>Breed</dd>
	<dd>Sicknesses</dd>
	<dd>Age</dd>
	</td>
	<td>
<dt>Enviroment</dt>
	<dd>Seasons</dd>
		<dd>Winter, Summer, Spring, Autumn / Dry and wet season</dd>
	<dd>Events</dd>
		<dd>Wildfire</dd>
		<dd>Storm</dd>
		<dd>Flood</dd>
		</td>
		</tr>
		</table>
		</p>
		
Eat<br>
Drink<br>
Hunt<br>
Rest<br>
Breed<br>
Survive nature<br>
Survive diseases<br>
Survive predators<br>
Fighting<br>
<br>



<!-- 
        </li>
		    </ul>
</div> -->
<h3>PLACES</h3>
<p>
Varje <a href="#">plats/område</a> i spelet behöver ha tillräckligt många djursorter av rätt typ. Ex. rovdjur, bytesdjur till valda rovdjur, samt ofc växter till bytesdjuren etc. (växter tar vi senare). Jag har valt ut ett par "platser" som får fyllas ut med lämpliga djursorter för varje område..<br><br>
<li>(apex) Stort solitärt rovdjur (björndjur/kattdjur)</li>
<li>evapex Stort socialt rovdjur (hundjur)</li>
<li>medh Medium solitärt rovdjur (hunddjur)</li>
<li>medk Medium socialt rovdjur (kattdjur)</li>
<li>apex Stor jagande rovfågel</li>
<li>evapex Stor asätande/omnivore fågel</li>
<li>med jagande fågel</li>
<li>med bytes fågel</li>
<li>liten bytes fågel</li>
<table class="nTable">
	<tr>
		<td>
		<p>stort</p>
		</td>
		<td>
		<p>solitärt</p>
		</td>
		<td>
		<p>rovdjur</p>
		</td>
	</tr>
	<tr>
		<td>
		<p>stort</p>
		</td>
		<td>
		<p>socialt</p>
		</td>
		<td>
		<p>rovdjur</p>
		</td>
	</tr>
</table>
<div>

</div>
<br> Alternativt skulle man kanske kunna ta en av varje djursort på varje plats.. hmm..<br>

<br><p>Eventuellt att alla djur är länkade till sin egna informationssida.</p>

björnar
kattdjur
hunddjur

felidae
viverridae
hyaenidae
herpestidae (mongooses)
eupleridae (madagascar)
canidae
ursidae
odobenidae (walrus only)
ailuridae (red panda only)
mephitidae (skunks)
procyonidae (raccoons, kinkajous etc)
mustelidae
pinnipedia (seals, walrus etc)
<br><br>
<p>
<img src="http://ichef.bbci.co.uk/naturelibrary/images/ic/624x351/location/neotropic_ecozone.gif" width="100px">
The <b>Neotropical</b> ecozone incorporates South and Central America, plus the southern part of Mexico, the Caribbean Islands and Florida.</p>
<br>
<img src="http://ichef.bbci.co.uk/naturelibrary/images/ic/624x351/location/palearctic_ecozone.gif" width="100px">
The Palaearctic ecozone is the world's largest. It covers northern Africa, Europe, the northern part of Arabia and all of Asia north of the Himalayas. Japan and Iceland are also part of this ecozone.
<br>
<img src="http://ichef.bbci.co.uk/naturelibrary/images/ic/624x351/location/nearctic_ecozone.gif" width="100px"> 
The <b>Nearctic</b> ecozone covers North America, including northern Mexico and Greenland. Florida, though, sits outside this ecozone. 
<br>
<img src="http://ichef.bbci.co.uk/naturelibrary/images/ic/624x351/location/indomalaya_ecozone.gif" width="100px">
The <b>Indomalayan</b> ecozone covers south and south-east Asia. It stretches from Afghanistan in the west to Japan's Ryukyu Islands in the east and Borneo in the south.
<br>
<img src="http://ichef.bbci.co.uk/naturelibrary/images/ic/624x351/location/australasia_ecozone.gif" width="100px">
The <b>Australasian</b> ecozone covers Australia, New Guinea and the easternmost islands of the Indonesian archipelago, including Sulawesi and the Lesser Sundas. New Zealand is also part of this ecozone.
<br><br>

<!-- procyonidae (raccons, kinkajou etc) - AMERIKA RAIN. Skunkar mephitidae (skunks) också AMERIKA RAIN. Weasels !-->
<!-- No bears in africa! They live in america and europe. !-->
<!-- Maned wolves live in south america -->
<!-- Common Kestrel lives in Scandinavia! -->
<br><br>

<div class="accordion vertical">
    <ul>
        <li>
            <input type="checkbox" id="checkbox-1" name="checkbox-accordion" />
            <label for="checkbox-1">AFRIKA</label>
            <div class="content">
			<img src="http://ichef.bbci.co.uk/naturelibrary/images/ic/624x351/location/afrotropic_ecozone.gif" width="200px"> <- afrotropics<br>
			<p>(Lejon, vildhund, hyena, jackal, serval, leopard, gepard, vattenbuffel, flodhäst, giraff, elefant, noshörning, zebra, gnu, bongo, kanin, ev. mus, duva, svan, kungsörn, gazelle, gam, fiskgjuse, tornuggla, struts, krokodil, African pygmy falcon) <br><br>
			(Tropical grassland,  desert, flooded grassland, mangroves, mediterranean forest, mountain grassland, rainforest, tropical dry forest)</p>
        </li>
		    </ul>
</div>

<p><b>Notes</b><br>
How new animals (npcs) could spawn: Either they just spawn somewhere, or a female or pair could have young spawned in the breeding season, but the young would show up without a pedigree. (Or they could show a pedigree if both parents take care of them. If only one parent takes care of them, the other could show up as unknown.)
</p>

</body>

</html>