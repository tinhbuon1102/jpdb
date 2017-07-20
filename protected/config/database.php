<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=jpofficedb_japan',
	'emulatePrepare' => true,
	'username' => 'jpofficedb_japan',
	'password' => 'ZvmAb6H3z6wBSKmG',
	'charset' => 'utf8',
	
);