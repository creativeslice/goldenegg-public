<?php /** This is the default post format */ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<header class="article-header">
	
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		
		<p class="byline vcard">
		<?php printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
		</p>
	
	</header>
	
	<section class="entry-content cf" itemprop="articleBody">
	  <?php the_content(); ?>
	</section>
	
	<footer class="article-footer">
	  <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
	
	</footer>
	
	<?php comments_template(); ?>

</article>