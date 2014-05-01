<article <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
	<header class="article-header">
	
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		
		<?php get_template_part( 'partials/content', 'byline' ); ?>
		
    </header>
					
    <section class="entry-content clearfix" itemprop="articleBody">
    
		<?php the_post_thumbnail('full'); ?>
		
		<?php the_content(); ?>
		
	</section>
									
	<?php comments_template(); ?>	
													
</article>