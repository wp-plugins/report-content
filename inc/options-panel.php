<?php
/*
The settings page
*/

function wprc_menu_item() {
	global $wprc_settings_page_hook;
    $wprc_settings_page_hook = add_submenu_page(
    	'wprc_reports_page',
        'Report Settings',         			   		// The title to be displayed in the browser window for this page.
        'Settings',			            			// The text to be displayed for this menu item
        'administrator',            				// Which type of users can see this menu item  
        'wprc_settings',    						// The unique ID - that is, the slug - for this menu item
        'wprc_render_settings_page'     			// The name of the function to call when rendering this menu's page  
    );
}
add_action( 'admin_menu', 'wprc_menu_item' );

function wprc_scripts_styles($hook) {
	global $wprc_settings_page_hook;
	if( $wprc_settings_page_hook != $hook )
		return;
	wp_enqueue_style("options_panel_stylesheet", plugins_url( "static/css/options-panel.css" , dirname(__FILE__) ), false, "1.0", "all");
	wp_enqueue_script("options_panel_script", plugins_url( "static/js/options-panel.js" , dirname(__FILE__) ), false, "1.0");
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}
add_action( 'admin_enqueue_scripts', 'wprc_scripts_styles' );

function wprc_render_settings_page() {
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"></div>
<h2>Report Content Settings</h2>
	<?php settings_errors(); ?>
	<div class="clearfix paddingtop20">
		<div class="first ninecol">
			<form method="post" action="options.php">
				<?php settings_fields( 'wprc_settings' ); ?>
				<?php do_meta_boxes('wprc_metaboxes','advanced',null); ?>
				<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			</form>
		</div>
		<div class="last threecol">
			<div class="side-block">
				Like the plugin? <br/>
				<a href="https://wordpress.org/support/view/plugin-reviews/report-content#postform">Leave a review</a>.
			</div>
		</div>
	</div>
</div>
<?php }

function wprc_create_options() { 
	
	add_settings_section( 'form_settings_section', null, null, 'wprc_settings' );
	add_settings_section( 'integration_settings_section', null, null, 'wprc_settings' );
	add_settings_section( 'email_settings_section', null, null, 'wprc_settings' );
	add_settings_section( 'permissions_settings_section', null, null, 'wprc_settings' );
	add_settings_section( 'other_settings_section', null, null, 'wprc_settings' );

	add_settings_field(
        'active_fields', '', 'wprc_render_settings_field', 'wprc_settings', 'form_settings_section',
		array(
			'title' => 'Active Fields',
			'desc' => 'Fields that will appear on the report form',
			'id' => 'active_fields',
			'type' => 'multicheckbox',
			'items' => array('reason'=>'Reason', 'reporter_name'=>'Name','reporter_email'=>'Email','details'=>'Details'),
			'group' => 'wprc_form_settings'
		)
    );

    add_settings_field(
        'required_fields', '', 'wprc_render_settings_field', 'wprc_settings', 'form_settings_section',
		array(
			'title' => 'Required Fields',
			'desc' => 'Fields that are required',
			'id' => 'required_fields',
			'type' => 'multicheckbox',
			'items' => array('reason'=>'Reason', 'reporter_name'=>'Name','reporter_email'=>'Email','details'=>'Details'),
			'group' => 'wprc_form_settings'
		)
    );

    add_settings_field(
        'report_reasons', '', 'wprc_render_settings_field', 'wprc_settings', 'form_settings_section',
		array(
			'title' => 'Issues',
			'desc' => 'Add one entry per line. These issues will appear in the form of a dropdown.',
			'id' => 'report_reasons',
			'type' => 'textarea',
			'group' => 'wprc_form_settings'
		)
    );

     add_settings_field(
        'slidedown_button_text', '', 'wprc_render_settings_field', 'wprc_settings', 'form_settings_section',
		array(
			'title' => 'Slide Down Button Text',
			'desc' => '',
			'id' => 'slidedown_button_text',
			'type' => 'text',
			'group' => 'wprc_form_settings'
		)
    );

    add_settings_field(
        'submit_button_text', '', 'wprc_render_settings_field', 'wprc_settings', 'form_settings_section',
		array(
			'title' => 'Submit Button Text',
			'desc' => '',
			'id' => 'submit_button_text',
			'type' => 'text',
			'group' => 'wprc_form_settings'
		)
    );

    add_settings_field(
        'color_scheme', '', 'wprc_render_settings_field', 'wprc_settings', 'form_settings_section',
		array(
			'title' => 'Color Scheme',
			'desc' => 'Select a scheme for the form',
			'id' => 'color_scheme',
			'type' => 'select',
			'options' => array("yellow-colorscheme"=>"Yellow", "red-colorscheme" =>"Red", "blue-colorscheme" => "Blue", "green-colorscheme" => "Green"),
			'group' => 'wprc_form_settings'
		)
    );

	add_settings_field(
        'integration_type', '', 'wprc_render_settings_field', 'wprc_settings', 'integration_settings_section',
		array(
			'title' => 'Add the report form',
			'desc' => 'If you choose manual integration you will have to place <b>&lt;?php wprc_report_submission_form(); ?&gt;</b> in your theme files manually.',
			'id' => 'integration_type',
			'type' => 'select',
			'options' => array("automatically" =>"Automatically", "manually" => "Manually"),
			'group' => 'wprc_integration_settings'
		)
    );

    add_settings_field(
        'automatic_form_position', '', 'wprc_render_settings_field', 'wprc_settings', 'integration_settings_section',
		array(
			'title' => 'Add the form',
			'desc' => ' Where do you want the form to be placed? This option will only work if you choose automatic integration',
			'id' => 'automatic_form_position',
			'type' => 'select',
			'options' => array("above" =>"Above post content", "below" => "Below post content"),
			'group' => 'wprc_integration_settings'
		)
    );

    add_settings_field(
        'display_on', '', 'wprc_render_settings_field', 'wprc_settings', 'integration_settings_section',
		array(
			'title' => 'Display form on',
			'desc' => ' Select the section of your website where you want this form to appear',
			'id' => 'display_on',
			'type' => 'select',
			'options' => array("everywhere" =>"The whole site", "single_post" => "Posts", 'single_page' => 'Pages', 'posts_pages'=>'Posts & Pages'),
			'group' => 'wprc_integration_settings'
		)
    );

    add_settings_field(
        'email_recipients', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'On getting a new report send email to',
			'desc' => 'Select email recipients',
			'id' => 'email_recipients',
			'type' => 'select',
			'options' => array("none"=>"No one", "author" =>"Post Author", "admin" => "Blog administrator", "author_admin" => "Author and administrator"),
			'group' => 'wprc_email_settings'
		)
    );

	add_settings_field(
        'sender_name', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'Sender\'s Name',
			'desc' => '',
			'id' => 'sender_name',
			'type' => 'text',
			'group' => 'wprc_email_settings'
		)
    );

    add_settings_field(
        'sender_address', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'Sender\'s Email Address',
			'desc' => '',
			'id' => 'sender_address',
			'type' => 'text',
			'group' => 'wprc_email_settings'
		)
    );

	add_settings_field(
        'author_email_subject', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'Author Email Subject',
			'desc' => 'Subject of the email you want sent to authors. The report will also be appended.',
			'id' => 'author_email_subject',
			'type' => 'text',
			'group' => 'wprc_email_settings'
		)
    );

	add_settings_field(
        'author_email_content', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'Author Email Content',
			'desc' => 'This will be sent to the author of the post. The report will also be appended.<br/><b>%AUTHOR%</b> will be replaced by author name<br/><b>%POSTURL%</b> will be replaced with a link to the post<br/><b>%EDITURL%</b> will be replaced with a link to the edit page',
			'id' => 'author_email_content',
			'type' => 'textarea',
			'group' => 'wprc_email_settings'
		)
    );

	add_settings_field(
        'admin_email_subject', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'Admin Email Subject',
			'desc' => 'Subject of the email you want sent to admins. The report will also be appended.',
			'id' => 'admin_email_subject',
			'type' => 'text',
			'group' => 'wprc_email_settings'
		)
    );

    add_settings_field(
        'admin_email_content', '', 'wprc_render_settings_field', 'wprc_settings', 'email_settings_section',
		array(
			'title' => 'Admin Email Content',
			'desc' => 'This will be sent to the blog admins. The report will also be appended.<br/><b>%POSTURL%</b> will be replaced with a link to the post<br/><b>%EDITURL%</b> will be replaced with a link to the edit page<br/><b>%REPORTSURL%</b> will be replaced by a link to reports page',
			'id' => 'admin_email_content',
			'type' => 'textarea',
			'group' => 'wprc_email_settings'
		)
    );

    add_settings_field(
        'minimum_role_view', '', 'wprc_render_settings_field', 'wprc_settings', 'permissions_settings_section',
		array(
			'title' => 'Minimum access level required to view the reports',
			'desc' => 'What\'s the minimum role that a logged in user needs to have in order to view reports',
			'id' => 'minimum_role_view',
			'type' => 'select',
			'options' => array("install_plugins" => "Administrator", "moderate_comments" => "Editor", "edit_published_posts" => "Author", "edit_posts" => "Contributor", "read" => "Subscriber"),
			'group' => 'wprc_permissions_settings'
		)
    );

    add_settings_field(
        'minimum_role_change', '', 'wprc_render_settings_field', 'wprc_settings', 'permissions_settings_section',
		array(
			'title' => 'Minimum access level required to change status of/delete reports',
			'desc' => 'What\'s the minimum role that a logged in user needs to have in order to manipulate reports',
			'id' => 'minimum_role_change',
			'type' => 'select',
			'options' => array("install_plugins" => "Administrator", "moderate_comments" => "Editor", "edit_published_posts" => "Author", "edit_posts" => "Contributor", "read" => "Subscriber"),
			'group' => 'wprc_permissions_settings'
		)
    );

    add_settings_field(
        'login_required', '', 'wprc_render_settings_field', 'wprc_settings', 'permissions_settings_section',
		array(
			'title' => 'Users must be logged in to report content',
			'desc' => '',
			'id' => 'login_required',
			'type' => 'checkbox',
			'group' => 'wprc_permissions_settings'
		)
    );

    add_settings_field(
        'use_akismet', '', 'wprc_render_settings_field', 'wprc_settings', 'permissions_settings_section',
		array(
			'title' => 'Use Akismet to filter reports',
			'desc' => 'Akismet plugin is required for this feature.',
			'id' => 'use_akismet',
			'type' => 'checkbox',
			'group' => 'wprc_permissions_settings'
		)
    );

	add_settings_field(
        'disable_metabox', '', 'wprc_render_settings_field', 'wprc_settings', 'other_settings_section',
		array(
			'title' => 'Disabe metabox?',
			'desc' => 'Check if you don\' want to display the metabox',
			'id' => 'disable_metabox',
			'type' => 'checkbox',
			'group' => 'wprc_other_settings'
		)
    );

    add_settings_field(
        'disable_db_saving', '', 'wprc_render_settings_field', 'wprc_settings', 'other_settings_section',
		array(
			'title' => 'Don\'t save reports in database',
			'desc' => 'Check if you don\' want to save reports in database',
			'id' => 'disable_db_saving',
			'type' => 'checkbox',
			'group' => 'wprc_other_settings'
		)
    );
	
    // Finally, we register the fields with WordPress 
	register_setting('wprc_settings', 'wprc_form_settings', 'wprc_settings_validation');
	register_setting('wprc_settings', 'wprc_integration_settings', 'wprc_settings_validation');
	register_setting('wprc_settings', 'wprc_email_settings', 'wprc_settings_validation');
	register_setting('wprc_settings', 'wprc_permissions_settings', 'wprc_settings_validation');
	register_setting('wprc_settings', 'wprc_other_settings', 'wprc_settings_validation');
	
} // end sandbox_initialize_theme_options 
add_action('admin_init', 'wprc_create_options');

function wprc_settings_validation($input){
	return $input;
}

function wprc_add_meta_boxes(){
	add_meta_box("wprc_form_settings_metabox", 'Form Settings', "wprc_metaboxes_callback", "wprc_metaboxes", 'advanced', 'default', array('settings_section'=>'form_settings_section'));
	add_meta_box("wprc_integration_settings_metabox", 'Integration Settings', "wprc_metaboxes_callback", "wprc_metaboxes", 'advanced', 'default', array('settings_section'=>'integration_settings_section'));
	add_meta_box("wprc_email_settings_metabox", 'Email Settings', "wprc_metaboxes_callback", "wprc_metaboxes", 'advanced', 'default', array('settings_section'=>'email_settings_section'));
	add_meta_box("wprc_permissions_settings_metabox", 'Security Settings', "wprc_metaboxes_callback", "wprc_metaboxes", 'advanced', 'default', array('settings_section'=>'permissions_settings_section'));
	add_meta_box("wprc_other_settings_metabox", 'Other Settings', "wprc_metaboxes_callback", "wprc_metaboxes", 'advanced', 'default', array('settings_section'=>'other_settings_section'));
}
add_action( 'admin_init', 'wprc_add_meta_boxes' );

function wprc_metaboxes_callback($post, $args){
	do_settings_fields( "wprc_settings", $args['args']['settings_section'] );
	submit_button('Save Changes', 'secondary');
}

function wprc_render_settings_field($args){
	$option_value = get_option($args['group']);
?>
	<div class="row clearfix">
		<div class="col colone"><?php echo $args['title']; ?></div>
		<div class="col coltwo">
	<?php if($args['type'] == 'text'): ?>
		<input type="text" id="<?php echo $args['id'] ?>" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" value="<?php echo esc_attr($option_value[$args['id']]); ?>">
	<?php elseif ($args['type'] == 'select'): ?>
		<select name="<?php echo $args['group'].'['.$args['id'].']'; ?>" id="<?php echo $args['id']; ?>">
			<?php foreach ($args['options'] as $key=>$option) { ?>
				<option <?php selected($option_value[$args['id']], $key); echo 'value="'.$key.'"'; ?>><?php echo $option; ?></option><?php } ?>
		</select>
	<?php elseif($args['type'] == 'checkbox'): ?>
		<input type="hidden" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" value="0" />
		<input type="checkbox" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" id="<?php echo $args['id']; ?>" value="1" <?php checked($option_value[$args['id']]); ?> />
	<?php elseif($args['type'] == 'textarea'): ?>
		<textarea name="<?php echo $args['group'].'['.$args['id'].']'; ?>" type="<?php echo $args['type']; ?>" cols="" rows=""><?php if ( $option_value[$args['id']] != "") { echo stripslashes(esc_textarea($option_value[$args['id']]) ); } ?></textarea>
	<?php elseif($args['type'] == 'multicheckbox'):
		foreach ($args['items'] as $key => $checkboxitem ):
	?>
		<input type="hidden" name="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>" value="0" />
		<label for="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>"><?php echo $checkboxitem; ?></label> <input type="checkbox" name="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>" id="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>" value="1" 
		<?php if($key=='reason'){ ?>checked="checked" disabled="disabled"<?php }else{ checked($option_value[$args['id']][$key]); } ?> />
	<?php endforeach; ?>
	<?php elseif($args['type'] == 'multitext'):
		foreach ($args['items'] as $key => $textitem ):
	?>
		<label for="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>"><?php echo $textitem; ?></label><br/>
		<input type="text" id="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>" name="<?php echo $args['group'].'['.$args['id'].']['.$key.']'; ?>" value="<?php echo esc_attr($option_value[$args['id']][$key]); ?>"><br/>
	<?php endforeach; endif; ?>
		</div>
		<div class="col colthree"><small><?php echo $args['desc'] ?></small></div>
	</div>
<?php
}

?>