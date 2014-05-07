<?php
/**
 * Golden Egg Basic Theme Functions
 *
 * @package   Egg_Functions
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
add_action( 'init', array('Egg_Functions', 'init') );

class Egg_Functions
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg';

	/**
	 * Initialize the Class
	 *
	 * @author  Jake Snyder
	 * @since	1.0.0
	 * @return	void
	 */
	public static function init()
	{
		// actions
		add_action( self::PREFIX . '/related_posts',      array(__CLASS__, 'related_posts') );
		add_action( self::PREFIX . '/page_navi',          array(__CLASS__, 'page_navi') );
	}

	/**
	 * Related Posts
	 *
	 * Usage: do_action('egg/related_posts');
	 *
	 * Based on Bones by Eddie Machado
	 *
	 * @since	0.3
	 * @return	void
	 */
	public static function related_posts()
	{
		global $post;

		echo '<ul id="bones-related-posts">';
		$tags = wp_get_post_tags( $post->ID );
		if ( $tags )
		{
			foreach( $tags as $tag )
			{
				$tag_arr .= $tag->slug . ',';
			}
			$args = array(
				'tag'          => $tag_arr,
				'numberposts'  => 5, /* you can change this to show more */
				'post__not_in' => array($post->ID)
			);
			$related_posts = get_posts( $args );
			if ( $related_posts )
			{
				foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
					<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach;
			}
			else
			{
				echo '<li class="no_related_post">No Related Posts Yet!</li>';
			}
		}
		wp_reset_postdata();
		echo '</ul>';
	}

	/**
	 * Page Navi
	 *
	 * Usage: do_action('egg/page_navi');
	 *
	 * Based on Bones by Eddie Machado
	 *
	 * @since	0.3
	 * @return	void
	 */
	public static function page_navi()
	{
		global $wp_query;

		$bignum = 999999999;
		if ( $wp_query->max_num_pages <= 1 ) return;

		echo '<nav class="pagination">';
		echo paginate_links( array(
			'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format'       => '',
			'current'      => max( 1, get_query_var('paged') ),
			'total'        => $wp_query->max_num_pages,
			'prev_text'    => '&larr;',
			'next_text'    => '&rarr;',
			'type'         => 'list',
			'end_size'     => 3,
			'mid_size'     => 3
		) );
		echo '</nav>';
	}
}