
<?php 

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database to use, and sets the encoding.

// Set the database access information as constants:
DEFINE ('DB_USER', 'chou');  
DEFINE ('DB_PASSWORD', '1792123'); 
DEFINE ('DB_HOST', 'dany.simmons.edu');
DEFINE ('DB_NAME', '33001sp19_chou'); 

// Make the connection.@ will make sure the error won't be returned if there is one.
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
?>
