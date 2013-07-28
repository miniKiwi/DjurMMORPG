<?php
/**
 * Defines a static function fo to connect to mySQL database.
 *
 * IMPORTANT: This file holds hard-coded access credentials to the database.
 * This file should never be readable from anywhere else than localhost machine.
 *
 */
class Connect
{
	const CONTACT_EMAIL = "admin@stefanlindh.se";	///< email address to use in case of critical errors
	const CONTACT_EMAIL2 = "admin@stefanlindh.se";

	/**
	 * Opens a database connection. If connecting fails the script execution
	 * is stopped and the browser is redirected to index.php.
	 */
	public static function openConnection() {
		// below credentials are valid for the deployment at the webhotel one.com.
		$user_name = "stefanlindh_se";
		$password = "08jol31hft2";
		$database = "stefanlindh_se";
		$server = "stefanlindh.se.mysql"; // for deployment at webhotel one.com
		// $this->server = "localhost"; // for development on local machine

		date_default_timezone_set("Europe/Stockholm");
		$msg = '';
		if( mysql_connect($server, $user_name, $password) ) {
			if( mysql_select_db($database) ) {
				return;
			} else {
				$msg = '<h2 style="color: red">Fel: kunde inte öppna databas!</h2>';
				self::emailAdmin("clsConnect::openConnection, failed to select db\n" . mysql_error());
			}
		} else {
			$msg = '<h2 style="color: red">Fel: kunde inte ansluta till databas!</h2>';
			self::emailAdmin("clsConnect::openConnection, failed to connect to db\n" . mysql_error());
		}
		//die("Error - Connection to database failed!");
		if( headers_sent() ) {
			echo $msg;
		} else {
			header("location:index.php?error=$msg");  // TODO replace with "$msg" ?
		}
		exit;
	}

	/**
	 * Sends an email message with the given message body to the designated
	 * administrators of this application or a custom email address.
	 * @param string $message  message body
	 * @param string $to       email address (optional)
	 */
	public static function emailAdmin($message, $to=self::CONTACT_EMAIL) {
		$message .= "\n\nAutomatiskt mail från Stefan Lindh - det går inte att svara på mailet.\n";
		$message .= "\nändra e-postadressen i clsConnect.php\n";
		$message = wordwrap($message, 70);
		$ok = mail($to, "Meddelande från Wild Life", $message, "From: admin@stefanlindh.se\r\n");
		if( !$ok ) {
			// if something fails, try again on the backup email address
			$message =
"Meddelande från Wild Life\nEtt fel inträffade och systemet försökte skicka
ett e-postmeddelande till adressen '$to'. Det gick inte att skicka mailet.
Kontrollera att e-postadressen är korrekt.

Här följer det ursprungliga felmeddelandet, som är ämnat till utvecklaren:
$message ";
			$ok = mail(self::CONTACT_EMAIL2, "Meddelande från Wild Life", $message, "From: admin@stefanlindh.se\r\n");
			// TODO: if this fails, give up?
		}
	}

	/**
	 * Returns an array with account information the be used when connecting
	 * to the MySQL server. Used while doing backups.
	 */
	public static function getConnectArray() {
		return array("stefanlindh.se.mysql", 'stefanlindh_se', '08jol31hft2', 'stefanlindh_se');
	}

}
?>
