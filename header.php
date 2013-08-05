<h1 id="ContentHeader">WILDLIFE</h1>
<p id="HeadNav">
TempMenu:&#160;
<a href="index.php">Start</a> | 
<a href="CharacterCreation.php">Character Creation</a> | 
<a href="showAnimalListTable.php">AnimalList</a> |
</p>


<?php			

$loggedIn = '<span class="no_print">';
$admin = '<a href="admin/index.php">Admin</a>';
if( isset($_SESSION['Username']) ) {
	$loggedIn .= $admin . '<br>' . 'You are currently logged in as <b>' . $_SESSION['Username'] . '</b>.';
} else {
	$loggedIn .= 'You are not currently logged in.';
}

echo $loggedIn;

?>

<!-------- Logout button -------->
<?php
	if( isset($_SESSION['Username']) ) {
	$login_action = isset($_SESSION['Username']) ? "logout" : "login";
	$login_value = isset($_SESSION['Username']) ? "Logout" : "Login";
	?>
	<li>
	<form name="Logout"  class="menuform" method="POST" action="index.php?location=<?php echo $login_action; ?>">
		<input type="Submit" class="button" name="SubmitLogout" value="<?php echo $login_value; ?>" title="Logout" style="float: right;">
	</form>
	</li>
<?php
			} else {
			// Dont show the logout button
			}
?>


<br><br>