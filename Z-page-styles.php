<?php get_header(); // Template Name: Style Guide ?>

<div id="content">
	
	<article class="wrap">

		<header class="article-header">
			<h1 class="page-title"><strong>PAGE TITLE:</strong> <?php the_title(); ?></h1>
		</header>

		<section class="entry-content">
			
			<?php the_post(); the_content(); ?>

			<hr>
			
			<h1>H1 Headline</h1>
			<p>Paragraph text following an H1 <a href="#">Headline</a> with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
			
			<h2>H2 Headline</h2>
			<p>Paragraph text following an H2 Headline with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
			
			<h1>H1 Headline</h1>
			<h3>H3 Headline following an H1</h3>
			<p>Paragraph text following an H3 Headline with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
			
			<h4>H4 Headline</h4>
			<p>Paragraph text following an H4 Headline with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
			
			<p><strong>Regular bold <em>italic text here</em></strong> with a line break<br />Paragraph text with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
			<ul>
				<li>UNORDERED LIST</li>
				<li>Another unordered list item with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</li>
				<li>Last item to this unordered list</li>
			</ul>
			<p>More paragraph text here with additional text to make it wrap so we can test line height.</p>
			
			<p>Paragraph text with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</p>
			<ol>
				<li>ORDERED LIST</li>
				<li>Another unordered list item with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height.</li>
				<li>Last item to this unordered list</li>
			</ol>
			<p>More paragraph text here with additional text to make it wrap so we can test line height.</p>
			
			<p>Paragraph text with additional <strong>bold text</strong> to make it wrap so we can test <em>italic text</em> and line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height.</p>
			
			<a class="button" href="#">Stand alone button &rsaquo;</a>
			
			<p>Additional paragraph text with <strong><em>bold italic text</em></strong> to make it wrap so we can test <em>italic text</em> and line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height. <a class="button" href="#">Inline button</a> More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height. More paragraph text here with additional text to make it wrap so we can test line height.</p>
			
		</section>

	</article>

</div>

<?php get_footer(); ?>
