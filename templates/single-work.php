<?php
/**
 * The Template for displaying single work.
 *
 */
get_header( 'portfolio' );
?>
	<div class="work-container">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<header class="work-header">

					<?php the_title( '<h1 class="work-title">', '</h1>' ); ?>
					
					<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
					<div class="work-thumbnail">
						<?php the_post_thumbnail( 'extra-large' ); ?>
					</div>
					<?php endif; ?>
					
				</header><!-- header.work-header -->

				<div class="work-meta-container">
					<?php wolf_work_meta(); ?>
				</div><!-- .work-meta-container -->

				<div class="work-content">
					<?php the_content(); ?>
				</div><!-- .work-content -->

				<?php edit_post_link( __( 'Edit', 'wolf' ), '<span class="work-edit-link">', '</span>' ); ?>
			</article><!-- article#post -->

			<?php //comments_template(); ?>
		
		<?php endwhile; ?>
		
		<?php wolf_work_nav(); ?>

	</div><!-- .work-container -->

<?php get_footer( 'portfolio' ); ?>