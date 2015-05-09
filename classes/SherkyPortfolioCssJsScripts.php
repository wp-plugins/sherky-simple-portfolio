<?php

/**
 * LoadScripts class.
 * Load css and javascripts
 */
class SherkyPortfolioLoadScripts {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'include_sherky_portfolio_css_js'));
		
		add_action('admin_enqueue_scripts', array(&$this, '_edit_sherky_portfolio_js'));
		
	}



	/**
	 * include_sherky_portfolio_css_js function.
	 *
	 * @access public
	 * @return void
	 */
	public function include_sherky_portfolio_css_js() {
		global $post;
		if( has_shortcode( $post->post_content, 'sherkyportfolio' ) ) {
			wp_enqueue_script('jquery');
			wp_enqueue_script('bootstrap', SherkPortfolio::get_plugin_url().'scripts/js/bootstrap.min.js');
			wp_enqueue_script('jportilio', SherkPortfolio::get_plugin_url().'scripts/js/jportilio.js');
			wp_enqueue_script('sherk-portfolio-js', SherkPortfolio::get_plugin_url().'scripts/js/sherkportfolio.js');
			
			wp_register_style('bootstrap-styles', SherkPortfolio::get_plugin_url().'scripts/css/bootstrap.min.css', array(), '20121224', 'all' );
			wp_enqueue_style('bootstrap-styles');
			wp_register_style('jportilio-styles', SherkPortfolio::get_plugin_url().'scripts/css/jportilio.css', array(), '20121224', 'all' );
			wp_enqueue_style('jportilio-styles');
			
			wp_register_style('sherkportfolio-styles', SherkPortfolio::get_plugin_url().'scripts/css/sherkportfolio.css', array(), '20121224', 'all' );
			wp_enqueue_style('sherkportfolio-styles');			

		}
	}
	
	function _edit_sherky_portfolio_js($pagenow){
		
		if ($pagenow=='portfolio_page_portfolio_add_project' || $pagenow=='toplevel_page_portfolio_menu') {
			wp_register_style('jportilio-edit-styles', SherkPortfolio::get_plugin_url().'scripts/css/sherkportfolio-edit.css', array(), '20121224', 'all' );
			wp_enqueue_style('jportilio-edit-styles');			
			
			wp_enqueue_script('sherk-portfolio-editjs', SherkPortfolio::get_plugin_url().'scripts/js/admin-sherkportfolio.js');
			wp_enqueue_script('jquery');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_register_script('my-upload', WP_PLUGIN_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
			wp_enqueue_script('my-upload');
			wp_enqueue_style('thickbox');
	
			
		}
	}

}

new SherkyPortfolioLoadScripts();