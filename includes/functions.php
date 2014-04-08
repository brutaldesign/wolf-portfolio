<?php
/**
 * WolfPortfolio Functions
 *
 * Hooked-in functions for WolfPortfolio related events on the front-end.
 *
 * @author WpWolf
 * @category Core
 * @package WolfPortfolio/Functions
 * @version 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Handle redirects before content is output - hooked into template_redirect so is_page works.
 *
 * @access public
 * @return void
 */
function wolf_portfolio_template_redirect() {

	if ( is_page( wolf_portfolio_get_page_id() ) ) {

		$old_template = is_file( get_template_directory() . '/page-templates/portfolio.php' );

		if ( $old_template ) {
			wolf_portfolio_get_template( 'page-templates/portfolio.php' );
		} else {
			wolf_portfolio_get_template( 'portfolio-template.php' );
		}
		exit();

	}
	
}

if ( ! function_exists( 'wolf_work_meta' ) ) {
	/**
	 * Display work meta
	 *
	 * @return string
	 */
	function wolf_work_meta() {

		$post_id = get_the_ID();
		$client = get_post_meta( $post_id, '_work_client', true );
		$link = get_post_meta( $post_id, '_work_link', true );
		
		// Translators: used between list items, there is a space after the comma.
		$skills = get_the_term_list( $post_id, 'work_type', '', __( ', ', 'wolf' ), '' );

		$format_prefix = ( has_post_format( 'chat' ) || has_post_format( 'status' ) ) ? _x( '%1$s on %2$s', '1: post format name. 2: date', 'wolf' ): '%2$s';

		$date = sprintf( '<time class="work-date" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ( $date ) : ?>
		<span class="work-meta">
			<span class="work-date"><?php printf( __( 'On %s', 'wolf' ), $date ); ?></span>
			<span class="work-meta-separator"> / </span>
		</span><!-- span.work-meta -->
		<?php endif; ?>
		
		<?php if ( $client ) : ?>
		<span class="work-meta">
			<span class="work-client"><?php printf( __( 'For %s', 'wolf' ), $client ); ?></span>
			<span class="work-meta-separator"> / </span>
		</span><!-- span.work-meta -->
		<?php endif; ?>

		<?php if ( $skills ) : ?>
		<span class="work-meta">
			<span class="work-taxonomy"><?php printf( __( 'in %s', 'wolf' ), $skills ); ?></span>
			<span class="work-meta-separator"> / </span>
		</span><!-- span.work-meta -->
		<?php endif; ?>

		<?php if ( $link ) : ?>
		<span class="work-meta">
			<a class="work-link" href="<?php echo $link; ?>" target="_blank"><?php _e( 'Launch Project', 'wolf' ); ?></a>
		</span><!-- span.work-meta -->
		<?php endif;

	}
}