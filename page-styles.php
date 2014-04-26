<?php get_header(); // Template Name: Style Guide ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<div id="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="article-header">
					<h1 class="page-title"><strong>PAGE TITLE:</strong> <?php the_title(); ?></h1>
				</header>

				<section class="entry-content">
					
					<?php the_content(); ?>
					
					<hr>
					
					<h1>Simple H1 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</h1>
					<h2>Simple H2 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</h2>
					<h3>Simple H3 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</h3>
					<h4>Simple H4 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</h4>
					<h5>Simple H5 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</h5>
					
					<hr>
					
					<h1>H1 Headline</h1>
					<p>Paragraph text following an H1 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
					
					<hr>
					
					<h2>H2 Headline</h2>
					<p>Paragraph text following an H2 Headline with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
					
					<hr>
					
					<h1>H1 Headline</h1>
					<h3>H3 Headline following an H1</h3>
					<p>Paragraph text following an H3 Headline with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
					
					<hr>
					
					<h4>H4 Headline</h4>
					<p>Paragraph text following an H4 Headline with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
					
					<hr>
					
					<p><strong>Regular bold <em>italic text here</em></strong> with a line break<br />Paragraph text with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
					<ul>
						<li>UNORDERED LIST</li>
						<li>Another unordered list item with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</li>
						<li>Last item to this unordered list</li>
					</ul>
					<p>More paragraph text here with additional text to make it wrap so we can test line height.</p>
					
					<hr>
					
					<p>Paragraph text with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
					<ol>
						<li>ORDERED LIST</li>
						<li>Another unordered list item with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</li>
						<li>Last item to this unordered list</li>
					</ol>
					<p>More paragraph text here with additional text to make it wrap so we can test line height.</p>
					 
					 <hr>
					
					<p>Paragraph text with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height.</p>
					
					<a class="button" href="#">Stand alone button &rsaquo;</a>
					
					<p>Additional paragraph text with <strong><em>bold italic text</em></strong> to make it wrap so we can test <em>italic text</em> and line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height. <a class="button" href="#">Inline button</a> More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height.</p>
					
				</section>

				<footer class="article-footer cf">

				</footer>

			</article>

			<?php endwhile; endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
