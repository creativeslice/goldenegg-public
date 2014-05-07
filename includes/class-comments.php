<?php
/**
 * Golden Egg Customize Comments
 *
 * @package   Egg_Comments
 * @author    Jacob Snyder <jake@jcow.com>
 * @license   GPL-2.0+
 * @link      http://goldenegg.io/
 * @copyright 2014 Creative Slice
 */
class Egg_Comments
{
	/**
	 * Class prefix
	 *
	 * @since 	1.0.0
	 * @var 	string
	 */
	const PREFIX = 'egg_comments';

	/**
	 * Update comments layout
	 *
	 * @since	1.0.0
	 * @return	string Empty string
	 */
	public static function comments( $comment, $args, $depth )
	{
		$GLOBALS['comment'] = $comment; ?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
			<article  class="cf">
				<header class="comment-author vcard">
					<?php echo get_avatar($comment,$size='32',$default='<path_to_url>' ); ?>
					<?php printf( '<cite class="fn">%1$s</cite> %2$s', get_comment_author_link(), edit_comment_link( '(Edit)','  ','') ) ?>
					<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time( 'F jS, Y' ); ?> </a></time>
				</header>
				<?php if ($comment->comment_approved == '0') : ?>
					<div class="alert alert-info">
						<p>Your comment is awaiting moderation.</p>
					</div>
				<?php endif; ?>
				<section class="comment_content cf">
					<?php comment_text() ?>
				</section>
				<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']) ) ) ?>
			</article>
		<?php // </li> is added by WordPress automatically
	}
}