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

function ngsb_head() {
  $ngsb_img_path =plugins_url(basename(dirname(__FILE__)) ) . '/img/ngsb_button_row.png';
  $ngsb_css = '
    .lazy-share-widget {
      font-size:11px;
      font-style:normal;
      font-weight:bold;
      min-width:211px;
      height:20px;
      margin-top:12px;
      background:#fff url('.$ngsb_img_path.') 0 0 no-repeat;
      float:left;
    }
    .lazy-share-widget .platform {
      height:20px;
      float:left;
      display:inline;
    }
  ';
  echo '<style type="text/css">'.$ngsb_css.'</style>';
}

function ngsb_generate_html($post){

  $post_id = $post->ID;


  $html = '
    <div class="lazy-share-widget" id="sharing-'.$post_id.'">
      <div class="platform facebook" id="fb-newshare-'.$post_id.'"></div>
      <div class="platform twitter" id="tweet-newshare-'.$post_id.'"></div>
      <div class="platform gplus"><span id="gplus-newshare-'.$post_id.'"></span></div>
      <div class="platform linkedin" id="pinterest-newshare-'.$post_id.'"></div>
      <div class="ngsb-post-title" style="display:none;">'.$post->post_title.'</div>
      <div class="ngsb-post-url" style="display:none;">'.get_permalink($post_id).'</div>
    </div>    
  ';

  return $html;
}

function ngsb_share_buttons_before($title){
  global $post;
  
  if(!in_the_loop() or !(is_front_page() or is_category() or is_archive())) {
    return $title;
  }
  $options = ngsb_get_options();

  if($options['enabled'] && $options['position'] == 'before'){
    $button = ngsb_generate_html($post);
    return $title . '<br />' . $button . '<br />';
  }else{
    return $title;
  }
}

function ngsb_share_buttons_after($tags){
  global $post;

   if(!in_the_loop() or !(is_front_page() or is_category() or is_archive())) {
    return $tags;
  }
 
  $options = ngsb_get_options();

  if($options['enabled'] && $options['position'] == 'after'){
    $button = ngsb_generate_html($post);
    return $tags . '<br />' . $button . '<br />';
  }else{
    return $tags;
  }
}

add_action('init', 'ngsb_sharebuttons_init');
add_action('wp_head', 'ngsb_head');
add_filter('the_title', 'ngsb_share_buttons_before');
add_filter('the_tags', 'ngsb_share_buttons_after');


?>
