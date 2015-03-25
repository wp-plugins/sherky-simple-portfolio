<?php


class MenuPortfolio {


    function setupMenu(){
	
	   add_menu_page(__('Sherk Portfolio Configuration'), __('Portfolio'), 'manage_options', 'portfolio_menu', array(MenuPortfolio,'create_portfolio'));
	   add_submenu_page('portfolio_menu', __('Add New Project'), __('Add New Project'), 'manage_options', 'portfolio_add_project', array(MenuPortfolio,'portfolio_add_project'));

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