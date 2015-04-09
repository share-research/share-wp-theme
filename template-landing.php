				<?php 
				/*
					Template Name: Landing
				*/
				get_header(); ?>

				<section id="content" role="main">
					
					<div class="banner">
						<div class="container">
							<div class="text">
								<p><?php the_field('banner_description'); ?></p>
							</div>

							<div class="buttons">
								<a class="button primary" href="<?php the_field('banner_primary_button_url'); ?>">
									<?php the_field('banner_primary_button_text'); ?>
								</a>
								<?php if (get_field('banner_secondary_button_text') && get_field('banner_secondary_button_url')) { ?>
									<a class="button secondary" href="<?php the_field('banner_secondary_button_url'); ?>">
										<?php the_field('banner_secondary_button_text'); ?>
									</a>
								<?php } ?>
							</div>

							<div class="clearfix"></div>
						</div> <!-- .container -->
					</div> <!-- .banner -->

					<?php
					// check if the flexible content field has rows of data
					if( have_rows('flexible_content') ):
						// loop through the rows of data
						while ( have_rows('flexible_content') ) : the_row();

							if( get_row_layout() == 'standard_text_block' ): ?>

					<div class="standard-text-block">
						<h2><?php the_sub_field('headline'); ?></h2>
						<?php if (get_sub_field('image')) {
							$image = get_sub_field('image'); ?>
						<img class="image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php } ?>
						<div class="text">
							<?php the_sub_field('text_content'); ?>
						</div>
						<div class="clearfix"></div>
					</div> <!-- .standard-text-block -->

					<?php
							elseif( get_row_layout() == 'blue_callout_block' ): ?>

					<div class="blue-callout-block">
						<div class="description">
							<h2><?php the_sub_field('headline'); ?></h2>
							<div class="text">
								<?php the_sub_field('text_content'); ?>
							</div>
							<a class="button tertiary" href="<?php the_sub_field('action_button_url'); ?>">
								<?php the_sub_field('action_button_text'); ?>
							</a>
						</div>

						<?php if (get_sub_field('image')) {
							$image = get_sub_field('image'); ?>
						<img class="image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php } ?>
						<div class="clearfix"></div>
					</div> <!-- .blue-callout-block -->

					<?php
							endif;
						endwhile;
					else :
						// no layouts found! oh the humanity!
						// not showing nothin'
					endif;
					?>

					<div class="clearfix"></div>
				</section>

				<?php get_footer(); ?>