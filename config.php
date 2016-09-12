<?php
	/*** GENERAL CONFIG's ***/

	// EXECUTION TIME
	ini_set('MAX_EXECUTION_TIME', -1);

    // OS
	define( 'OS', strtoupper(substr(PHP_OS, 0, 3)) );

	// ROOT PATH
	define( 'ABSPATH', dirname( __FILE__ ) );

	// UPLOAD URI
	define( 'UP_ABSPATH', ABSPATH . '/resources/uploads/' );

	// CHMOD FULL PERMISSION
	define( 'FULL_PERMISSION', 0777 );

	// HOME URI
	define( 'HOME_URI', 'http://localhost:2380/KMS/admin' );

	// ACTIVE TAB
	$GLOBALS['ACTIVE_TAB'] = 'Dashboard';

	// HOSTNAME
	define( 'HOSTNAME', 'localhost' );

	// DB NAME
	define( 'DB_NAME', 'KMS' );

	// DB USER
	define( 'DB_USER', 'root' );

	// DB PASSWORD
	define( 'DB_PASSWORD', 'yuyuhakusho' );

	// PDO's CONNECTION CHARSET
	define( 'DB_CHARSET', 'utf8' );

	// IF DEVELOPING KEEP TRUE!
	define( 'DEBUG', true );

	// MAX FILE_UPLOAD SIZE
	define( 'MAX_FILE_SIZE', (1024*10000) ); //100 MB

	/*** DO NOT EDIT FROM HERE!!! ***/

	// LOADER CALLING (SYSTEM IGNITION)
	require_once ABSPATH . '/loader.php';
?>