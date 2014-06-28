<?php get_header(); // Template Name: Style Guide ?>

<div id="content">

	<div class="wrap">

		<div id="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class(); ?>>

				<header class="article-header">
					<h1 class="page-title"><strong>PAGE TITLE:</strong> <?php the_title(); ?></h1>
				</header>

				<section class="entry-content">
					
					<?php the_content(); ?>
					
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
					
					<hr>
					
					<div class="cf">
						<h2>Simple Golden Ratio</h2>
						<div class="goldlarge">
							<p><strong>goldlarge</strong><br />Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="goldsmall">
							<p><strong>goldsmall</strong><br /> Right sidebar</p>
						</div>
						
						<div class="goldlarge last-col">
							<p><strong>goldlarge last-col</strong><br /> Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="goldsmall first-col">
							<p><strong>goldsmall first-col</strong><br />Right sidebar</p>
						</div>

					</div>
					
					<hr>
					
					<div class="cf">
						<h2>Fonmon Grid</h2>
						<div class="l-g1 m-g1 s-all">
							<p><strong>l-g1 m-g1 s-all</strong><br /> Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="l-g2 m-g2 s-g1">
							<p><strong>l-g2 m-g2 s-g1</strong><br /> Text here</p>
						</div>
						<div class="l-g2-g3 m-g1 m-last s-g2 s-last">
							<p><strong>l-g2-g3 m-g1 m-last s-g2 s-last</strong><br /> Text here too</p>
						</div>
						<div class="l-g1 m-all s-all l-last">
							<p><strong>l-g1 m-all s-all l-last</strong><br /> Far right column</p>
						</div>
					</div>
					
					<hr>
					
					<div class="cf">
						<h2>Gerstner Grid</h2>
						<div class="l-g2 m-g1 s-all first-col">
							<p><strong>l-g2 m-g1 s-all first-col</strong><br /> Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="l-g1 m-g1 s-g1">
							<p><strong>l-g1 m-g1 s-g1</strong><br /> Text here</p>
						</div>
						<div class="l-g1 m-g1 s-g1 s-last">
							<p><strong>l-g1 m-g1 s-g1 s-last</strong><br /> Text here too</p>
						</div>
						<div class="l-g2 m-g1 s-all l-last m-last">
							<p><strong>l-g2 m-g1 s-all l-last m-last</strong><br /> Far right column</p>
						</div>
					</div>
					
					<hr>
					
					<div class="cf">
						<h2>Golden Ratio</h2>
						<div class="l-g1 m-g1 s-g1 first-col">
							<p><strong>l-g1 m-g1 s-g1 first-col</strong><br /> Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="l-g2 m-g2 s-g2">
							<p><strong>l-g2 m-g2 s-g2</strong><br /> Text here</p>
						</div>
						<div class="l-g3 m-g3 s-g1">
							<p><strong>l-g3 m-g3 s-g1</strong><br /> Text here too</p>
						</div>
						<div class="l-g4 m-all s-g2 last-col">
							<p><strong>l-g4 m-all s-g2 last-col</strong><br /> Far right column</p>
						</div>
					</div>
					
					<hr>
					
					<div class="cf">
						<div class="l-g1-g2 m-g1-g2 s-g1">
							<p><strong>l-g1-g2 m-g1-g2 s-g1</strong><br />Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="l-g3-g4 m-g3 s-g2 last-col">
							<p><strong>l-g3-g4 m-g3 s-g2 last-col</strong><br /> Right sidebar</p>
						</div>
					</div>
					
					<hr>
					
					<div class="cf">
						<div class="l-g1-g3 m-g1-g2 s-all">
							<p><strong>l-g1-g3 m-g1-g2 s-all</strong><br />Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="l-g4 m-g3 s-all last-col">
							<p><strong>l-g4 m-g3 s-all last-col</strong><br /> Right sidebar</p>
						</div>
					</div>
					
					<hr>
					
					<div class="cf">
						<div class="l-g1 m-g1 s-g1 first-col">
							<p><strong>l-g1 m-g1 s-g1 first-col</strong><br /> Just some text here to see how it wraps and see how the padding works, or if it works at all...</p>
						</div>
						<div class="l-g3-g4 m-g3 s-all last-col">
							<p><strong>l-g3-g4 m-g3 s-all last-col</strong><br /> Far right column</p>
						</div>
					</div>
					
					<hr>

				</section>

			</article>

			<?php endwhile; endif; ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
