	
			<footer id="page-footer" role="contentinfo">
				<div class="container">
					
					<!-- Column 1: Navigation -->
					<nav class="footer-nav" role="navigation">
						<a class="logo" href="<?php bloginfo('url'); ?>" title="SHARE Home"></a>
						<?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>
					</nav>

					<!-- Column 2: Mailing list -->
					<div class="mailing-list">
						<h6>Sign up for updates</h6>
						<script type="text/javascript" src="http://arl.formstack.com/forms/js.php?1772252-EuxYverMiG-v3"></script><noscript><a href="http://arl.formstack.com/forms/stay_informed_signup__copy" title="Online Form">Online Form - SHARE Update signup form</a></noscript>
					</div>

					<!-- Column 3: Twitter feed -->
					<div class="twitter-feed">
						<?php if (get_field('twitter_replacement', 'option')) { ?>
						<div class="twitter-replacement">
							<?php the_field('twitter_replacement', 'option'); ?>
						</div> <!-- .twitter-replacement -->
						<?php } else { ?>
						<h6 class="twitter-logo"><a href="http://twitter.com/SHARE_research" target="_blank" title="SHARE on Twitter">@SHARE_research</a></h6>
						<div class="tweet"></div>
						<?php } ?>
					</div>

					<!-- Column 4: Social/copyright info -->
					<div class="social-copyright">
						<?php // Grab social media links from Site-wide Options page
						if(get_field('social_media_links', 'option')): ?>
						<ul class="social ss-icon">
							<?php while(has_sub_field('social_media_links', 'option')): ?>
							<li><a href="<?php the_sub_field('url'); ?>" target="_blank" class="ss-<?php the_sub_field('icon'); ?>" title="<?php the_sub_field('title'); ?>"></a></li>
							<?php endwhile; ?>
						</ul>
						<?php endif; ?>
						
						<?php if (get_field('copyright_information', 'option')) {
							the_field('copyright_information', 'option');
						} ?>
						<?php if (get_field('address', 'option')) { ?>
							<address><?php the_field('address', 'option'); ?></address>
						<?php } ?>
					</div>

					<div class="clearfix"></div>
				</div> <!-- .container -->
			</footer>

			<div class="sub-footer">
				<div class="container">
					
					<nav class="sub-footer-nav" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'sub-footer-menu' ) ); ?>
					</nav>

				</div>
			</div>
		
		</div>

		<?php wp_footer(); ?>
		<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
		<script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/twitter/jquery.tweet.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>

	</body>
</html>