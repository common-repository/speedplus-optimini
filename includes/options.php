<?php
/**
 * SpeedPlus OptiMini Options
 */

/* Load styles and scripts */
add_action('admin_enqueue_scripts', 'speedplus_optimini_load_styles_scripts');
function speedplus_optimini_load_styles_scripts() {
	wp_enqueue_style('speedplus_optimini_css', plugin_dir_url( __FILE__ ) . '/css/style.css' );
	if ( is_admin() ){
		if ( isset($_GET['page']) && $_GET['page'] == 'speedplus-optimini' ) {
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'jquery-form' );
		}
	}
}

/* Admin Menu */
add_action('admin_menu', 'speedplus_optimini_admin_menu');
function speedplus_optimini_admin_menu() {
	add_options_page( 'SpeedPlus OptiMini', 'SpeedPlus OptiMini', 'manage_options', 'speedplus-optimini', 'speedplus_optimini_options' );
}
add_action('admin_init', 'speedplus_optimini_init');
function speedplus_optimini_init(){
	// Register settings
	register_setting( 'speedplus_optimini_plugin_options', 'speedplus_optimini_plugin_options', false );
	// Add Sections (id, title, callback, page)
	add_settings_section(
		'speedplus_optimini_options_1',
		esc_html__('Disable Scripts and Styles', 'speedplus-optimini'),
		'speedplus_optimini_section_1',
		'speedplus_optimini_section'
	);
	add_settings_section(
		'speedplus_optimini_options_2',
		esc_html__('Cleanup Code', 'speedplus-optimini'),
		'speedplus_optimini_section_2',
		'speedplus_optimini_section'
	);
	add_settings_section(
		'speedplus_optimini_options_3',
		esc_html__('Security', 'speedplus-optimini'),
		'speedplus_optimini_section_3',
		'speedplus_optimini_section'
	);
	add_settings_section(
		'speedplus_optimini_options_4',
		esc_html__('WooCommerce', 'speedplus-optimini'),
		'speedplus_optimini_section_4',
		'speedplus_optimini_section'
	);
	add_settings_section(
		'speedplus_optimini_options_5',
		esc_html__('SEO and other', 'speedplus-optimini'),
		'speedplus_optimini_section_5',
		'speedplus_optimini_section'
	);
	add_settings_section(
		'speedplus_optimini_options_6',
		esc_html__('Stand with Ukraine', 'speedplus-optimini'),
		'speedplus_optimini_section_6',
		'speedplus_optimini_section'
	);
	
	/* Admin Menu Fields */
	// 1 - Disable Scripts and Styles
	add_settings_field('speedplus_optimini_checkbox_disable_emoji',
		esc_html__('Emojis', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_emoji',
		'speedplus_optimini_section',
		'speedplus_optimini_options_1'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_dashicons',
		esc_html__('Dashicons', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_dashicons',
		'speedplus_optimini_section',
		'speedplus_optimini_options_1'
	);
	// 2 - Cleanup Code
	add_settings_field('speedplus_optimini_checkbox_disable_feed_rss',
		esc_html__('RSS', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_feed_rss',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_wp_version',
		esc_html__('WP version', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_wp_version',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_shortlink',
		esc_html__('Shortlink', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_shortlink',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_wlws',
		esc_html__('Windows Live Writer', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_wlws',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_rsd',
		esc_html__('XML-RPC RSD', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_rsd',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_api',
		esc_html__('REST API', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_api',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_oembed',
		esc_html__('Embeds', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_oembed',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_html_minify',
		esc_html__('HTML', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_html_minify',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	add_settings_field('speedplus_optimini_checkbox_posts_links',
		esc_html__('Post\'s links', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_posts_links',
		'speedplus_optimini_section',
		'speedplus_optimini_options_2'
	);
	// 3 - Security
	add_settings_field('speedplus_optimini_checkbox_disable_login_hints',
		esc_html__('Login Hints', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_login_hints',
		'speedplus_optimini_section',
		'speedplus_optimini_options_3'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_admin_bar',
		esc_html__('Admin bar', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_admin_bar',
		'speedplus_optimini_section',
		'speedplus_optimini_options_3'
	);
	add_settings_field('speedplus_optimini_checkbox_create_robots_txt',
		esc_html__('Robots.txt', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_create_robots_txt',
		'speedplus_optimini_section',
		'speedplus_optimini_options_3'
	);
	add_settings_field('speedplus_optimini_checkbox_app_passwords',
		esc_html__('Passwords', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_app_passwords',
		'speedplus_optimini_section',
		'speedplus_optimini_options_3'
	);
	// 4 - WooCommerce
	add_settings_field('speedplus_optimini_checkbox_adjust_action_sheduler',
		esc_html__('Action Sheduler', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_adjust_action_sheduler',
		'speedplus_optimini_section',
		'speedplus_optimini_options_4'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_fragments',
		esc_html__('Cart Fragments', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_fragments',
		'speedplus_optimini_section',
		'speedplus_optimini_options_4'
	);
	add_settings_field('speedplus_optimini_checkbox_hide_woo_header',
		esc_html__('Marketing garbage', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_hide_woo_header',
		'speedplus_optimini_section',
		'speedplus_optimini_options_4'
	);
	add_settings_field('speedplus_optimini_checkbox_gray_out',
		esc_html__('Gray out of stock', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_gray_out',
		'speedplus_optimini_section',
		'speedplus_optimini_options_4'
	);
	add_settings_field('speedplus_optimini_outofstock_query',
		esc_html__('Do not show out of stock', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_outofstock_query',
		'speedplus_optimini_section',
		'speedplus_optimini_options_4'
	);
	add_settings_field('speedplus_optimini_checkbox_facebook_feed',
		esc_html__('Facebook feed', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_facebook_feed',
		'speedplus_optimini_section',
		'speedplus_optimini_options_4'
	);
	// 5 - Other
	add_settings_field('speedplus_optimini_checkbox_remove_current_links',
		esc_html__('Cyclic Links', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_remove_current_links',
		'speedplus_optimini_section',
		'speedplus_optimini_options_5'
	);
	add_settings_field('speedplus_optimini_checkbox_disable_html_comments',
		esc_html__('HTML in comments', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_disable_html_comments',
		'speedplus_optimini_section',
		'speedplus_optimini_options_5'
	);
	add_settings_field('speedplus_optimini_checkbox_no_comments',
		esc_html__('No comments', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_no_comments',
		'speedplus_optimini_section',
		'speedplus_optimini_options_5'
	);
	add_settings_field('speedplus_optimini_checkbox_passive_jquery',
		esc_html__('Passive jQuery', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_passive_jquery',
		'speedplus_optimini_section',
		'speedplus_optimini_options_5'
	);
	add_settings_field('speedplus_optimini_checkbox_wp_core_updates',
		esc_html__('Updates', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_wp_core_updates',
		'speedplus_optimini_section',
		'speedplus_optimini_options_5'
	);
	
	// 6 - Stand with Ukraine
	add_settings_field('speedplus_optimini_checkbox_stop_war_in_ukraine',
		esc_html__('Support Ukraine', 'speedplus-optimini'),
		'speedplus_optimini_checkbox_stop_war_in_ukraine',
		'speedplus_optimini_section',
		'speedplus_optimini_options_6'
	);
}

/* Options Description*/
function speedplus_optimini_section_1() {
	echo '<p>' . esc_html__('Here you can unload unnecessary JS and CSS files.', 'speedplus-optimini') . '</p>';
}
function speedplus_optimini_section_2() {
	echo '<p>' . esc_html__('Remove unnecessary strings from output HTML code and minify it.', 'speedplus-optimini') . '</p>';
}
function speedplus_optimini_section_3() {
	echo '<p>' . esc_html__('Options for improve security of your site.', 'speedplus-optimini') . '</p>';
}
function speedplus_optimini_section_4() {
	if ( class_exists( 'WooCommerce' ) ) {
		echo '<p>' . esc_html__('Helpfull options for Woocommerce store.', 'speedplus-optimini') . '</p>';
	} else {
		echo '<p><span class="speedplus_optimini_blue_bold_info">' . esc_html__(' Woocommerce plugin not activated.', 'speedplus-optimini') . '</span></p>';
	}
}
function speedplus_optimini_section_5() {
	echo '<p>' . esc_html__('Other optimization options.', 'speedplus-optimini') . '</p>';
}

function speedplus_optimini_section_6() {
	echo '<p>' . esc_html__('On February 24, 2022, Russian troops invaded Ukraine. The Russians rape and kill civilians: small children, .women and the elderly. You can make an important contribution to the defense of Ukraine from Russian monsters.', 'speedplus-optimini') . '</p>';
}

/* Checkboxes */
function speedplus_optimini_checkbox_disable_emoji() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_emoji' name='speedplus_optimini_plugin_options[disable_emoji]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_emoji']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_emoji'><?php echo esc_html__( 'Unload all Emojis including TinyMCE.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Disable inline emoji scripts and styles from WordPress in the header.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_dashicons() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_dashicons' name='speedplus_optimini_plugin_options[disable_dashicons]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_dashicons']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_dashicons'><?php echo esc_html__( 'Disable dashicons in frontend to non-admin.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Dashicons is the official icon font of WordPress dashboard. If you does not use these icons in the frontend, you can safely disable it and save about 60KB.', 'speedplus-optimini' ) . '</span><br/><span class="speedplus_optimini_red_bold_info">' . esc_html__( 'Be carefull, it can break Toolbar for non-admin users.', 'speedplus-optimini' ) . '</span>' ?></label>	
	<?php
}
function speedplus_optimini_checkbox_disable_feed_rss() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_feed_rss' name='speedplus_optimini_plugin_options[disable_feed_rss]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_feed_rss']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_feed_rss'><?php echo esc_html__( 'Disable Feed RSS.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Removes 2+ links to RSS feeds in the site header, as well as the RSS feeds themselves. The corresponding RSS feed pages are giving a 404 error.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_wp_version() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_wp_version' name='speedplus_optimini_plugin_options[disable_wp_version]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_wp_version']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_wp_version'><?php echo esc_html__( 'Remove the WordPress version.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Remove the unnecessary line in the site header, which information can be used by hackers:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<meta name="generator" content="WordPress XXX" />' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_shortlink() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_shortlink' name='speedplus_optimini_plugin_options[disable_shortlink]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_shortlink']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_shortlink'><?php echo esc_html__( 'Remove shortlink.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Good for SEO if your site uses user-friendly URLs. Remove the unnecessary line in the site header:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<link rel="shortlink" href="https://site.com/?p=12345" />' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_wlws() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_wlws' name='speedplus_optimini_plugin_options[disable_wlws]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_wlws']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_wlws'><?php echo esc_html__( 'Disable Windows Live Writer support.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'If you don\'t use Windows Live Writer and even don\'t know what is it, you can safely remove from site header this line:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://site.com/wp-includes/wlwmanifest.xml" />.' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_rsd() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_rsd' name='speedplus_optimini_plugin_options[disable_rsd]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_rsd']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_rsd'><?php echo esc_html__( 'Remove XML-RPC RSD link from Header.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'If you add new content through WordPress and don\'t use any remote connection applications, you can remove from site header this line:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://site.com/xmlrpc.php?rsd" />.' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_api() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_api' name='speedplus_optimini_plugin_options[disable_api]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_api']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_api'><?php echo esc_html__( 'Remove api.w.org relation link.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'If you don\'t use REST API on site, you can remove from site header this lines:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<link rel="https://api.w.org/" href="https://site.com/wp-json/" />' ) . '<br/>' . esc_html( '<link rel="alternate" type="application/json" href="https://site.com/wp-json/wp/v2/" />') . '</span><br/><span class="speedplus_optimini_red_bold_info">' . esc_html__( 'Be carefull, it can break work of any used API-services.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_oembed() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_oembed' name='speedplus_optimini_plugin_options[disable_oembed]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_oembed']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_oembed'><?php echo esc_html__('Totally remove Embeds.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'If you don\'t want allow others to embed your WordPress posts into their own site by adding the post URL, you can remove from site header this lines:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<link rel="alternate" type="application/json+oembed" href="https://site.com/wp-json/oembed/1.0/embed?url=https://site.com/" />') . '<br/>' . esc_html( '<link rel="alternate" type="text/xml+oembed" href="https://site.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fsite.com%2F&#038;format=xml" />') . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_html_minify() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_html_minify' name='speedplus_optimini_plugin_options[html_minify]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['html_minify']) ); ?> />
	<label for='speedplus_optimini_checkbox_html_minify'><?php echo esc_html__('Agressive HTML minify.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Forced cleaning of HTML code from extra spaces, empty lines and unnecessary characters.', 'speedplus-optimini' ) . '</span><br/><span class="speedplus_optimini_red_bold_info">' . esc_html__( 'Caution! It can break your site.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_posts_links() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_posts_links' name='speedplus_optimini_plugin_options[posts_links]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['posts_links']) ); ?> />
	<label for='speedplus_optimini_checkbox_posts_links'><?php echo esc_html__('Remove links to posts in the header: to the index page, random/parent/next/previous posts.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'This option will remove such lines in the header:', 'speedplus-optimini' ) . '<br/>' . esc_html( '<link rel="next" href="https://site.com/site.ru/page/2" />') . '<br/>' . esc_html( '<link rel="prev" href="https://site.com/site.ru/page/1" />') . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_login_hints() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_login_hints' name='speedplus_optimini_plugin_options[disable_login_hints]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_login_hints']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_login_hints'><?php echo esc_html__( 'Disable login hints.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'WordPress allows hackers to guess your username or email address to log into a site, while displaying an error message about an incorrect password. You can hide the login hints and display a new error message: "Invalid username, email, or password."', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_admin_bar() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_admin_bar' name='speedplus_optimini_plugin_options[disable_admin_bar]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_admin_bar']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_admin_bar'><?php echo esc_html__( 'Disable loading Admin bar in Frontend.', 'speedplus-optimini' ) ?></label>
	<?php
}
function speedplus_optimini_checkbox_create_robots_txt() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_create_robots_txt' name='speedplus_optimini_plugin_options[create_robots_txt]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['create_robots_txt']) ); ?> />
	<label for='speedplus_optimini_checkbox_create_robots_txt'><?php echo esc_html__( 'Create the correct robots.txt file.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Automatically create the correct robots.txt file with rules for all visitors, for GoogleBot and YandexBot. Only works if the robots.txt file has not been manually created before - in this case, just rename old file.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_app_passwords() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_app_passwords' name='speedplus_optimini_plugin_options[app_passwords]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['app_passwords']) ); ?> />
	<label for='speedplus_optimini_checkbox_app_passwords'><?php echo esc_html__( 'Disable app passwords.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Safely disable app passwords in WordPress. It\'s not about user and admin passwords.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}

/* WooCommerce IF SO */
function speedplus_optimini_checkbox_adjust_action_sheduler() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_adjust_action_sheduler' name='speedplus_optimini_plugin_options[adjust_action_sheduler]' value="1" type='checkbox' <?php if ( class_exists( 'WooCommerce' ) ) {checked( 1, isset($speedplus_optimini_options['adjust_action_sheduler']) );} else {echo 'disabled="disabled"';} ?> />
	<label for='speedplus_optimini_checkbox_adjust_action_sheduler'><?php echo esc_html__( 'Reduce the storage time of entries in the WooCommerce Action Sheduler\'s log.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Good for Database size. New value: 1 week (default: 4 weeks).', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_fragments() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_fragments' name='speedplus_optimini_plugin_options[disable_fragments]' value="1" type='checkbox' <?php if ( class_exists( 'WooCommerce' ) ) {checked( 1, isset($speedplus_optimini_options['disable_fragments']) );} else {echo 'disabled="disabled"';} ?> />
	<label for='speedplus_optimini_checkbox_disable_fragments'><?php echo esc_html__( 'Disable Ajax call from WooCommerce on FrontPage.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'On some sites, WooCommerce Cart Fragments can seriously slow down site speed. You can turn off this feature on the home page.', 'speedplus-optimini' ) . '</span><br/><span class="speedplus_optimini_red_bold_info">' . esc_html__( 'Caution! If enabled, the shopping cart will not be updated on the home page.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_hide_woo_header() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_hide_woo_header' name='speedplus_optimini_plugin_options[hide_woo_header]' value="1" type='checkbox' <?php if ( class_exists( 'WooCommerce' ) ) {checked( 1, isset($speedplus_optimini_options['hide_woo_header']) );} else {echo 'disabled="disabled"';} ?> />
	<label for='speedplus_optimini_checkbox_hide_woo_header'><?php echo esc_html__( 'Disable WooCommerce marketing garbage.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Breathe freely by disabling unnecessary and adware features: marketing hub menu, WC admin, marketplace suggestions, WC dashboard boxes, WC widgets, notice "Connect your store to WC", Action Scheduler migration, automatic regeneration of thumbnail images.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_gray_out() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_gray_out' name='speedplus_optimini_plugin_options[gray_out]' value="1" type='checkbox' <?php if ( class_exists( 'WooCommerce' ) ) {checked( 1, isset($speedplus_optimini_options['gray_out']) );} else {echo 'disabled="disabled"';} ?> />
	<label for='speedplus_optimini_checkbox_gray_out'><?php echo esc_html__( 'Gray color for "out of stock" product variations.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Customers don\'t like it when they select a product variation and see "Out of stock”. You can lock the selection of “out of stock” variations and make them grayed out.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_outofstock_query() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_outofstock_query' name='speedplus_optimini_plugin_options[outofstock_query]' value="1" type='checkbox' <?php if ( class_exists( 'WooCommerce' ) ) {checked( 1, isset($speedplus_optimini_options['outofstock_query']) );} else {echo 'disabled="disabled"';} ?> />
	<label for='speedplus_optimini_checkbox_outofstock_query'><?php echo esc_html__( 'Hide out of stock Woocommerce products in Shop, Categories, Tags and Related Products.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'WooCommerce allows you to completely hide out of stock products , but this is bad for the SEO. This option hides products only on the store page, in categories, on tag pages, and in the "Related Products" block. In this case, the pages of the out of stock products will remain available.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_facebook_feed() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
		// Check plugin version
        if (!function_exists('get_plugins')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugins = get_plugins();
        if (isset($plugins['facebook-for-woocommerce/facebook-for-woocommerce.php'])) {
			$speedplus_optimini_fbf_ver = $plugins['facebook-for-woocommerce/facebook-for-woocommerce.php']['Version'];
            if ($speedplus_optimini_fbf_ver >= '2.5') {
				$speedplus_optimini_fbf_check = 1; // Already fixed
            } else {
				$speedplus_optimini_fbf_check = 2; // Can be fixed
			}
		} else {
			$speedplus_optimini_fbf_check = 3; // No such plugin
		}?>
	<input id='speedplus_optimini_checkbox_facebook_feed' name='speedplus_optimini_plugin_options[facebook_feed]' value="1" type='checkbox' <?php if ( $speedplus_optimini_fbf_check == '2') {checked( 1, isset($speedplus_optimini_options['facebook_feed']) );} else {echo 'disabled="disabled"';} ?> />
	<label for='speedplus_optimini_checkbox_facebook_feed'><?php
    echo esc_html__( 'Increase the Facebook feed creation interval.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Previous versions of the Facebook for WooCommerce plugin generates a product feed every 15 minutes. This significantly loads the server and can generate errors. You can change the feed creation interval to 1 day.', 'speedplus-optimini' ) . '<br/></span>';
		if ( $speedplus_optimini_fbf_check == 1) {
			echo '<span class="speedplus_optimini_green_bold_info">' . esc_html__( 'This issue has already been fixed in the current version of the plugin.', 'speedplus-optimini' ) . '<br/></span>';
		}
		elseif ($speedplus_optimini_fbf_check == 3) {
			echo '<span class="speedplus_optimini_blue_bold_info">' . esc_html__( 'The Facebook for WooCommerce plugin is not installed.', 'speedplus-optimini' ) . '<br/></span>';
		}
	?></label>
  <?php
}
/**** END WooCommerce IF SO */

function speedplus_optimini_checkbox_remove_current_links() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_remove_current_links' name='speedplus_optimini_plugin_options[remove_current_links]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['remove_current_links']) ); ?> />
	<label for='speedplus_optimini_checkbox_remove_current_links'><?php echo esc_html__( 'Remove links to current page from Menu and Categories.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Good for SEO.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_disable_html_comments() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_disable_html_comments' name='speedplus_optimini_plugin_options[disable_html_comments]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['disable_html_comments']) ); ?> />
	<label for='speedplus_optimini_checkbox_disable_html_comments'><?php echo esc_html__( 'Disable HTML in comments.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Good for SEO and reduce spam.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_no_comments() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_no_comments' name='speedplus_optimini_plugin_options[no_comments]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['no_comments']) ); ?> />
	<label for='speedplus_optimini_checkbox_no_comments'><?php echo esc_html__( 'Completely disable comments. All comments. Everywhere.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'If you do not want to use comments on the site, then this is the best way to disable them completely.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_passive_jquery() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_passive_jquery' name='speedplus_optimini_plugin_options[passive_jquery]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['passive_jquery']) ); ?> />
	<label for='speedplus_optimini_checkbox_passive_jquery'><?php echo esc_html__( 'Make jQuery passive.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'If PageSpeed tell you that jQuery "Does not use passive listeners to improve scrolling performance", enable this option. Note: does not work on some sites.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_wp_core_updates() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_wp_core_updates' name='speedplus_optimini_plugin_options[wp_core_updates]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['wp_core_updates']) ); ?> />
	<label for='speedplus_optimini_checkbox_wp_core_updates'><?php echo esc_html__( 'Disable automatic plugins and themes updates.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'Now you will only update them when you are ready.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}
function speedplus_optimini_checkbox_stop_war_in_ukraine() {
	$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');
	?>
	<input id='speedplus_optimini_checkbox_stop_war_in_ukraine' name='speedplus_optimini_plugin_options[stop_war_in_ukraine]' value="1" type='checkbox' <?php checked( 1, isset($speedplus_optimini_options['stop_war_in_ukraine']) ); ?> />
	<label for='speedplus_optimini_checkbox_stop_war_in_ukraine'><?php echo esc_html__( 'Add top banner Stop the war in Ukraine.', 'speedplus-optimini' ) . '<br/><span class="speedplus_optimini_info">' . esc_html__( 'The banner will appear in the top left corner of your site. The link from the banner leads to the official fundraising page for the needs of the Ukrainian army.', 'speedplus-optimini' ) . '</span>' ?></label>
	<?php
}


/* Options */
function speedplus_optimini_options() {
	?>
	<div id="speedplus_optimini_admin_panel" class="wrap">
		<h1><span class="speedplus_optimini-header"></span>SpeedPlus OptiMini</h1>
		<form method="post" action="options.php" id="speedplus_optimini_admin_panel_form">
			<?php settings_fields( 'speedplus_optimini_plugin_options' ); ?>
			<?php do_settings_sections( 'speedplus_optimini_section' ); ?>
			<?php submit_button(); ?>
		</form>
		<div id="speedplus_optimini_save_result"></div>
	</div>
	<div id="speedplus_optimini_admin_panel_footer">
		<?php echo '<p>' . esc_html__( 'Did you like this plugin? You can ', 'speedplus-optimini' ) . '<a href="https://buymeacoffee.com/speedplus">' . esc_html__( 'buy me a coffee.', 'speedplus-optimini' ) . '</a><span class="dashicons dashicons-heart"></span></p>';
		echo '<p>' . esc_html__( 'Also try our plugins', 'speedplus-optimini' ) . ' <strong><a href="https://wordpress.org/plugins/speedplus-antimat/">SpeedPlus AntiMat</a></strong> ' . esc_html__( '(removes obscene words in comments) and', 'speedplus-optimini' ) . ' <strong><a href="https://codecanyon.net/item/speedplus-check-woo-phone/37016075">SpeedPlus Check Woo Phone</a></strong> ' . esc_html__( '(checks the customer\'s phone number on the WooCommerce Checkout page against your rules).', 'speedplus-optimini' ) . '</p>'; ?>
	</div>
	
	<!-- Ajax Submit and Message -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#speedplus_optimini_admin_panel_form').submit(function() {
				jQuery(this).ajaxSubmit({
					success: function(){
						jQuery('#speedplus_optimini_save_result').html("<div id='speedplus_optimini_save_message' class='successModal'></div>");
						jQuery('#speedplus_optimini_save_message').append("<p><?php echo htmlentities(esc_html__('Settings saved. Nice work!','speedplus-optimini'),ENT_QUOTES); ?></p>").show();
					},
					timeout: 5000
				});
				setTimeout("jQuery('#speedplus_optimini_save_message').hide('slow');", 10000);
				return false;
			});
		});
	</script>
	<?php
}