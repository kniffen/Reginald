<?php
/**
 * Custom theme functions
 *
 * @package Reginald
 * @since Reginald 1.1.0
 */

/**
	* Social media icons
	*
	* @since Reginald 1.2.1
	*/
$reginald_social_media_icons = array(
	'Twitter'				=>	'fa-twitter',
	'Facebook'			=>	'fa-facebook',
	'Instagram'			=>	'fa-instagram',
	'Vine'					=>	'fa-vine',
	'LinkedIn'			=>	'fa-linkedin',
	'Google+'				=>	'fa-google-plus',
	'YouTube'				=>	'fa-youtube',
	'Twitch'				=>	'fa-twitch',
	'Vimeo'					=>	'fa-vimeo',
	'Pinterest'			=>	'fa-pinterest',
	'Reddit'				=>	'fa-reddit-alien',
	'Steam'					=>	'fa-steam',
	'Flickr'				=>	'fa-flickr',
	'Tumblr'				=>	'fa-tumblr',
	'Spotify'				=>	'fa-spotify',
	'Soundcloud'		=>	'fa-soundcloud',
	'MixCloud'			=>	'fa-mixcloud',
	'GitHub'				=>	'fa-github',
	'BitBucket'			=>	'fa-bitbucket',
	'Behance'				=>	'fa-behance',
	'LastFM'				=>	'fa-lastfm',
);

function reginald_any_social_icons(){
	global $reginald_social_media_icons;

	if( get_theme_mod( 'social_media_rss' ) ) return true;

	foreach( $reginald_social_media_icons as $service => $icon ){
		if( get_theme_mod( 'social_media_'.strtolower($service) ) ) return true;
	}

	return false;
}

function reginald_social_media(){
	if( !reginald_any_social_icons() ) return;

	global $reginald_social_media_icons; ?>

	<ul id="reginald-social-media-links">
		<?php if(get_theme_mod( 'social_media_rss' )): ?>
			<li>
				<a title="<?php esc_attr( bloginfo('rss2_url') ); ?>" href="<?php esc_url( bloginfo('rss2_url') ); ?>" target="_blank">
					<i class="fa fa-rss"></i>
				</a>
			</li>
		<?php endif;

		foreach( $reginald_social_media_icons as $service => $icon ):
			if( get_theme_mod( 'social_media_'.strtolower($service) ) ): ?>
				<li>
					<a title="<?php echo esc_attr($service); ?>" href="<?php echo esc_url( get_theme_mod( 'social_media_'.strtolower($service) ) ); ?>" target="_blank">
						<i class="fa <?php echo esc_attr($icon); ?>"></i>
					</a>
				</li>
			<?php endif;
		endforeach; ?>
	</ul>
<?php }


/**
	* Breadcrumbs
	*
	* @since Reginald 1.1.0
	*/
function reginald_breadcrumbs(){
	if( get_theme_mod('breadcrumbs', false) ): ?>
		<div class="reginald-breadcrumbs">
			<?php // Home
				printf( '<span><a href="%1$s">%2$s</a></span>',
					esc_url( home_url() ),
					get_bloginfo('name')
				);
			?>

			<?php // Category
				if( is_singular() && has_category() ){ ?>
					<span><?php the_category(', '); ?></span>
				<?php }elseif( is_archive() ){
					the_archive_title('<span>', '</span>');
				}
			?>

			<?php // Page hirearchy
				if( is_page() ){
					$ancestors = get_post_ancestors($post);

					if($ancestors){
						$ancestors = array_reverse($ancestors);

						foreach ($ancestors as $crumb) {
							printf( '<span><a href="%1$s">%2$s</a></span>',
								esc_url( get_permalink($crumb) ),
								get_the_title($crumb)
							);
						}
					}
				}
			?>

			<?php // Singular
				if( is_singular() ){
					the_title('<span>', '</span>');
				}
			?>
		</div>
	<?php endif;
}