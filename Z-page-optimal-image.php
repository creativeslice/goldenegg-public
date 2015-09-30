<?php get_header(); // Template Name: Optimal Image ?>

<div id="content">

	<div class="wrap">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class(); ?>>

			<header class="article-header">
				<h1 class="page-title"><strong>PAGE TITLE:</strong> <?php the_title(); ?></h1>
			</header>

			<section class="entry-content">
				
				<?php the_content(); ?>

				<hr>


<h1>Requires <a target="_blank" href="https://bitbucket.org/tripgrass/optimal-image">Optimal Image plugin/function</a></h1>

<h2>Hard Coded img_1000x700.jpg and img_600x400.jpg</h2>
<?php $args = array (
	'image'	=> get_template_directory_uri() . '/assets/img/img_600x400.jpg',
	'width' => 600,
	'height' => 400,
	'desktop_image'	=> get_template_directory_uri() . '/assets/img/img_1000x700.jpg',
	'desktop_width' => 1000,
	'desktop_height' => 700,
	'lazy'	=> 'load'
); optimal_image( $args );
?>

<hr>

<h2>Featured Image</h2>
<?php $args = array (
	'post'	=> $post,
	'lazy'	=> 'load'
); optimal_image( $args );
?>

<hr>

<h2>ACF Gallery</h2>
<?php $images = get_field('acf_gallery');
if( $images ): ?>
<ul>
    <?php foreach( $images as $image ): ?>
    <?php $args = array (
		'image'		=> $image,
		'mobile'	=> 'thumbnail',
		'desktop'	=> 'large',
		'lazy'		=> 'load'
	); ?>
	<li>
		<a href="<?php echo $image['url']; ?>">
			<?php optimal_image( $args ); ?>
		</a>
		<p><?php echo $image['caption']; ?></p>
	</li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>



				
			</section>

		</article>

		<?php endwhile; endif; ?>

	</div>

</div>

<?php get_footer(); ?>