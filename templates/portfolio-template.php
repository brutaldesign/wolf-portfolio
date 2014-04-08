<?php
/**
 * The Template for displaying the main portfolio page
 *
 * Override this template by copying it to yourtheme/wolf-portfolio/portfolio-template.php
 *
 * @author WpWolf
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'portfolio' ); 

if ( get_query_var( 'paged' ) ) {

	$paged = get_query_var( 'paged' );

} elseif ( get_query_var( 'page' ) ) {

	$paged = get_query_var( 'page' );

} else {

	$paged = 1;

}

$args = array(
	'post_type' => 'work',
	'meta_key'    => '_thumbnail_id',
	'posts_per_page' => -1,
	//'paged' => $paged
);

/* Work Post Loop */
$loop = new WP_Query( $args );
?>
	<div class="work-container">
		<?php if ( $loop->have_posts() ) : ?>
			
			<?php
				/**
				 * Work Category Filter
				 */
				wolf_portfolio_get_template( 'filter.php' );
			?>
			
			<?php wolf_portfolio_loop_start(); ?>
				
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				
					<?php wolf_portfolio_get_template_part( 'content', 'work' ); ?>
				
				<?php endwhile; ?>
			
			<?php wolf_portfolio_loop_end(); ?>
			
			<?php else : ?>

				<?php wolf_portfolio_get_template( 'loop/no-work-found.php' ); ?>
			
			<?php endif; // end have_posts() check ?>
	</div><!-- .work-container -->
<?php get_footer( 'portfolio' ); ?>