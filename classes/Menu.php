<?php


class MenuPortfolio {


    function setupMenu(){
	
	   add_menu_page(__('Sherk Portfolio Configuration'), __('Portfolio'), 'manage_options', 'portfolio_menu', array(MenuPortfolio,'create_portfolio'),'dashicons-welcome-learn-more','6.0003');
	   add_submenu_page('portfolio_menu', __('Add New Project'), __('Add New Project'), 'manage_options', 'portfolio_add_project', array(MenuPortfolio,'portfolio_add_project'));
	   
	   add_submenu_page('portfolio_menu', __('How To Use'), __('How To Use'), 'manage_options', 'sherkportfolio_menu_page', array(MenuPortfolio,'sherkportfolio_menu_page'));

	}
	

	function sherkportfolio_menu_page(){
		require_once SherkPortfolio::getBaseDir(). '/templates/sherkportfolio_dashboard.php';
	}
	
	
	/**
	 * Shows the option page for Add New Client
	 */
	function create_portfolio(){
	   require_once SherkPortfolio::getBaseDir(). '/forms/createportfolio.php';
	}
	
	/**
	 * Shows the option page for Create Portfolio
	 */
	function portfolio_add_project(){
	   require_once SherkPortfolio::getBaseDir(). '/forms/portfolioproject.php';
	}
	
	

	
} //end of class
	
	
?>