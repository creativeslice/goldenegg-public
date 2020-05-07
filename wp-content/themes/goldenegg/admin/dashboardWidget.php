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
	/* REPORTING */
	.boxWrapper {
		display: flex;
		padding-bottom: 20px;
	}
	.reportBox {
		width: 330px;
		border: 4px solid black;
		padding: 20px 10px 10px 10px;
		margin: 10px 10px 10px 0;
		/*display: flex;
		justify-content: space-between;
		*/
	}
	.reportTitle {
		padding: 10px 0;
		color: #999;
	}
	.reportTitle strong {
		color: #000;
	}
	
	.reportBox h3 {
		margin: 14px 0px 0 0;
		width: 120px;
		line-height: 1.25em;
		display: inline-block;
		vertical-align: top;
	}
	.stat {
		width: 90px;
		border-left: 1px solid #eee;
		padding-left: 10px;
		display: inline-block;
		vertical-align: top;
	}
	.stat h5 {
		margin: 2px 0 0 0;
		line-height: 1.25em;
		color: #999;
	}
	.stat .big {
		font-size: 36px;
		line-height: 36px;
		display: block;
		font-weight: bold;
		color: #999;
	}
	.stat .big em {
		font-size: 20px;
		line-height: 20px;
		font-weight: 400;
		font-style: normal;
	}
	.stat.more .big {
		color: #339933;
	}
	.stat.less .big {
		color: darkred;
	}
	.reportBox table {
		margin-top: 1em;
		width: 100%;
		border: 1px solid #eee;
		text-align: left;
		font-size: .875em;
	}
	.reportBox table tbody tr:nth-child(odd) {
		background: #eee;
	}
</style>

<div id="care-plan-cslice" class="welcome-panel">
	<div class="welcome-panel-content">
		<img style="float: left; margin: 0px 8px 0 0; width: 48px; height: 48px;" src="<?php echo get_template_directory_uri(); ?>/admin/assets/img/cs_140.png" alt="Creative Slice" />
		<h2><span style="color: #339933">Creative Slice</span> Care Plan</h2>
		<p class="about-description">Keeping your site continuously improving.</p>
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

				<?php // Editor & Admin Only
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
		
		<div class="welcome-panel-column-container">

			<hr>
			<h2 class="reportTitle">Monthly Reporting: <strong><?php echo date('F, Y'); ?></strong></h2>
			
			
			<div class="boxWrapper">
				<?php // This month
				$current_month = date('mY');
				
				$args = array(
				  'post_type'   => 'page',
				  'orderby' => 'modified',
				);
				$modified_pages = get_posts( $args );
				$current = 0;
				$past = 0;
				foreach ( $modified_pages as $post ) :
					if (get_the_modified_time( 'mY', $post ) == $current_month) {
						$current++;
					} else {
						$past++;
					}
					//echo '<hr>' . get_the_modified_time( 'mY', $post); 
				endforeach;
				//$count_pages = wp_count_posts( $count_pages);
				
				if ($current > $past) {
					$style = 'more';
				} elseif ($current < $past) {
					$style = 'less';
				} else {
					$style = 'same';
				}
				?>
				<div class="reportBox">
					<h3>Page Content</h3>
					<div class="stat <?php echo $style; ?>">
						<span class="big"><?php echo $current; ?></span>
						<h5>modified</h5>
					</div>
					<div class="stat">
						<span class="big"><?php echo $past; ?></span>
						<h5>last month</h5>
					</div>
				</div>
				
				
				
				<?php // ACF Repeater 
					$performance_tracking = get_field('performance_tracking', 'options');
					$first_row = $performance_tracking[0]; // get the first row
					$first_pagespeed = $first_row['pagespeed' ];
					$first_loading = $first_row['loading_time' ];
					
				?>
				<div class="reportBox">
					<h3>Performance</h3>
					
					<?php if ($first_pagespeed > 90) { ?>
						<div class="stat more">
							<span class="big">A <em><?php echo $first_pagespeed; ?>%</em></span>
							<h5>PageSpeed</h5>
						</div>
					<?php } else { ?>
						<div class="stat">
							<span class="big"><?php echo $first_pagespeed; ?>%</span>
							<h5>PageSpeed</h5>
						</div>
					<?php } ?>

					<div class="stat more">
						<span class="big"><?php echo $first_loading; ?></span>
						<h5>Loading time</h5>
					</div>
					<table>
						<thead>
							<tr>
								<th>Date</th>
								<th>Pagespeed</th>
								<th>Loading Time</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($performance_tracking as $row) { ?>
							<tr>
								<td><?php echo $row['date']; ?></td>
								<td><?php echo $row['pagespeed']; ?></td>
								<td><?php echo $row['loading_time']; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				
				
				<div class="reportBox">
					<h3>EXAMPLE</h3>
					<div class="stat less">
						<span class="big">304</span>
						<h5>logins</h5>
					</div>
					<div class="stat">
						<span class="big">312</span>
						<h5>last month</h5>
					</div>
				</div>
			
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