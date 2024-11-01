<?php
/**
 * Plugin Name:       SpeedPlus OptiMini
 * Plugin URI:        https://speedplus.com.ua/speedplus-optimini/
 * Description:       Increase PageSpeed score and make your site faster.
 * Version:           1.4.4
 * Author:            SpeedPlus
 * Author URI:        https://speedplus.com.ua
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       speedplus-optimini
 * Domain Path:       /languages
 *
 * Copyright 2021-2022 SpeedPlus
 */

require_once plugin_dir_path(__FILE__) . 'includes/options.php';

function speedplus_optimini_load_plugin_textdomain(){
    load_plugin_textdomain( 'speedplus-optimini', false, basename( __DIR__ ) . '/languages/' );
}
add_action( 'plugins_loaded', 'speedplus_optimini_load_plugin_textdomain' );

/* Add links to Plugins list */
add_filter( 'plugin_action_links', 'speedplus_optimini_add_action_plugin', 10, 5 );
function speedplus_optimini_add_action_plugin( $actions, $plugin_file )
	{
	   static $plugin;
	   if (!isset($plugin))
			$plugin = plugin_basename(__FILE__);
	   if ($plugin == $plugin_file) {
		  $settings = array('settings' => '<a href="options-general.php?page=speedplus-optimini" style="display:inline">' . __('Settings') . '</a>');
		  $site_link = array('support' => '<a style="display:inline" href="https://freelancehunt.com/freelancer/Kostyantin.html?r=3YmoD" target="_blank">' . __('Need help with a slow site?', 'speedplus-optimini') . '</a>');
		  $actions = array_merge($site_link, $actions);
		  $actions = array_merge($settings, $actions);
	   }
	   return $actions;
	}

// Add OptiMini Text in Header
function speedplus_optimini_header_info() {
	?><!-- Site optimized by SpeedPlus OptiMini plugin --><?php
}
add_action('wp_head', 'speedplus_optimini_header_info');

/* Load OptiMini options from Database */
$speedplus_optimini_options = get_option('speedplus_optimini_plugin_options');

if ( isset($speedplus_optimini_options['disable_emoji']) ) {
	/* Disable emoji */
	function speedplus_optimini_disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}
	add_action( 'init', 'speedplus_optimini_disable_emojis' );

	/* Filter function used to remove the tinymce emoji plugin */
	function speedplus_optimini_disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
	add_filter( 'tiny_mce_plugins', 'speedplus_optimini_disable_emojis_tinymce' );

	/* Remove emoji CDN hostname from DNS prefetching hints */
	function speedplus_optimini_emojis_dns( $urls, $relation_type ) {
		if ( 'dns-prefetch' == $relation_type ) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
			$urls = array_diff( $urls, array( $emoji_svg_url ) );
		}
		return $urls;
	}
	add_filter( 'wp_resource_hints', 'speedplus_optimini_emojis_dns', 10, 2 );
}

if ( isset($speedplus_optimini_options['disable_dashicons']) ) {
	// Disable dashicons in frontend to non-admin
    function speedplus_optimini_dashicons() {
        if (current_user_can( 'update_core' )) {
            return;
        }
        wp_deregister_style('dashicons');
    }
    add_action( 'wp_enqueue_scripts', 'speedplus_optimini_dashicons' );
}

if ( isset($speedplus_optimini_options['disable_feed_rss']) ) {
	// Disable FEED RSS
	add_action( 'wp_head', 'speedplus_optimini_rss', 1 );
	function speedplus_optimini_rss(){
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
	}
	add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);
	add_action( 'init', 'speedplus_optimini_feed_endpoint', 99 );
	function speedplus_optimini_feed_endpoint(){
		global $wp_rewrite;
		$wp_rewrite->feeds = array();
	}
	// Version 1.3.0
	foreach( array( 'rdf', 'rss', 'rss2', 'atom', 'rss2_comments', 'atom_comments' ) as $feed ){
		add_action( 'do_feed_' . $feed, 'speedplus_optimini_remove_feeds', 1 );
	}
	unset( $feed );
	function speedplus_optimini_remove_feeds(){
		wp_redirect( home_url(), 302 );
		exit();
	}
	register_activation_hook( __FILE__, 'speedplus_optimini_activation' );
	function speedplus_optimini_activation(){
		speedplus_optimini_feed_endpoint();
		flush_rewrite_rules();
	}
}

if ( isset($speedplus_optimini_options['disable_wp_version']) ) {
	// Remove the WordPress version
	function speedplus_optimini_versions() {
		return '';
	}
	add_filter('the_generator', 'speedplus_optimini_versions');
}

if ( isset($speedplus_optimini_options['disable_shortlink']) ) {
	// Remove shortlinks
	remove_action( 'wp_head', 'wp_shortlink_wp_head');
	remove_action('template_redirect', 'wp_shortlink_header', 11);
}

if ( isset($speedplus_optimini_options['disable_wlws']) ) {
	// Disable Windows Live Writer support
	remove_action('wp_head', 'wlwmanifest_link');
}

if ( isset($speedplus_optimini_options['disable_rsd']) ) {
	// Disable XML-RPC RSD link from Header
	remove_action ('wp_head', 'rsd_link');
	add_filter('xmlrpc_enabled', '__return_false');
}

if ( isset($speedplus_optimini_options['disable_api']) ) {
	// Remove api.w.org relation link
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

if ( isset($speedplus_optimini_options['disable_oembed']) ) {
	// Turn off oEmbed auto discovery.
	add_filter( 'embed_oembed_discover', '__return_false' );
	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}

if ( isset($speedplus_optimini_options['html_minify']) ) {
	function speedplus_optimini_html_function() {
		// HTML minify
		add_action('wp_loaded', 'speedplus_optimini_output_buffer_start');
		add_action('shutdown', 'speedplus_optimini_output_buffer_end');
		function speedplus_optimini_output_buffer_start() {
			ob_start("speedplus_optimini_output_callback");
		}
		function speedplus_optimini_output_buffer_end() {
			ob_get_clean();
		}
		function speedplus_optimini_output_callback($buffer) {
			if(!is_admin() && !(defined('DOING_AJAX') && DOING_AJAX)){
				// Remove type from javascript and CSS
				$buffer = preg_replace( "%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer );
				// clear HEAD
				$buffer = preg_replace_callback('/(?=<head(.*?)>)(.*?)(?<=<\/head>)/s',
					function($matches) {
						return preg_replace(array(
							'/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', // delete HTML comments
							'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
							'/[^\S ]+\</s',  // strip whitespaces before tags, except space
							'/\>\s+\</',    // strip whitespaces between tags
						), array(
							'',
							'>',  // strip whitespaces after tags, except space
							'<',  // strip whitespaces before tags, except space
							'><',   // strip whitespaces between tags
						), $matches[2]);
					}, $buffer);
				// clear BODY
				$buffer = preg_replace_callback('/(?=<body(.*?)>)(.*?)(?<=<\/body>)/s',
				function($matches) {
					return preg_replace(array(
						'/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', // delete HTML comments
						/* Fix HTML */
						'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
						'/[^\S ]+\</s',  // strip whitespaces before tags, except space
						'/\>\s+\</',    // strip whitespaces between tags
					), array(
						'', // delete HTML comments
						/* Fix HTML */
						'>',  // strip whitespaces after tags, except space
						'<',  // strip whitespaces before tags, except space
						'> <',   // strip whitespaces between tags
					), $matches[2]);
				}, $buffer);
				$buffer = preg_replace_callback('/(?=<script(.*?)>)(.*?)(?<=<\/script>)/s',
				function($matches) {
					return preg_replace(array(
						'@\/\*(.*?)\*\/@s', // delete JavaScript comments
						'@((^|\t|\s|\r)\/{2,}.+?(\n|$))@s', // delete JavaScript comments
						'@(\}(\n|\s+)else(\n|\s+)\{)@s', // fix "else" statemant
						'@((\)\{)|(\)(\n|\s+)\{))@s', // fix brackets position
						//'@(\}\)(\t+|\s+|\n+))@s', // fix closed functions
						'@(\}(\n+|\t+|\s+)else\sif(\s+|)\()@s', // fix "else if"
						'@(if|for|while|switch|function)\(@s', // fix "if, for, while, switch, function"
						'@\s+(\={1,3}|\:)\s+@s', // fix " = and : "
						'@\$\((.*?)\)@s', // fix $(  )
						'@(if|while)\s\((.*?)\)\s\{@s', // fix "if|while ( ) {"
						'@function\s\(\s+\)\s{@s', // fix "function ( ) {"
						'@(\n{2,})@s', // fix multi new lines
						'@([\r\n\s\t]+)(,)@s', // Fix comma
						'@([\r\n\s\t]+)?([;,{}()]+)([\r\n\s\t]+)?@', // Put all inline
					), array(
						"\n", // delete JavaScript comments
						"\n", // delete JavaScript comments
						'}else{', // fix "else" statemant
						'){', // fix brackets position
						//"});\n", // fix closed functions
						'}else if(', // fix "else if"
						"$1(",  // fix "if, for, while, switch, function"
						" $1 ", // fix " = and : "
						'$'."($1)", // fix $(  )
						"$1 ($2) {", // fix "if|while ( ) {"
						'function(){', // fix "function ( ) {"
						"\n", // fix multi new lines
						',', // fix comma
						"$2", // Put all inline
					), $matches[2]);
				}, $buffer);
				// Clear CSS
				$buffer = preg_replace_callback('/(?=<style(.*?)>)(.*?)(?<=<\/style>)/s',
				function($matches) {
					return preg_replace(array(
						'/([.#]?)([a-zA-Z0-9,_-]|\)|\])([\s|\t|\n|\r]+)?{([\s|\t|\n|\r]+)(.*?)([\s|\t|\n|\r]+)}([\s|\t|\n|\r]+)/s', // Clear brackets and whitespaces
						'/([0-9a-zA-Z]+)([;,])([\s|\t|\n|\r]+)?/s', // Let's fix ,;
						'@([\r\n\s\t]+)?([;:,{}()]+)([\r\n\s\t]+)?@', // Put all inline
					), array(
						'$1$2{$5} ', // Clear brackets and whitespaces
						'$1$2', // Let's fix ,;
						"$2", // Put all inline
					), $matches[2]);
				}, $buffer);
				// Clean between HEAD and BODY
				$buffer = preg_replace( "%</head>([\s\t\n\r]+)<body%", '</head><body', $buffer );
				// Clean between BODY and HTML
				$buffer = preg_replace( "%</body>([\s\t\n\r]+)</html>%", '</body></html>', $buffer );
				// Clean between HTML and HEAD
				$buffer = preg_replace( "%<html(.*?)>([\s\t\n\r]+)<head%", '<html$1><head', $buffer );
			}
			return $buffer;
		}
	}
	// Check QueryMonitor, and Frontend, and Admin
	if ( class_exists( 'QueryMonitor' ) ) {
		include_once(ABSPATH . 'wp-includes/pluggable.php');
		if ( ! is_admin() && current_user_can( 'manage_options' ) ) {
			// Disable HTML minify
		} else {
			speedplus_optimini_html_function();
		}
	} else {
		speedplus_optimini_html_function();
	}
}

if ( isset($speedplus_optimini_options['disable_login_hints']) ) {
	// Disable Login Hints
	function speedplus_optimini_login_errors(){
		return 'Invalid username, email or password.';
	}
	add_filter( 'login_errors', 'speedplus_optimini_login_errors' );
}

if ( isset($speedplus_optimini_options['disable_admin_bar']) ) {
	// stop loading admin bar
	add_filter('show_admin_bar', '__return_false');
}

if ( isset($speedplus_optimini_options['adjust_action_sheduler']) ) {
	// Adjust the interval of WooCommerce Action sheduler cleaning
	function speedplus_optimini_action_scheduler() {
		return 604800; // 604800 - 1 week in sec.
	}
	add_filter( 'action_scheduler_retention_period', 'speedplus_optimini_action_scheduler' );
}

if ( isset($speedplus_optimini_options['disable_fragments']) ) {
	/** Disable Ajax Call from WooCommerce on FrontPage */
	add_action( 'wp_enqueue_scripts', 'speedplus_optimini_cart_fragments', 11);
	function speedplus_optimini_cart_fragments() { if (is_front_page()) wp_dequeue_script('wc-cart-fragments'); }
}

if ( isset($speedplus_optimini_options['hide_woo_header']) ) {
	// Disable WooCommerce Admin
		// Source: https://wordpress.org/support/topic/historical-data-import-stuck-and-broken-2/
	add_filter('woocommerce_admin_disabled', '__return_true');
	// Remove WooCommerce Marketing Hub Menu from the sidebar WooCommerce v4.3+
		// Source: https://wordpress.org/support/topic/how-to-disable-marketing-hub/page/2/
	add_filter( 'woocommerce_admin_features', function( $features ) {
		return array_values(
		array_filter( $features, function($feature) {
		return $feature !== 'marketing';
		} )
		);
	} );
	// Source: https://wordpress.org/support/topic/wc-admin-is-back/
	add_action( 'admin_enqueue_scripts', function() {
		wp_dequeue_style( 'wc-admin-app' );
		wp_deregister_style( 'wc-admin-app' );
		?><style>.woocommerce-layout__header{display:none}</style><?php
	}, 19 );
	// Prevent automatic regeneration of thumbnail images and causing server hikes
		// Source: https://kriesi.at/support/topic/stop-automatic-regeneration-of-thumbnails/
	add_filter('woocommerce_background_image_regeneration', '__return_false');
	// Disable Action Scheduler Migration
		// Source: https://wordpress.org/support/topic/historical-data-import-stuck-and-broken-2/
	add_filter('action_scheduler_migration_dependencies_met', '__return_false');
	// Disable Marketplace Suggestions
		// Source: https://divibooster.com/disable-woocommerce-marketplace-suggestions/
	add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );
	add_filter('woocommerce_show_marketplace_suggestions', function ($show) { return 'no'; });
	// Remove Admin Notice "Connect your store to WooCommerce.com"
		// Source: https://www.wpfixit.com/connect-your-store-to-woocommerce/
	add_filter('woocommerce_helper_suppress_admin_notices', '__return_true');
	add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
	// Remove WooCommerce dashboard boxes
	add_action(
	'wp_dashboard_setup',
		function () {
			remove_meta_box('woocommerce_dashboard_status', 'dashboard', 'normal');
			remove_meta_box('woocommerce_dashboard_recent_reviews', 'dashboard', 'normal');
			remove_meta_box('woocommerce_network_orders', 'dashboard', 'normal');
		}
	);
	// Remove WooCommerce widgets
		// Source: https://rudrastyh.com/woocommerce/remove-widgets.html
	add_action(
		'widgets_init',
		function () {
			$widgets = [
				'WC_Widget_Cart',
				'WC_Widget_Layered_Nav_Filters',
				'WC_Widget_Layered_Nav',
				'WC_Widget_Price_Filter',
				'WC_Widget_Product_Categories',
				'WC_Widget_Product_Search',
				'WC_Widget_Product_Tag_Cloud',
				'WC_Widget_Products',
				'WC_Widget_Recently_Viewed',
				'WC_Widget_Top_Rated_Products',
				'WC_Widget_Recent_Reviews',
				'WC_Widget_Rating_Filter',
			];
			foreach ($widgets as $widget) {
				unregister_widget($widget);
				register_widget($widget, null);
			}
		}
	);
}

if ( isset($speedplus_optimini_options['gray_out']) ) {
	/* GRAY out of stock variations */
	function speedplus_optimini_gray_out( $active, $variation ) {
		if( ! $variation->is_in_stock() ) {
			return false;
		}
		return $active;
	}
	add_filter( 'woocommerce_variation_is_active', 'speedplus_optimini_gray_out', 10, 2 );
}

if ( isset($speedplus_optimini_options['facebook_feed']) ) {
	// Adjust the interval that the Facebook feed file is generated
	function speedplus_optimini_fb_feed_interval( $interval ) {
		return 60 * 1440; // 60 * 30 = 30 minutes set in seconds
	}
	add_filter( 'wc_facebook_feed_generation_interval', 'speedplus_optimini_fb_feed_interval', 10, 1 );
}

if ( isset($speedplus_optimini_options['remove_current_links']) ) {
	// Remove Links to current page from Menu and Categories
	function speedplus_optimini_nolink_current_page( $p ) {
		return preg_replace( '%((current_page_item|current-menu-item)[^<]+)[^>]+>([^<]+)</a>%', '$1<a>$3</a>', $p, 1 );
	}
	add_filter ('wp_nav_menu', 'speedplus_optimini_nolink_current_page');
	function speedplus_optimini_category_nolink($no_link){
		$gg_mk = '!<li class="cat-item (.*?) current-cat"><a (.*?)>(.*?)</a>!si';
		$dd_mk = '<li class="cat-item \1 current-cat">\3';
		return preg_replace($gg_mk, $dd_mk, $no_link );
	}
	add_filter('wp_list_categories', 'speedplus_optimini_category_nolink');
}

if ( isset($speedplus_optimini_options['disable_html_comments']) ) {
	// Disable HTML in comments
	add_filter( 'pre_comment_content', 'esc_html' );
}

if ( isset($speedplus_optimini_options['no_comments']) ) {
	// Completely Disable Comments on site
	add_action('admin_init', function () {
		// Redirect any user trying to access comments page
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url());
			exit;
		}
		// Remove comments metabox from dashboard
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		// Disable support for comments and trackbacks in post types
		foreach (get_post_types() as $post_type) {
			if (post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	});
	// Close comments on the front-end
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);
	// Hide existing comments
	add_filter('comments_array', '__return_empty_array', 10, 2);
	// Remove comments page in menu
	add_action('admin_menu', function () {
		remove_menu_page('edit-comments.php');
	});
	// Remove comments links from admin bar
	add_action('init', function () {
		if (is_admin_bar_showing()) {
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		}
	});
}

if ( isset($speedplus_optimini_options['passive_jquery']) ) {
	// Make jQuery Passive
	add_action( 'wp_footer', 'speedplus_optimini_passive_jquery' );
	function speedplus_optimini_passive_jquery() {
	?><script type="text/javascript">jQuery.event.special.touchstart={setup:function(a,b,c){this.addEventListener("touchstart",c,{passive:!0})}};</script><?php
	}
}

if ( isset($speedplus_optimini_options['create_robots_txt']) ) {
	// Create robots.txt file
	add_filter( 'robots_txt', function( $output, $public ) {
		if ( '0' == $public ) {
			$output = "User-agent: *\nDisallow: /\nDisallow: /*\nDisallow: /*?\n";
		} else {
			// Remove WP text
			$oldtext1 = preg_replace( '/Allow: [^\0\s]*\/wp-admin\/admin-ajax\.php\n/', '', $output );
			if ( null !== $oldtext1 ) {
				$output = $oldtext1;
			}
			$site_url = parse_url( site_url() );
			$path     = ( ! empty( $site_url[ 'path' ] ) ) ? $site_url[ 'path' ] : '';
			$output .= "# SpeedPlus OptiMini\n";
			// All
			foreach(['css','js'] as $ext){
				$output .= "Allow: /*.{$ext}\n";
			}
			foreach(['uploads'] as $afolder){
				$output .= "Allow: /{$afolder}\n";
			}
			foreach(['png','jpg','jpeg','gif'] as $wpfile){
				$output .= "Allow: /wp-*.{$wpfile}\n";
			}
			foreach(['cgi-bin','wp-admin','sdm_downloads','cart','checkout','*attachment*','?*','readme.html','xmlrpc.php','wp-'] as $dfolder){
				$output .= "Disallow: /{$dfolder}\n";
			}
			foreach(['trackback','feed','rss','embed*','sdm_downloads*','wp-json*'] as $dzfolder){
				$output .= "Disallow: */{$dzfolder}\n";
			}
			foreach(['wp-includes','search','author','users'] as $dsfolder){
				$output .= "Disallow: /{$dsfolder}/\n";
			}
			foreach(['?filter*','?add-to-cart*','?s=','&s=','utm=','openstat=','?replytocom'] as $zlink){
				$output .= "Disallow: *{$zlink}\n";
			}
			$output .= "Host: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}\n";
			$output .= "Sitemap: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}/sitemap.xml\n\n";
			// GoogleBot
			$output .= "User-agent: GoogleBot\n";
			foreach(['css','js'] as $ext){
				$output .= "Allow: /*.{$ext}\n";
			}
			foreach(['uploads','wp-admin/admin-ajax.php'] as $afolder){
				$output .= "Allow: /{$afolder}\n";
			}
			foreach(['png','jpg','jpeg','gif'] as $wpfile){
				$output .= "Allow: /wp-*.{$wpfile}\n";
			}
			foreach(['cgi-bin','wp-admin','sdm_downloads','cart','checkout','*attachment*','?*','readme.html','xmlrpc.php'] as $dfolder){
				$output .= "Disallow: /{$dfolder}\n";
			}
			foreach(['trackback','feed','rss','embed*','sdm_downloads*','wp-json*'] as $dzfolder){
				$output .= "Disallow: */{$dzfolder}\n";
			}
			foreach(['wp-includes','search','author','users'] as $dsfolder){
				$output .= "Disallow: /{$dsfolder}/\n";
			}
			foreach(['?filter*','?add-to-cart*','?s=','&s=','utm=','openstat=','?replytocom'] as $zlink){
				$output .= "Disallow: *{$zlink}\n";
			}
			$output .= "Sitemap: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}/sitemap.xml\n\n";
			// Yandex
			$output .= "User-agent: Yandex\n";
			foreach(['css','js'] as $ext){
				$output .= "Allow: /*.{$ext}\n";
			}
			foreach(['uploads','wp-admin/admin-ajax.php'] as $afolder){
				$output .= "Allow: /{$afolder}\n";
			}
			foreach(['png','jpg','jpeg','gif'] as $wpfile){
				$output .= "Allow: /wp-*.{$wpfile}\n";
			}
			foreach(['cgi-bin','wp-admin','sdm_downloads','cart','checkout','*attachment*','?*','readme.html','xmlrpc.php'] as $dfolder){
				$output .= "Disallow: /{$dfolder}\n";
			}
			foreach(['trackback','feed','rss','embed*','sdm_downloads*','wp-json*'] as $dzfolder){
				$output .= "Disallow: */{$dzfolder}\n";
			}
			foreach(['wp-includes','search','author','users'] as $dsfolder){
				$output .= "Disallow: /{$dsfolder}/\n";
			}
			foreach(['?filter*','?add-to-cart*','?s=','&s=','utm=','openstat=','?replytocom'] as $zlink){
				$output .= "Disallow: *{$zlink}\n";
			}
			$output .= "Sitemap: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}/sitemap.xml";
		}
		return $output;
	}, 99, 2 );
}

// Stop war in Ukraine 
if ( isset($speedplus_optimini_options['stop_war_in_ukraine']) ) {
	function no_war_html() { ?>
		<a href="https://bank.gov.ua/en/news/all/natsionalniy-bank-vidkriv-spetsrahunok-dlya-zboru-koshtiv-na-potrebi-armiyi" class="em-ribbon" style="position: absolute; left:0; top:0; width: 90px; height: 90px; background: url('/wp-content/plugins/speedplus-optimini/includes/stop-war-in-ukraine-2.png'); z-index: 2013; border: 0;" title="Do something to stop this war! Russians are killing our children and civilians!" target="_blank"></a>
		<?php }
	add_action( 'wp_head', 'no_war_html' );
}	

// Remove post's links in head: to index page, random/parent/next/previous posts (1.3.0)
if ( isset($speedplus_optimini_options['posts_links_in_head']) ) {
	remove_action('wp_head', 'index_rel_link'); // remove link to index page
	remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
	remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	add_filter( 'wpseo_next_rel_link', '__return_false' ); // Remove Yoast SEO Prev/Next URL from all pages
	add_filter( 'wpseo_prev_rel_link', '__return_false' ); // Remove Yoast SEO Prev/Next URL from all pages
}

// Disable plugins and themes updates (1.3.0)
if ( isset($speedplus_optimini_options['wp_core_updates']) ) {
	add_filter( 'auto_update_plugin', '__return_false' );
	add_filter( 'auto_update_theme', '__return_false' );
}

// Disable applications passwords (1.3.0)
if ( isset($speedplus_optimini_options['app_passwords']) ) {
	add_filter( 'wp_is_application_passwords_available_for_user', '__return_false' );
}

if ( isset($speedplus_optimini_options['outofstock_query']) ) {
	// Hide out of stock Woocommerce products in Shop, Category and Tag
	add_filter( 'woocommerce_product_query_meta_query', 'speedplus_optimini_outofstock_query_shop', 10, 2 );
	function speedplus_optimini_outofstock_query_shop( $meta_query, $query ) {
		if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())){
			// Exclude products "out of stock"
			$meta_query[] = array(
				'key'     => '_stock_status',
				'value'   => 'outofstock',
				'compare' => '!=',
			);
		}
		return $meta_query;
	}
	// Hide out of stock in Related products
	function speedplus_optimini_outofstock_query_related( $option ){
		return 'yes';
	}
	add_action( 'woocommerce_before_template_part', function( $template_name ) {
		if( $template_name !== "single-product/related.php" ) {
			return;
		}
		add_filter( 'pre_option_woocommerce_hide_out_of_stock_items', 'speedplus_optimini_outofstock_query_related' );
	} );
	add_action( 'woocommerce_after_template_part', function( $template_name ) {
		if( $template_name !== "single-product/related.php" ) {
			return;
		}
		remove_filter( 'pre_option_woocommerce_hide_out_of_stock_items', 'speedplus_optimini_outofstock_query_related' );
	} );
}