<?phpclass UninstallPortfolio{    function deleteTables(){	    global $wpdb;	  //drop tables if exists		$sql_drop_if_exist= "DROP TABLE IF EXISTS " . SHERKPORTFOLIOPROJECTS . ', ' . SHERKPORTFOLIOPERSONAL;		$wpdb->query($sql_drop_if_exist);	}} //end class?>