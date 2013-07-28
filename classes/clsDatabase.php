<?php
/**
 * This class has constants for the available database tables. They are used
 * in SQL queries instead of typing the table name directly.
 * A future improvement would be to add functions for building SQL queries.
 */
class Database {
	const UserList = "wl_UserList";			///  userlist table
	const AnimalList = "wl_AnimalList";	///  animallist table
	const ToC		= "wl_ToC";				///  animal content
	const AnimalProperties = "wl_AnimalProperties"; /// Animal properties
	const AnimalColors = "wl_AnimalColors"; /// Animal colors
}
?>