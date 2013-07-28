<!--
/** @file
 * Login page.
 * 
 * Login page where user can provide username/password to login.
 * When user clicks 'Logga in' button, a page reload is requested with location='checkLogin'
 * and username/password POSTed.
 * 
 */
-->

<div class="ContentLogin">
	<section>
		<p id="warn_user"></p>
		<!-- Warn user against using IE browser -->
		<script type="text/javascript">
		var bowser = navigator.appName;
		var el = document.getElementById("warn_user");
		if( bowser == "Microsoft Internet Explorer" ) {
		el.innerHTML = "Det verkar som att du använder Internet Explorer. För bästa upplevelse rekommenderar vi Firefox, Chrome, Opera eller Safari.";
		el.innerHTML = el.innerHTML + "<br><a href=\"http://www.getfirefox.net/\">getFirefox.net<\/a>"
		}
		</script>
	
		<form name="login" id="login" method="post" action="index.php?location=checkLogin">	<!-- POST to index.php with GET['location']=checkLogin -->
			<h1>Logga in</h1>
			<div>
				<input name="myusername" type="text" id="myusername" placeholder="Användarnamn" autofocus required>
			</div>
			<div>
				<input name="mypassword" type="password" id="mypassword" placeholder="Lösenord" required>
			</div>
			<div>
				<li>
				<input type="submit" class="button" value="Logga in" />
				</li>
			</div>
		</form><!-- form -->
	</section><!-- content -->
</div><!-- container -->