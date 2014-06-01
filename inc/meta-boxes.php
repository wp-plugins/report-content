<?php

/*--------------------------------------------------
	Registering Meta Boxes
----------------------------------------------------*/

add_action( 'load-post.php', 'wprc_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'wprc_post_meta_boxes_setup' );

function wprc_post_meta_boxes_setup() {
	$other_options = get_option('wprc_other_settings');
	$permission_options = get_option('wprc_permissions_settings');
	if($other_options['disable_metabox'] || !current_user_can($permission_options['minimum_role_view'])) return;
	add_action( 'add_meta_boxes', 'wprc_add_post_meta_boxes' );
}

function wprc_add_post_meta_boxes() {
	add_meta_box(
		'wprc-post-reports',			// Unique ID
		esc_html__( 'Post Reports', 'wprc' ),		// Title
		'wprc_meta_box_callback',		// Callback function
		'post',					// Admin page (or post type)
		'normal',					// Context
		'default'					// Priority
	);
}

function wprc_meta_box_callback( $object, $box ) {
	$post_reports = wprc_get_post_reports($object->ID);
	if(count($post_reports)<=0):
	?>
		No reports found.
	<?php else: ?>
		<style type="text/css">
			#wprc-reports{ width:100%; border-collapse: collapse;text-align: left;}
			#wprc-reports td, #wprc-reports th{padding: 6px;min-width: 160px; border-bottom: 1px solid #E7E7E7;}
			#wprc-reports .even{background: #e7e7e7;}
			#wprc-reports th { font-size: medium; }
		</style>
		<table id="wprc-reports">
			<tr>
				<th>Issue</th>
				<th>Details</th>
			</tr>
			<?php foreach ($post_reports as $key => $report): ?>
				<tr class="<?php echo ($key%2 == 0)?'even':'odd'; ?>">
					<td><?php echo $report['reason']; ?></td>
					<td><?php echo $report['details']; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php
	endif;
}

?>