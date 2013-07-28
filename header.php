<header id="pageHeader" class="no_print">
<h1 id="ContentHeader">WILDLIFE</h1>

<a href="index.php">Back to start</a><br>

<?php			

$loggedIn = '<span class="no_print" style="color: #fff">';
if( isset($_SESSION['Username']) ) {
	$loggedIn .= 'You are currently logged in as <b>' . $_SESSION['Username'] . '</b>.';
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

</header>