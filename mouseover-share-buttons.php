<?php
/**
 * Plugin Name: Mouseover Sharebuttons by Newsgrape
 * Plugin URI: 
 * Description: description
 * Version: 0.1
 * Author: Newsgrape
 * Author URI: https://www.newsgrape.com
 */



$plugin_dir = dirname(__FILE__);

@require_once "$plugin_dir/options.php";

function ngsb_sharebuttons_init(){
  wp_register_script('ajax-share-buttons', plugins_url(basename(dirname(__FILE__))) . '/js/ajax-widgets.js', array(
    'jquery',
  ));
  wp_enqueue_script('ajax-share-buttons');
}

add_action('init', 'ngsb_sharebuttons_init');

?>
