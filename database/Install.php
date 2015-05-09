<?php

require_once ABSPATH . 'wp-admin/upgrade-functions.php';

class InstallPortfolio{


    function createTables(){
	   global $wpdb;
	   
	   if(!$wpdb->get_var("SHOW TABLES LIKE '".SHERKPORTFOLIOPROJECTS."'") == SHERKPORTFOLIOPROJECTS ) {
	      
		  $sherkportfolio_tables[] = "CREATE TABLE " . SHERKPORTFOLIOPERSONAL . " (
				id INTEGER NOT NULL AUTO_INCREMENT,
				name VARCHAR(255) NOT NULL,
				photo VARCHAR(255) NOT NULL,
				skype VARCHAR(255) NOT NULL,
				ym VARCHAR(255) NOT NULL,
				gmail VARCHAR(255) NOT NULL,
				email VARCHAR(255) NOT NULL,
				url_fb VARCHAR(255) NOT NULL,
				url_twitter VARCHAR(255) NOT NULL,
				url_linkedin VARCHAR(255) NOT NULL,
				skills VARCHAR(255) NOT NULL,
				objective VARCHAR(555) NOT NULL,
				PRIMARY KEY (id) )" ;
		  
		  $sherkportfolio_tables[] = "CREATE TABLE " . SHERKPORTFOLIOPROJECTS . " (
				id INTEGER NOT NULL AUTO_INCREMENT,
				name VARCHAR(256) NOT NULL,
				url VARCHAR(256) NOT NULL,
				screenshot VARCHAR(256) NOT NULL,
				description VARCHAR(512) NOT NULL,
				fromdate VARCHAR(256) NOT NULL,
				todate VARCHAR(256) NOT NULL,
				PRIMARY KEY (id) )" ;
			
			
			//create tables
			foreach($sherkportfolio_tables as $sherkportfolio_table)
				dbDelta($sherkportfolio_table);	
	   
	   }
	
	}

} //end class


?>