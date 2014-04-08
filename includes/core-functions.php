<?php
/**
 * WolfPortfolio Core Functions
 *
 * Functions available on both the front-end and admin.
 *
 * @author WpWolf
 * @category Core
 * @package WolfPortfolio/Functions
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'wolf_portfolio_get_page_id' ) ) {

	/**
	 * wolf_portfolio page ID
	 *
	 * retrieve page id - used for the main portfolio page
	 *
	 * @return int
	 */
	function wolf_portfolio_get_page_id() {
		
		$page_id = -1;

		if ( -1 != get_option( '_wolf_portfolio_page_id' ) && get_option( '_wolf_portfolio_page_id' ) ) {
			
			$page_id = get_option( '_wolf_portfolio_page_id' );
		
		} else {
			// back compatibility with the old template system
			$templates = array( 
				'portfolio-template.php',
				'page-templates/portfolio.php',
			);

			foreach ( $templates as $template ) {

				$pages = get_pages( array(
					'meta_key' => '_wp_page_template',
					'meta_value' => $template
				) );
				if ( $pages && isset( $pages[0] ) ) {
					$page_id = $pages[0]->ID;
					break;
				}
			}
		}

		return $page_id;

	}
}

if ( ! function_exists( 'wolf_get_portfolio_url' ) ) {
	/**
	 * Returns the URL of the portfolio page
	 */
	function wolf_get_portfolio_url() {
		
		$page_id = wolf_portfolio_get_page_id();

		if ( -1 != $page_id )
			return get_permalink( $page_id );

	}
}

if ( ! function_exists( 'wolf_portfolio_get_option' ) ) {
	/**
	 * Get Portfolio option
	 *
	 * @access public
	 * @param string
	 * @return void
	 */
	function wolf_portfolio_get_option( $value, $default = null ) {

		global $wolf_portfolio;
		return $wolf_portfolio->get_option( $value, $default );

	}
}

if ( ! function_exists( 'wolf_work_nav' ) ) {
	/**
	 * Displays navigation to next/previous post when applicable.
	 *
	 *
	 * @access public
	 * @return string/bool
	 */
	function wolf_work_nav() {
		
		global $wolf_portfolio;
		return $wolf_portfolio->navigation();

	}
}

/**
 * Get template part (for templates like the release-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function wolf_portfolio_get_template_part( $slug, $name = '' ) {
	global $wolf_portfolio;
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/wolf-portfolio/slug-name.php
	if ( $name )
		$template = locate_template( array( "{$slug}-{$name}.php", "{$wolf_portfolio->template_url}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $wolf_portfolio->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = $wolf_portfolio->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wolf-portfolio/slug.php
	if ( ! $template )
		$template = locate_template( array( "{$slug}.php", "{$wolf_portfolio->template_url}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}

/**
 * Get other templates (e.g. ticket attributes) passing attributes and including the file.
 *
 * @access public
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function wolf_portfolio_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	global $wolf_portfolio;

	if ( $args && is_array($args) )
		extract( $args );

	$located = wolf_portfolio_locate_template( $template_name, $template_path, $default_path );

	do_action( 'wolf_portfolio_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'wolf_portfolio_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @access public
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function wolf_portfolio_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	global $wolf_portfolio;

	if ( ! $template_path ) $template_path = $wolf_portfolio->template_url;
	if ( ! $default_path ) $default_path = $wolf_portfolio->plugin_path() . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters( 'wolf_portfolio_locate_template', $template, $template_name, $template_path );
}
