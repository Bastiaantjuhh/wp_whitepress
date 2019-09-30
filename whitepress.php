<?php
/**
 * Plugin Name:       Whitepress
 * Description:       WhiteLabel WordPress plugin. clean-up a lot of Junk from the page
 * Version:           1.0.0
 * Author:            Bastiaan de Hart
 * Author URI:        https://bastiaandehart.com/
 */

$whitepressDisableEmojiStyle          = true;
$whitepressDisableAPI                 = true;
$whitepressDisablePrefetchDNS         = true;
$whitepressDisableDangitP             = true;
$whitepressDisableMetaGenerator       = true;
$whitepressDisableRecentCommentStyle  = true;
$whitepressDisableEmbedWP             = true;
$whitepressDisablejQuery              = true;
$whitepressDisableHeadJunkTags        = true;
$whitepressDisableBlockLib            = true;

if ($whitepressDisableEmojiStyle === true) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

if ($whitepressDisableAPI === true) {
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('template_redirect', 'rest_output_link_header', 11);
}

if ($whitepressDisablePrefetchDNS === true) {
    remove_action( 'wp_head', 'wp_resource_hints', 2, 99 ); 
}

if ($whitepressDisableDangitP === true) {
    // http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit
    remove_filter('the_title', 'capital_P_dangit', 11);
    remove_filter('the_content', 'capital_P_dangit', 11);
    remove_filter('comment_text', 'capital_P_dangit', 31);
}

if ($whitepressDisableMetaGenerator === true) {
    remove_action('wp_head', 'wp_generator');
    add_filter('the_generator', '__return_false');
}

if ($whitepressDisableRecentCommentStyle === true) {
    function remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }
    add_action('widgets_init', 'remove_recent_comments_style');
}

if ($whitepressDisableEmbedWP === true) {
    function my_deregister_scripts(){
        wp_deregister_script( 'wp-embed' );
    }

    add_action( 'wp_footer', 'my_deregister_scripts' );
}

if ($whitepressDisablejQuery === true) {
    function change_default_jquery($scripts){
        if(!is_admin()){ $scripts->remove( 'jquery'); }
    }

    add_filter( 'wp_default_scripts', 'change_default_jquery' );
}
    
if ($whitepressDisableHeadJunkTags === true) {
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'index_rel_link'); 
    remove_action('wp_head', 'wlwmanifest_link'); 
    remove_action('wp_head', 'start_post_rel_link', 10, 0); 
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); 
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); 
}

if ($whitepressDisableBlockLib === true) {
    add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );

    function wps_deregister_styles() {
        wp_dequeue_style( 'wp-block-library' );
    }
}
?>