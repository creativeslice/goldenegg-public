<?php

/**
 * Update comments layout
 *
 * @return	string Empty string
 */
function egg_comments( $comment, $args, $depth )
{
	$GLOBALS['comment'] = $comment; ?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
		<article  class="cf">
			<header class="comment-author vcard">
				<?php echo get_avatar($comment,$size='32',$default=get_template_directory_uri().'/assets/img/mysteryman.jpg' ); ?>
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

/**
 * List comments
 */

// don't load it if you can't comment
if ( post_password_required() ) return; ?>

<section class="comments cf">

	<?php if ( have_comments() ) : ?>

		<h3 id="comments-title" class="h2"><?php comments_number( '<span>No</span> Comments', '<span>1</span> Comment', '<span>%</span> Comments' );?></h3>

		<div class="commentlist">
			<?php
			wp_list_comments( array(
				'style'             => 'div',
				'short_ping'        => true,
				'avatar_size'       => 40,
				'callback'          => 'egg_comment',
				'type'              => 'all',
				'reply_text'        => 'Reply',
				'page'              => '',
				'per_page'          => '',
				'reverse_top_level' => null,
				'reverse_children'  => ''
			) );
			?>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment-navigation" role="navigation">
				<div class="comment-nav-prev"><?php previous_comments_link('&larr; Previous Comments'); ?></div>
				<div class="comment-nav-next"><?php next_comments_link('More Comments &rarr;'); ?></div>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments">Comments are closed.</p>
		<?php endif; ?>

	<?php endif;

	comment_form( array(
		'title_reply'          => "Join the discussion",
		'comment_notes_before' => "",
		'comment_notes_after'  => "",
		'label_submit'         => "Reply",
		'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Leave a Comment"></textarea></p>'
	) ); ?>

</section>