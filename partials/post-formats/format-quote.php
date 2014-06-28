<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<header class="article-header">
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php get_template_part( '/partials/content', 'byline' ); ?>
	</header>

	<section class="entry-content cf" itemprop="articleBody">
		<?php the_content(); ?>
	</section>

	<footer class="article-footer">
		<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>
		<?php get_template_part( 'partials/content-share-links' ); ?>
	</footer>

	<?php comments_template(); ?>

</article>