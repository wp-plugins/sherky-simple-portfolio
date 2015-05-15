<?php
/*
Plugin Name: Sherky Simple Portfolio
Plugin URI: http://www.sherkspear.com/portfolio-item/simple-portfolio-plugin/
Description: Creates simple yet elegant responsive portfolio using shortcode into your page. Work samples are displayed using a fancy jquery plugin jPortilio.
Version: 1.2
Author: Sherwin Calims
Author URI: http://www.sherkspear.com

------------------------------------------------------------------------
Copyright 2015 SherkSpear

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

/*

  _________.__                  __      _________
 /   _____/|  |__   ___________|  | __ /   _____/_____   ____ _____ _______
 \_____  \ |  |  \_/ __ \_  __ \  |/ / \_____  \\____ \_/ __ \\__  \\_  __ \
 /        \|   Y  \  ___/|  | \/    <  /        \  |_> >  ___/ / __ \|  | \/
/_______  /|___|  /\___  >__|  |__|_ \/_______  /   __/ \___  >____  /__|
        \/      \/     \/           \/        \/|__|        \/     \/
*/

require_once 'database/Install.php';
require_once 'database/Uninstall.php';

require_once 'classes/Menu.php';
require_once 'classes/HelperFunctions.php';
require_once 'classes/SherkyPortfolioShortcode.php';
require_once 'classes/SherkyPortfolioCssJsScripts.php';

// Includes
require_once 'includes/Constants.php';


class SherkPortfolio{

	/**
	 * Enabled the sherk-porfolio plugin with registering all required hooks
	 *
	 * If the sm_command and sm_key GET params are given, the function will init the generator to rebuild the sitemap.
	 */
	 function enable(){
      //Setup menus on the sidebar for admin configuration of webplate...
	  add_action('admin_menu', array('MenuPortfolio', 'setupMenu'));
   }
    
   
   function getBaseDir(){
	   return dirname(__FILE__);
	}
	
	public static function get_plugin_url() {
		return plugins_url( '' , __FILE__ ).'/';
	}

   
   /**
	 * Create table portfolio for the sherk-portfolio plugin
	 */
	function createTablesOnDatabase(){
	   InstallPortfolio::createTables();
	}
	
	function deleteTablesOnDatabase(){
	   UninstallPortfolio::deleteTables();
	}
	
	function addJsScripts(){
	    $sherkportfolio_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
		wp_enqueue_script('wp_wall_script', $sherkportfolio_plugin_url.'/scripts/datetimepicker.js');
		wp_enqueue_script('jquery');
	}
	

} //end of class



//Enable the plugin for the init hook, but only if WP is loaded. Calling this php file directly will do nothing.
if(defined('ABSPATH') && defined('WPINC')) {
    //add_action('wp_print_scripts', array("SherkPortfolio","addJsScripts"),1000,0);
    add_action("init",array("SherkPortfolio","enable"),1000,0);
	//Install tables on the database
	register_activation_hook(dirname(__FILE__) . '/SherkPortfolio.php',array('SherkPortfolio','createTablesOnDatabase'));
	//Uninstall tables on the database
	//register_deactivation_hook(dirname(__FILE__) . '/SherkPortfolio.php',array('SherkPortfolio','deleteTablesOnDatabase'));
}



?>
