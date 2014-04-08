<?php
/**
 * WolfPortfolio Hooks
 *
 * Action/filter hooks used for WolfPortfolio functions/templates
 *
 * @author WpWolf
 * @category Core
 * @package WolfPortfolio/Templates
 * @version 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** Template Hooks ********************************************************/

if ( ! is_admin() || defined('DOING_AJAX') ) {

	/**
	 * Content Wrappers
	 *
	 * @see wolf_portfolio_output_content_wrapper()
	 * @see wolf_portfolio_output_content_wrapper_end()
	 */
	add_action( 'wolf_portfolio_before_main_content', 'wolf_portfolio_output_content_wrapper', 10 );
	add_action( 'wolf_portfolio_after_main_content', 'wolf_portfolio_output_content_wrapper_end', 10 );

}

/** Event Hooks *****************************************************/

add_action( 'template_redirect', 'wolf_portfolio_template_redirect' );