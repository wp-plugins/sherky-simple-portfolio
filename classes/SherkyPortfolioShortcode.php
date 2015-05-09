<?php

class SherkyPortfolioShortcode {

	public function __construct() {
		add_shortcode( 'sherkyportfolio', array($this,'sherkyportfolio_func' ));
	}

	function sherkyportfolio_func( $atts ){
		
		$shortcodecontent.='<section class="container-fluid" id="sherky_portfolio_shortcode">';
			
		$shortcodecontent.=HelperFunctionsPortfolio::preparePortfolioPage();
				
		$shortcodecontent.='
		</section>';
	
		return $shortcodecontent;
	}
	
	
}

new SherkyPortfolioShortcode();