<?php


/**
 * Class with various helper functions.
 */
class Functions
{

	/**
	 * Generates a password of variable length.
	 * @param unknown_type $length (optional)  password length, default 8
	 */
	public static function generatePassword($length = 8)
	{
		// start with a blank password
		$password = "";

		// define possible characters - any character in this string can be
		// picked for use in the password, so if you want to put vowels back in
		// or add special characters such as exclamation marks, this is where
		// you should do it
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

		// we refer to the length of $possible a few times, so let's grab it now
		$maxlength = strlen($possible);

		// check for length overflow and truncate if necessary
		if ($length > $maxlength)
		{
			$length = $maxlength;
		}

		// set up a counter for how many characters are in the password so far
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length)
		{
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);

			// have we already used this character in $password?
			//if (!strstr($password, $char))
			{
				// append new char and increase counter
				$password .= $char;
				$i++;
			}
		}
		// done!
		return $password;
	}

	/**
	 * Returns a string which has had all backslashes removed.
	 * @param string $string  any string
	 */
	public static function stripAllSlashes($string) {
	    while(strchr($string,'\\')) {
	        $string = stripslashes($string);
	    }
	    return $string;
	}
	
}
?>