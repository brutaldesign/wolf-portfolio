<?php
/**
 * WolfPortfolio Template Functions
 *
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 *
 * @author WpWolf
 * @category Core
 * @package WolfPortfolio/Templates
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** Global ****************************************************************/

if ( ! function_exists( 'wolf_portfolio_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function wolf_portfolio_output_content_wrapper() {
		wolf_portfolio_get_template( 'portfolio/wrapper-start.php' );
	}
}


if ( ! function_exists( 'wolf_portfolio_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function wolf_portfolio_output_content_wrapper_end() {
		wolf_portfolio_get_template( 'portfolio/wrapper-end.php' );
	}
}

if ( ! function_exists( 'wolf_portfolio_loop_start' ) ) {

	/**
	 * Output the start of a ticket loop. By default this is a UL
	 *
	 * @access public
	 * @return void
	 */
	function wolf_portfolio_loop_start( $echo = true ) {
		ob_start();
		wolf_portfolio_get_template( 'loop/loop-start.php' );
		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}


if ( ! function_exists( 'wolf_portfolio_loop_end' ) ) {

	/**
	 * Output the end of a ticket loop. By default this is a UL
	 *
	 * @access public
	 * @return void
	 */
	function wolf_portfolio_loop_end( $echo = true ) {
		ob_start();

		wolf_portfolio_get_template( 'loop/loop-end.php' );

		if ( $echo )
			echo ob_get_clean();
		else
			return ob_get_clean();
	}
}