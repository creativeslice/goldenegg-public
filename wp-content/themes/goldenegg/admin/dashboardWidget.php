<?php
/**
 *	Adds hidden content to admin_footer, then shows with jQuery, and inserts after welcome panel
 */
add_action( 'admin_footer', 'rv_custom_dashboard_widget' );
function rv_custom_dashboard_widget() {
	if ( get_current_screen()->base !== 'dashboard' ) {
		return;
	}
?>

<style>
	.greenButton {
		background: #339933 !important;
		border-color: #339933 !important;
		color: white !important;
	}
	.grayButton {
		background: #444 !important;
		border-color: #222 !important;
		color: white !important;
	}
	.welcome-panel-column a {
		color: #339933;
		text-decoration: none;
	}
	.welcome-panel-column a:hover {
		text-decoration: underline;
	}
	.welcome-icon:before {
		top: -1px;
	}
</style>

<div id="care-plan-cslice" class="welcome-panel">
	<div class="welcome-panel-content">
		<img style="float: left; margin: 0px 8px 0 0; width: 48px; height: 48px;" src="<?php echo get_template_directory_uri(); ?>/admin/assets/img/cs_140.png" alt="Creative Slice" />
		<h2><span style="color: #339933">Creative Slice</span> Care Plan</h2>
		<p class="about-description">Keeping your site continuosly improving.</p>
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column">
				<h3>Support</h3>
				<a target="_blank" class="button button-hero greenButton" href="#">Ask a Question</a>
				<a target="_blank" class="button button-hero grayButton" href="#">Report a Bug</a>
				<p>or, <a target="_blank" href="https://calendly.com/">schedule a meeting.</a></p>
				<br>
				<ul>
					<li><a target="_blank" href="https://my.wpengine.com" class="welcome-icon dashicons-sos">24/7 Support with WPEngine (your web host)</a></li>
				</ul>
			</div>
			<div class="welcome-panel-column">
				<h3>Shortcuts</h3>
				<ul>

				<?php // Editor Only
				if (current_user_can( 'edit_posts' )) : ?>
					<li><a href="#" class="welcome-icon dashicons-megaphone">Notices</a></li>
					<li><a href="/wp-admin/nav-menus.php" class="welcome-icon dashicons-menu">Update Menu</a></li>
					<li><a href="#" class="welcome-icon dashicons-archive">Edit Footer</a></li>
				<?php endif; ?>

					<li><a href="#" class="welcome-icon welcome-setup-home">Edit front page</a></li>
					<li><a href="/wp-admin/post-new.php?post_type=page" class="welcome-icon welcome-add-page">Add additional pages</a></li>
					<li><a href="/wp-admin/post-new.php" class="welcome-icon welcome-write-blog">Add a new post</a></li>
				</ul>
			</div>
			<div class="welcome-panel-column">
				<h3>Instructions</h3>
				<ul>
					<li><a href="#" class="welcome-icon welcome-learn-more">Website User Guide</a></li>
					<li><a href="#" class="welcome-icon dashicons-editor-help">Website User Guide</a></li>
					<li><a href="/" class="welcome-icon welcome-view-site">View your site</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		$('#welcome-panel').before($('#care-plan-cslice').show());
	});
</script>

<?php }