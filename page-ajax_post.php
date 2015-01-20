<?php // Template Name: pushStateAjax 
	$page_path = get_query_var( 'page_request');
	$page = get_page_by_path($page_path);
	$content = $page->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
?>


			<?php if ( $page ): ?>

			<article <?php post_class( 'cf' ); ?>>

				<header class="article-header">
					<h1 class="page-title" itemprop="headline"><?php echo get_the_title( $page->ID ); ?></h1>
				</header>

				<section class="entry-content" itemprop="articleBody">
					<?php echo $content; ?>
				</section>

			</article>

			<?php else : ?>
				<?php get_template_part( 'partials/content', 'missing' ); ?>
			<?php endif; ?>

